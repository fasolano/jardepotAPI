<?php


namespace App\Http\Controllers;


use App\PaymentMethods\MercadoPago;
use App\PaymentMethods\Paypal;
use App\Repositories\CartRepository;
use App\Repositories\CheckoutRepository;
use App\Repositories\ConfirmRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PayPal\Api\Payment;

class ConfirmController extends Controller {

    protected $repository = null;

    public function index(Request $request){
        $this->repository = new ConfirmRepository();
        $content = json_decode($request->get('data'));
        $state = $request->get('state');
        $payment = $request->get('payment');
        switch ($state){
            case 'success':
                switch ($payment) {
                    case 'MercadoPago':
                        $token = $request->get('token');
                        $order = $this->repository->verifyTokenAndPaymentMethod($payment, $token);
                        if ($order == null) {
                            return response()->json(['data' => 'failure'], 200);
                        }
                        //$this->repository->createDeposit($order->total, $order->idPedidos, $payment, $order->fk_carrito);
                        $this->sendConfirmationMails($order->idPedidos);
                        return response()->json(['data' => 'success'], 200);
                        break;

                    case 'PayPal':
                        $token = $this->getTokenFromPayment($content);
                        $order = $this->repository->verifyTokenAndPaymentMethod($payment, $token);
                        if ($order == null) {
                            return response()->json(['data' => 'failure'], 200);
                        }
                        $this->repository->createDeposit($order->total, $order->idPedidos, $payment, $order->fk_carrito);
                        $this->sendConfirmationMails($order->idPedidos);
                        return response()->json(['data' => 'success'], 200);
                        break;

                    case 'button':
                        $repositoryCheckout = new CheckoutRepository();
                        $cookie = json_decode($request->get('sessionCookie'));
                        if(!$cookie){
                            return response()->json(['data' => 'failure'], 200);
                        }
                        $token = $request->get('token');
                        $order = $this->validateButtonID($token);
                        if ($order == null){
                            return response()->json(['data' => 'failure'], 200);
                        }

                        $cartRepository = new CartRepository();

                        //Obtiene el carro completo
                        $cart = $cartRepository->getCart($cookie->carrito);

                        if (!$cart){
                            return response()->json(['data' => 'success'], 200);
                        }

                        $clientForm = json_decode($content->client);
                        $address = explode(",", $content->address);
                        $name = $content->name;
                        $clientData = $this->dataClient($clientForm, $address);
                        $client = $repositoryCheckout->insertClient($clientData);

                        $order = $this->repository->insertOrder($client, $cart);
                        $webOrder = $repositoryCheckout->insertWebOrder($order, $cart, $payment);
                        $order = $this->repository->verifyTokenAndPaymentMethod($payment, $webOrder->token);


                        //Finaliza el carro para que no se vuelva a cargar
                        $cartRepository->closeCart($cart);

                        $order->token = $webOrder->token;
                        $mailSeller = $repositoryCheckout->setSellerToOrder($order->idPedidos);

                        // $this->repository->createDeposit($order->total, $order->idPedidos, $payment, $order->fk_carrito);

                        $billingForm = $this->dataBilling();
                        $deliveryForm = $this->dataDelivery($address, $name);

                        $billingDeleveryData = array_merge($deliveryForm, $billingForm, ['idPedidos' => $order->idPedidos], ['id_cliente' =>$client]);
                        $repositoryCheckout->insertDeliveryBilling($billingDeleveryData);

                        $products = $cartRepository->getProductsFromCartFinal($cart->id_carrito);
                        $this->repository->insertProductsOrder($order, $products);

                        $this->sendAlertMailOrder($clientData, $order->idPedidos, $payment, $mailSeller);

                        return response()->json(['data' => 'success'], 200);
                        break;
                }
                break;

            case 'pending':
                return response()->json(['data' => 'pending'], 200);
                break;

            case 'failure':
                switch ($payment) {
                    case 'MercadoPago':
                        $client = $this->getClient($content->external_reference);
                        $this->sendFailedMail($client, $payment);
                        break;

                    case 'PayPal':
                        break;
                }
                return response()->json(['data' => 'failure'], 200);
                break;
        }
    }

    public function mercadopagoToken(Request $request){
        $content = json_decode($request->get('data'));
        $token = $this->getExternalReference($content->preference_id);
        if ($token == null) {
            return response()->json(['data' => 'failure'], 200);
        }
        return response()->json(['data' => $token], 200);
    }

    public function getClient($external_reference){
        $this->repository = new ConfirmRepository();
        $client = $this->repository->getClientFromToken($external_reference);
        return $client;
    }

    public function getTokenFromPayment($content){
        $paypal = new Paypal();
        $result = $paypal->executePayment($content->paymentId, $content->PayerID);
        $transactions = $result->getTransactions();
        foreach ($transactions as $transaction) {
            $token = $transaction->getDescription();
        }
        return $token;
    }

    public function getExternalReference($preference_id){
        $mercado_pago = new MercadoPago();
        return $mercado_pago->verifyPayment($preference_id);
    }

    public function sendConfirmationMails($order){
        $url = 'http://digicom.mx/instalar_virus/ajax/sitios/jardepot/ventas/correoProcesamientoPedido/web?idPedidos='.$order.'&mail=sistemas1@jardepot.com';
        //open connection
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_exec($ch);
        //close connection
        curl_close($ch);

        $url1 = 'http://digicom.mx/instalar_virus/sitios/jardepot/ventas/90-100/enviar90-100web.php?idPedidos='.$order.'&username=Sistemas&user_email=sistemas1@jardepot.com';
        //open connection
        $ch1 = curl_init();
        curl_setopt($ch1,CURLOPT_URL, $url1);
        curl_exec($ch1);
        //close connection
        curl_close($ch1);

        return true;

    }

    public function sendFailedMail($client, $payment){
        $destino = $client->correo;

        $data = [
            'name' => $client->nombre,
            'payment' => $payment,
        ];
        Mail::send('mails.failedPayment', $data, function ($message) use ($destino) {
            $message->to($destino)->subject
            ('Pedido en linea Jardepot');
            $message->from('sistemas1@jardepot.com', 'Sitemas Jardepot');
        });
    }

    public function notification(){
        $mp = new MercadoPago();
        $payment = $mp->notification($_GET);
//        $destino = 'fasolanof@gmail.com';
        $destino = 'contabilidad@jardepot.com';
        $data = ['data' => $payment];

        Mail::send('mails.pendingPayment', $data, function ($message) use ($destino) {
            $message->to($destino)->subject('Pedido en linea Jardepot');
            $message->from('sistemas1@jardepot.com', 'Sitemas Jardepot');
        });

        return response()->json(['data' => 'success'], 204);
    }

    public function validateButtonID($id){
        $paypal = new Paypal();
        return $paypal->validateID($id);
    }

    public function prueba(){
        $this->sendConfirmationMails(25);
    }

    public function sendAlertMailOrder($clientForm, $order, $payment, $mailSeller){
        // $destino = "fasolanof@gmail.com";
        $destino = "alcocer@jardepot.com";
        //$destino = $mailSeller;

        $dia = date('d-m-Y');
        $hora = date('H:i:s');

        $data = [
            'nombre' => $clientForm['nombre']. " ". $clientForm['apellidos'],
            'telefono' => $clientForm['telefono'],
            'mail' => $clientForm['email'],
            'dia' => $dia,
            'hora' => $hora,
            'order' => $order,
            'payment' => $payment
        ];
        Mail::send('mails.webOrder', $data, function ($message) use ($destino) {
            $message->to($destino)->subject
            ('Compra en Línea PAYPAL');
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

}
