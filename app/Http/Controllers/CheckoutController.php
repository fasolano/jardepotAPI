<?php


namespace App\Http\Controllers;
use App\PaymentMethods\MercadoPago;
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

    public function createOrder(Request $request) {
        $forms = json_decode($request->get('forms'));
        $cookie = json_decode($request->get('sessionCookie'));
        $formPayment = json_decode($forms->payment);

        if($formPayment->value == "Transferencia"){
            if ($this->setUpQuotation($cookie->carrito, $forms)){
                return response()->json(['data' => 'success'], 200);
            }else{
                return response()->json(['data' => 'failure'], 200);
            }
        }else{
            return response()->json(['data' => 'failure'], 200);
        }

    }

    protected function getLinkPayment(Request $request) {
        $productRepository = new ProductRepository();
        $cartRepository = new CartRepository();

        $form = json_decode($request->get('form'));
        $cookie = json_decode($request->get('sessionCookie'));
        $clientForm = $this->dataClient($form);

        $client = $this->repository->insertClient($clientForm);
        $products = $cartRepository->getProductsFromCart($cookie->carrito);
        $mercado = new MercadoPago();
        $url = $mercado->setupPaymentAndGetRedirectURL($products, $clientForm, $cookie->carrito);
        return response()->json(['data' => $url, 'state' => 'success'], 201);
    }

    protected function setUpQuotation($cart, $forms){
        $cartRepository = new CartRepository();

        $clientForm = $this->dataClient(json_decode($forms->billing));

        $billingForm = $this->dataBilling(json_decode($forms->billMandatory), json_decode($forms->needBilling));

        $deliveryForm = $this->dataDelivery(json_decode($forms->billing), json_decode($forms->delivery));

        $billingDeleveryData = array_merge($deliveryForm, $billingForm);

        $client = $this->repository->insertClient($clientForm);

        $cart = $cartRepository->getCart($cart);
        $check = $this->repository->checkQuotation($client, $cart->total,$cart->id_carrito, json_decode($forms->delivery));

        if($check['exist'] == 'true'){
            $quotation =$check['quotation'];
            $products = $cartRepository->getProductsFromCart($cart->id_carrito);
        }else{
            $quotation = $this->repository->insertQuotation($client, $cart->total, json_decode($forms->delivery));

            $products = $cartRepository->getProductsFromCart($cart->id_carrito);

            $this->repository->insertProductsQuotation($products, $quotation, json_decode($forms->delivery));
        }

        //Obtiene el carro completo
        $content = array();
        foreach ($products as $key => $product) {
            if($product->offer == 'si'){
                $precio = $product->oferta;
            }else{
                $precio = $product->price;
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

        // $sellers = ["ventas1@jardepot.com", "ventas2@jardepot.com", "ventas4@jardepot.com", "ventas7@jardepot.com", "ventas8@jardepot.com", "ventas10@jardepot.com"];
        $ind = 5; // rand(0,5);
        // $mailSeller = $sellers[$ind];
        $mailSeller = 'ventas10@jardepot.com';
        $cartRepository->setSellerToCart($cart->id_carrito, $ind);

        if($this->sendQuotationMail($clientForm['email'], $nombre, $quotation->idCotizaciones, $content, $mailSeller)){
            // return true;
            return $this->sendAlertMail($clientForm, $billingDeleveryData, $quotation->idCotizaciones, $mailSeller);
        }else{
            return false;
        }

    }

    protected function sendAlertMail($clientForm, $billingDeleveryData, $quotation, $mailSeller){
        $dia = date('d-m-Y');
        $hora = date('H:i:s');
        $mailSeller = "svartpilen2020@gmail.com";//se puso para que solo se le envíe a Isra al personal
        $mailSeller = "ventas10@jardepot.com";
        $data = [
            'nombre' => $clientForm['nombre']. " ". $clientForm['apellidos'],
            'telefono' => $clientForm['telefono'],
            'mail' => $clientForm['email'],
            'dia' => $dia,
            'hora' => $hora,
            'datos' => $billingDeleveryData,
            'cotizacion' => $quotation
        ];
        Mail::send('mails.webPucharse', $data, function ($message) use ($mailSeller) {
            $message->to($mailSeller)->subject
            ('Pedido en linea Jardepot');
            $message->from('sistemas1@jardepot.com', 'Sitemas Jardepot');
        });
        return $mailSeller;
    }

    protected function sendQuotationMail($correo, $nombre, $quotation, $content, $mailSeller){
        $url = 'https://digicom.mx/instalar_virus/sitios/jardepot/ventas/cotizaciones/enviarCotizacionDesdePagina.php';

        $fields = array(
            'para' => urlencode($correo),
            'de' => urlencode($mailSeller),
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
        curl_setopt($ch,CURLOPT_POST, count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

        //execute post
        $result = curl_exec($ch);

        //close connection
        curl_close($ch);

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
