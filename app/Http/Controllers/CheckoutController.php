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
        $user = Auth::guard()->user();
        $productRepository = new ProductRepository();
        $cartRepository = new CartRepository();

        $cookie = json_decode($request->get('sessionCookie'));

        $cart = isset($cookie->carrito)? $cookie->carrito: false;

        //Si no se mando o si no se encuentra activo o no pertenece al usuario se crea uno nuevo
        if($cart && $cartRepository->verifyCart($user, $cart)){
            $cartRepository->updateCart($cart);
            $this->setUpOrder($cart, $request);

        }
        return json_encode(1);
//        return response()->json(['data' => 'successful'], 201);
    }

    public function createOrder(Request $request) {
        $allowedPaymentMethods = config('payment-methods.enabled');

        $order = $this->setUpOrder($request);

//        $this->notify($order);
        $url = $this->generatePaymentGateway(
            $request->get('payment_method'),
            $order
        );
        return redirect()->to($url);
    }

    protected function setUpOrder($cart, Request $request){
        $productRepository = new ProductRepository();
        $cartRepository = new CartRepository();

        $clienteForm = $this->datosCli();

        $client = $this->repository->insertClient($clienteForm);

        //Obtiene el carro completo
        $cart = $cartRepository->getCart($cart);

        $order = $this->repository->insertOrder($client, $cart);

        $products = $cartRepository->getProductsFromCart($cart->id_carrito);

        $this->repository->insertProductsOrder($order, $products);

    }

    protected function generatePaymentGateway($paymentMethod, $order) : string {
        $method = new \App\PaymentMethods\MercadoPago;

        return $method->setupPaymentAndGetRedirectURL($order);
    }

    public function datosCli(){
        return [
            'nombre' => 'Fernando',
            'apellidos' => 'Solano',
            'email' => 'algo@algo.com',
            'telefono' => '3155382',
            'estado' => 'Morelos',
            'ciudad' => 'Cuernavaca',
            'colonia' => 'Tulipanes',
            'cp' => '62388',
            'direccion' => 'Tulipan Venezolano #14'
        ];
    }

    public function datosCart(){
        return [
            'nombre' => 'Fernando',
            'apellidos' => 'Solano',
            'correo' => 'algo@algo.com',
            'telefono' => '3155382',
            'estado' => 'Morelos',
            'ciudad' => 'Cuernavaca'
        ];
    }

}
