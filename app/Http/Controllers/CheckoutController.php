<?php


namespace App\Http\Controllers;
use App\Repositories\CartRepository;
use App\Repositories\CheckoutRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use MP;


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

        $data = $this->setUpOrder($cookie->carrito, $forms);

        $url = $this->generatePaymentGateway(
            $formPayment->paymentMethod->value,
            $data
        );

        return response()->json(['data' => $url], 201);
    }

    protected function setUpOrder($cart, $forms){
        $productRepository = new ProductRepository();
        $cartRepository = new CartRepository();

        $clientForm = $this->dataClient(json_decode($forms->billing));

        $billingForm = $this->dataBilling(json_decode($forms->billMandatory));

        $deliveryForm = $this->dataDelivery(json_decode($forms->billing));

        $client = $this->repository->insertClient($clientForm);

        //Obtiene el carro completo
        $cart = $cartRepository->getCart($cart);

        $order = $this->repository->insertOrder($client, $cart);

        $webOrder = $this->repository->insertWebOrder($order, $cart);

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

            case 'Paypal':
                $method = new \App\PaymentMethods\Paypal;
                break;

            case 'Transferencia':
                $method = new \App\PaymentMethods\Transferencia;
                break;

        }

        return $method->setupPaymentAndGetRedirectURL($data['order'], $data['products'], $data['client']);
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

    public function dataDelivery($clientForm){
        return [
            'recibeEnvio' => $clientForm->firstName." ".$clientForm->lastName,
            'calleEnvio' => $clientForm->address,
            'coloniaEnvio' => $clientForm->suburb,
            'ciudadEnvio' => $clientForm->city,
            'estadoEnvio' => $clientForm->state,
            'telefonoEnvio' => $clientForm->phone,
            'cpEnvio' => $clientForm->zip
        ];
    }

    public function dataBilling($billingForm){
        if($billingForm->need == false){
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
        }else{
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
        }

    }

}
