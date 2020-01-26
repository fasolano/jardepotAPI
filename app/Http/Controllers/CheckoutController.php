<?php


namespace App\Http\Controllers;
use App\Repositories\CartRepository;
use App\Repositories\CheckoutRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class CheckoutController extends Controller {

    protected $user = null;
    protected $repository = null;

    public function __construct(Request $request){
        $api = new ApiTokenController();
        $cookie = json_decode($request->get('sessionCookie'));
        if($cookie->user && $cookie->api_token){
            $user = $api->evaluate($cookie);
            $this->repository = new CheckoutRepository();
        }
        if(!$user){
            echo json_encode(['data'=> 'Unauthorized. The user needs to be authenticated.', 'status' => 401]);
            die();
        }
    }

    public function index(Request $request){

        print_r($request->toArray());
        return;
    }

    public function createOrder(Request $request) {
        $allowedPaymentMethods = config('payment-methods.enabled');

        $forms = json_decode($request->get('forms'));
        $cookie = json_decode($request->get('sessionCookie'));
        $formPayment = json_decode($forms->payment);

        if($formPayment->paymentMethod->value == "Transferencia"){
            $data = $this->setUpQuotation($cookie->carrito, $forms);
            return response()->json(['data' => 'success'], 200);
        }else{
            $data = $this->setUpOrder($cookie->carrito, $forms, $formPayment->paymentMethod->value);

            $data['delivery'] = json_decode($forms->delivery);

            $url = $this->generatePaymentGateway(
                $formPayment->paymentMethod->value,
                $data
            );

            return response()->json(['data' => $url], 201);
        }

    }

    protected function setUpQuotation($cart, $forms){
        $cartRepository = new CartRepository();

        $clientForm = $this->dataClient(json_decode($forms->billing));

        $billingForm = $this->dataBilling(json_decode($forms->billMandatory), json_decode($forms->needBilling));

        $deliveryForm = $this->dataDelivery(json_decode($forms->billing), json_decode($forms->delivery));

        $billingDeleveryData = array_merge($deliveryForm, $billingForm);

        $client = $this->repository->insertClient($clientForm);

        $cart = $cartRepository->getCart($cart);

        $quotation = $this->repository->insertQuotation($client, $cart->total, json_decode($forms->delivery));

        $products = $cartRepository->getProductsFromCart($cart->id_carrito);

        $this->repository->insertProductsQuotation($products, $quotation, json_decode($forms->delivery));

        //Obtiene el carro completo
        $content = array();
        foreach ($products as $key => $product) {
            if($product->offer == 'si'){
                $precio = $product->oferta;
            }else{
                $precio = $product->priceweb;
            }
            $content[$key]["cantidad"] = $product->cantidad;
            $content[$key]["nombre"] = $product->producto;
            $content[$key]["precio"] = $precio;
            $content[$key]["productType"] = $product->productType;
            $content[$key]["brand"] = $product->brand;
            $content[$key]["mpn"] = $product->mpn;
        }
        $formDelivery = json_decode($forms->delivery);
        if($quotation->total < $formDelivery->deliveryMethod->min){
            $send['cantidad'] = 1;
            $send['nombre'] ='Manejo de Mercancía Envío paquetería';
            $send['precio'] = $formDelivery->deliveryMethod->cost;
            $send['productType'] = '';
            $send['brand'] = '';
            $send['mpn'] = '';
            array_push($content, $send);
        }

        $nombre = $clientForm['nombre']. " " .$clientForm['apellidos'];
        if($this->sendQuotationMail($clientForm['email'], $nombre, $quotation->idCotizaciones, $content)){
            return $this->sendAlertMail($clientForm, $billingDeleveryData, $quotation->idCotizaciones);
        }

    }

    protected function setUpOrder($cart, $forms, $payment){
        $productRepository = new ProductRepository();
        $cartRepository = new CartRepository();

        $clientForm = $this->dataClient(json_decode($forms->billing));

        $billingForm = $this->dataBilling(json_decode($forms->billMandatory), json_decode($forms->needBilling));

        $deliveryForm = $this->dataDelivery(json_decode($forms->billing), json_decode($forms->delivery));

        $client = $this->repository->insertClient($clientForm);

        //Obtiene el carro completo
        $cart = $cartRepository->getCart($cart);

        //Finaliza el carro para que no se vuelva a cargar
        $cartRepository->closeCart($cart);

        $order = $this->repository->insertOrder($client, $cart, json_decode($forms->delivery));

        $webOrder = $this->repository->insertWebOrder($order, $cart, $payment);

        $order->token = $webOrder->token;

        $billingDeleveryData = array_merge($deliveryForm, $billingForm, ['idPedidos' => $order->idPedidos]);

        $this->repository->insertDeliveryBilling($billingDeleveryData);

        $products = $cartRepository->getProductsFromCart($cart->id_carrito);

        $this->repository->insertProductsOrder($order, $products, json_decode($forms->delivery));

        return array("order" => $order, "products" => $products, 'client' => $clientForm);
    }

    protected function generatePaymentGateway($paymentMethod, $data) : string {
        switch ($paymentMethod){
            case 'MercadoPago':
                $method = new \App\PaymentMethods\MercadoPago;
                break;

            case 'PayPal':
                $method = new \App\PaymentMethods\Paypal;
                break;
        }

        return $method->setupPaymentAndGetRedirectURL($data['order'], $data['products'], $data['client'], $data['delivery']);
    }

    protected function sendAlertMail($clientForm, $billingDeleveryData, $quotation){
//        $destino = "fasolanof@gmail.com";
        $destino = "ventas@jardepot.com";
        $dia = date('d-m-Y');
        $hora = date('H:i:s');

        $data = [
            'nombre' => $clientForm['nombre']. " ". $clientForm['apellidos'],
            'telefono' => $clientForm['telefono'],
            'mail' => $clientForm['email'],
            'dia' => $dia,
            'hora' => $hora,
            'datos' => $billingDeleveryData,
            'cotizacion' => $quotation
        ];
        Mail::send('mails.webPucharse', $data, function ($message) use ($destino) {
            $message->to($destino)->subject
            ('Pedido en linea Jardepot');
            $message->from('sistemas1@jardepot.com', 'Sitemas Jardepot');
        });
    }

    protected function sendQuotationMail($correo, $nombre, $quotation, $content){
//        $url = 'http://digicom.mx/instalar_virus/sitios/jardepot/ventas/cotizaciones/enviarCotizacionDesdePagina.php';
//        $url = 'http://koot.mx/digicom/public/instalar_virus/sitios/jardepot/ventas/cotizaciones/enviarCotizacionDesdePagina.php';
//        $url = 'https://jardepot.com/digicom/public/instalar_virus/sitios/jardepot/ventas/cotizaciones/enviarCotizacionDesdePagina.php';
        $url = 'https://www.jardepot.com/digicom/public/instalar_virus/sitios/jardepot/ventas/cotizaciones/prueba.txt';
        $fields = array(
            'para' => urlencode($correo),
            'nombre' => urlencode($nombre),
            'quotation' => urlencode($quotation),
            'content' => urlencode(serialize($content))
        );

        $fields_string = "";
        //url-ify the data for the POST
        foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
        rtrim($fields_string, '&');

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
//        curl_setopt($ch,CURLOPT_POST, count($fields));
//        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        if(curl_exec($ch) === false)
        {
            echo 'Curl error: ' . curl_error($ch);
        }
        else
        {
            echo 'Operación completada sin errores';
        }
        //execute post
//        $result = curl_exec($ch);

        //close connection
        curl_close($ch);
        die();

        return true;
    }

    public function dataClient($clientForm){
        return [
            'nombre' => $clientForm->firstName,
            'apellidos' => $clientForm->lastName,
            'email' => $clientForm->email,
            'telefono' => $clientForm->phone,
            'estado' => $clientForm->state,
            'ciudad' => $clientForm->city,
            'colonia' => $clientForm->suburb,
            'cp' => $clientForm->zip,
            'direccion' => $clientForm->address
        ];
    }

    public function dataDelivery($clientForm, $delivery){
        switch ($delivery->deliveryMethod->value){
            case "domicilio":
                return [
                    'recibeEnvio' => $clientForm->firstName." ".$clientForm->lastName,
                    'calleEnvio' => $clientForm->address,
                    'coloniaEnvio' => $clientForm->suburb,
                    'ciudadEnvio' => $clientForm->city,
                    'estadoEnvio' => $clientForm->state,
                    'telefonoEnvio' => $clientForm->phone,
                    'cpEnvio' => $clientForm->zip
                ];
                break;

            case "cuernavaca":
                return [
                    'recibeEnvio' => "Recoge en tienda cuernavaca",
                    'calleEnvio' => "Recoge en tienda cuernavaca",
                    'coloniaEnvio' => "Recoge en tienda cuernavaca",
                    'ciudadEnvio' => "Recoge en tienda cuernavaca",
                    'estadoEnvio' => "MORELOS",
                    'telefonoEnvio' => "",
                    'cpEnvio' => ""
                ];
                break;

            case "pachuca":
                return [
                    'recibeEnvio' => "Recoge en tienda pachuca",
                    'calleEnvio' => "Recoge en tienda pachuca",
                    'coloniaEnvio' => "Recoge en tienda pachuca",
                    'ciudadEnvio' => "Recoge en tienda pachuca",
                    'estadoEnvio' => "Hidalgo",
                    'telefonoEnvio' => "",
                    'cpEnvio' => ""
                ];
                break;
        }
    }

    public function dataBilling($billingForm, $needBilling){
        if($needBilling){
            return [
                'razonSocialFacturacion' => $billingForm->socialReason,
                'tipoPersonaFacturacion' => $billingForm->typePerson,
                'rfcFacturacion' => $billingForm->rfc,
                'calleFacturacion' => $billingForm->address,
                'ciudadFacturacion' => $billingForm->city,
                'estadoFacturacion' => $billingForm->state,
                'correoFacturacion' => $billingForm->email,
                'cpFacturacion' => $billingForm->zip,
                'metodoDePagoFacturacion' => 'PUE Pago en una sola exhibición',
                'formaDePagoFacturacion' => '03 Transferencia electrónica de fondos',
                'usoDelCFDIFacturacion' => $billingForm->usoCFDI
            ];
        }else{
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

}
