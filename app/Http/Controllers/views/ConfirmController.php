<?php


namespace App\Http\Controllers\views;


use App\Http\Controllers\Controller;
use App\Repositories\CartRepository;
use App\Repositories\CheckoutRepository;
use App\Repositories\ConfirmRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\PaymentMethods\MercadoPago;
use App\PaymentMethods\Paypal;

class ConfirmController extends Controller {

    public function confirmPaypal($orderID, Request $request){
        $repository = new ConfirmRepository();
        $clientForm = json_decode($request->get('form'));
        $address = $request->get('address');
        $name = $request->get('name');
        $cookie = json_decode($request->get('session'));
        $state = "failure";
        $payment = "Paypal";
        $repositoryCheckout = new CheckoutRepository();
        if (!$cookie) {
            return view("pages/confirm", compact('state', 'payment'));
        }
        $order = $this->validateButtonID($orderID);
        if ($order == null) {
            return view("pages/confirm", compact('state', 'payment'));
        }

        $cartRepository = new CartRepository();

        //Obtiene el carro completo
        $cart = $cartRepository->getCart($cookie->carrito);

        $state = "success";
        if (!$cart) {
            return view("pages/confirm", compact('state', 'payment'));
        }

        $address = explode(",", $address);
        $clientData = $this->dataClient($clientForm, $address);
        $client = $repositoryCheckout->insertClient($clientData);

        $order = $repository->insertOrder($client, $cart->total);
        $webOrder = $repositoryCheckout->insertWebOrder($order, $cart, $payment);
        $order = $repository->verifyTokenAndPaymentMethod($payment, $webOrder->token);


        //Finaliza el carro para que no se vuelva a cargar
        $cartRepository->closeCart($cart);

        $order->token = $webOrder->token;
        $mailSeller = $repositoryCheckout->setSellerToOrder($order->idPedidos);

        // $this->repository->createDeposit($order->total, $order->idPedidos, $payment, $order->fk_carrito);

        $billingForm = $this->dataBilling();
        $deliveryForm = $this->dataDelivery($address, $name);

        $billingDeleveryData = array_merge($deliveryForm, $billingForm, ['idPedidos' => $order->idPedidos], ['id_cliente' => $client]);
        $repositoryCheckout->insertDeliveryBilling($billingDeleveryData);

        $products = $cartRepository->getProductsFromCartFinal($cart->id_carrito);
        $repository->insertProductsOrder($order, $products);

        $this->sendAlertMailOrder($clientData, $order->idPedidos, $payment, $mailSeller);

        return view("pages/confirm", compact('state', 'payment'));
    }

    public function confirmMercadopago($state, Request $request){
        if ($state == "failure"){
            return view("pages/confirm", compact('state', 'payment'));
        }
        $payment = "MercadoPago";
        $cartID = json_decode($request->get('external_reference'));
        $preference_id = $request->get('preference_id');
        $state = $this->mercadopayment($preference_id, $cartID);

        return view("pages/confirm", compact('state', 'payment'));
    }

    public function validateButtonID($id){
        $paypal = new Paypal();
        return $paypal->validateID($id);
    }

