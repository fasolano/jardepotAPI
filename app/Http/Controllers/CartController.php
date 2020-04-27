<?php


namespace App\Http\Controllers;


use App\Http\Controllers\Auth\RegisterController;
use App\Repositories\CartRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller {

    protected $user = null;
    protected $repository = null;

    public function __construct(Request $request){
        $api = new ApiTokenController();
        $cookie = json_decode($request->get('sessionCookie'));
        if($cookie == ""){
            $this->user = null;
        }else{
            $this->user = $api->evaluate($cookie);
        }
    }

    public function addProduct(Request $request){
        if(!$this->user){
            return response()->json(null, 204);
        }
        $user = Auth::guard()->user();
        $productRepository = new ProductRepository();
        $repository = new CartRepository();
        $cookie = json_decode($request->get('sessionCookie'));
        $product = json_decode($request->get('product'));
        $quantity = json_decode($request->get('quantity'));
        $cart = isset($cookie->carrito)? $cookie->carrito: false;

        //Si no se mando o si no se encuentra activo o no pertenece al usuario se crea uno nuevo
        if(!$cart || !$repository->verifyCart($user, $cart)){
            $cart = $repository->addCart($user);
        }
        $product = $productRepository->getProduct($product->productType, $product->brand, $product->mpn)[0];
        $productAdded = $repository->addProductCart($cart, $product->productType." ".$product->brand." ".$product->mpn, $quantity);
        $repository->updateCart($cart);

        return response()->json(['data' => 'successful'], 201);
    }

    public function getCartProducts(Request $request){
        $cookie = json_decode($request->get('sessionCookie'));
        if(!$this->user || $cookie == ""){
            return response()->json(null, 204);
        }
        $user = Auth::guard()->user();
        $repository = new CartRepository();
        $productController = new ProductController();
        $cart = isset($cookie->carrito)? $cookie->carrito: false;
        if($cart && $repository->verifyCart($user, $cart)){
            $products = $repository->getProductsFromCart($cart);
            $cart = $productController->model_format_products($products);
            $cart = count($cart)>0?$cart:array();
            return response()->json([json_encode($cart)], 201);
        }else{
            return response()->json(null, 204);
        }
    }

    public function removeProductCart(Request $request){
        if(!$this->user){
            return response()->json(null, 204);
        }
        $user = Auth::guard()->user();
        $productRepository = new ProductRepository();
        $repository = new CartRepository();
        $cookie = json_decode($request->get('sessionCookie'));
        $product = $request->get('product');
        $cart = isset($cookie->carrito)? $cookie->carrito: false;
        if($cart && $repository->verifyCart($user, $cart)){
            $repository->removeProduct($cart, $product);
            $repository->updateCart($cart);
            return response()->json(['data' => 'successful'], 201);
        }else{
            return response()->json(null, 204);
        }
    }

}