    function mercadopayment($preferenceID, $cartID){
        $cartRepository = new CartRepository();
        $repositoryCheckout = new CheckoutRepository();
        $repository = new ConfirmRepository();
        $cart = $cartRepository->getCart($cartID);
        if (!$cart) {
            return 'failure';
        }
        $payment = 'MercadoPago';

        $preference = $this->getExternalReference($preferenceID);
        $preference = json_decode($preference);

        $phone = $preference->payer->phone->number;
        $mail = $preference->payer->email;
        $client = $repository->getClientFromMailPhone($mail, $phone);
        $total = 0;
        foreach ($preference->items as $item) {
            $total += $item->unit_price * $item->quantity;
        }
        $order = $repository->insertOrder($client->idClientes, $total);
        $webOrder = $repositoryCheckout->insertWebOrder($order, $cart, $payment);
        $order = $repository->verifyTokenAndPaymentMethod($payment, $webOrder->token);

        //Finaliza el carro para que no se vuelva a cargar
        $cartRepository->closeCart($cart);

        $order->token = $webOrder->token;
        $mailSeller = $repositoryCheckout->setSellerToOrder($order->idPedidos);

        // $this->repository->createDeposit($order->total, $order->idPedidos, $payment, $order->fk_carrito);

        $billingForm = $this->dataBilling();
        $deliveryForm = $this->dataDeliveryMercado($preference->shipments->receiver_address, $preference->payer);

        $billingDeleveryData = array_merge($deliveryForm, $billingForm, ['idPedidos' => $order->idPedidos], ['id_cliente' => $client->idClientes]);
        $repositoryCheckout->insertDeliveryBilling($billingDeleveryData);

        $products = $cartRepository->getProductsFromCartFinal($cart->id_carrito);
        $repository->insertProductsOrder($order, $products);
        $clientData = (array) $client;
        $clientData['email'] = $clientData['correo'];
        $clientData['apellidos'] = "";
        $this->sendAlertMailOrder($clientData, $order->idPedidos, $payment, $mailSeller);

        return 'success';
    }

    public function getExternalReference($preference_id){
        $mercado_pago = new MercadoPago();
        return $mercado_pago->verifyPayment($preference_id);
    }

    public function sendAlertMailOrder($clientForm, $order, $payment, $mailSeller){
        // $destino = "fasolanof@gmail.com";
        $destino = "alcocer@jardepot.com";
        //$destino = $mailSeller;

        $dia = date('d-m-Y');
        $hora = date('H:i:s');
        $name = $clientForm['nombre']. " ". $clientForm['apellidos'];
        $data = [
            'nombre' => $name,
            'telefono' => $clientForm['telefono'],
            'mail' => $clientForm['email'],
            'dia' => $dia,
            'hora' => $hora,
            'order' => $order,
            'payment' => $payment
        ];
        Mail::send('mails.webOrder', $data, function ($message) use ($destino, $payment) {
            $message->to($destino)->subject
            ('Compra en Línea '.$payment);
            $message->from('sistemas1@jardepot.com', 'Sitemas Jardepot');
        });
    }

    public function dataClient($client, $address){
        return [
            'nombre' => $client->firstName,
            'apellidos' => $client->lastName,
            'email' => $client->email,
            'telefono' => $client->phone,
            'cp' => $address[4],
            'estado' => $address[3],
            'ciudad' => $address[2],
            'colonia' => $address[1],
            'direccion' => $address[0]
        ];
    }

    public function dataBilling(){
        return [
            'razonSocialFacturacion' => '',
            'tipoPersonaFacturacion' => 'general',
            'rfcFacturacion' => '',
            'calleFacturacion' => '',
            'ciudadFacturacion' => '',
            'estadoFacturacion' => '',
            'correoFacturacion' => '',
            'cpFacturacion' => '',
            'metodoDePagoFacturacion' => 'PUE Pago en una sola exhibición',
            'formaDePagoFacturacion' => '03 Transferencia electrónica de fondos',
            'usoDelCFDIFacturacion' => 'G01 Adquisición de mercancías'
        ];

    }

    public function dataDelivery($address, $name){
        return [
            'recibeEnvio' => $name,
            'calleEnvio' => $address[0],
            'coloniaEnvio' => $address[1],
            'ciudadEnvio' => $address[2],
            'estadoEnvio' => $address[3],
            'cpEnvio' => $address[4]
        ];
    }

    public function dataDeliveryMercado($shipment, $payer){
        $street = explode(',', $shipment->street_name);
        return [
            'recibeEnvio' => $payer->name." ".$payer->surname,
            'calleEnvio' => $street[1],
            'coloniaEnvio' => $street[0],
            'ciudadEnvio' => $shipment->city_name,
            'estadoEnvio' => $shipment->state_name,
            'cpEnvio' => $shipment->zip_code
        ];
    }

}
