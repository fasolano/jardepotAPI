<?php


namespace App\Http\Controllers;

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
            $cantidadProducts = $repository->calculateTotalProducts($cart);
            $carrito = $repository->getCart($cart);
//            $cart = $productController->model_format_products($products);
            $cart = $this->model_format_products($products);
            $cart = count($cart)>0?$cart:array();
            $result = ['cart'=>$cart,'total'=>$carrito->total,'quantityProducts'=>$cantidadProducts];
            return response()->json([json_encode($result)], 201);
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

    public function removeAllProducts(Request $request){
        if(!$this->user){
            return response()->json(null, 204);
        }
        $user = Auth::guard()->user();
        $repository = new CartRepository();
        $cookie = json_decode($request->get('sessionCookie'));

        $cart = isset($cookie->carrito)? $cookie->carrito: false;

        if($cart && $repository->verifyCart($user, $cart)){
            $products = $repository->getProductsFromCart($cart);
            foreach ($products as $product){
                $name = $product->productType.' '.$product->brand.' '.$product->mpn;
                $repository->removeProduct($cart, $name);
            }
            $repository->updateCart($cart);
            return response()->json(['data' => 'successful'], 201);
        }else{
            return response()->json(null, 204);
        }
    }

    //esta en unicamente para productos de carrito
    public function model_format_products($products) {
        $iterator = 0;
        $response = array();
        foreach ($products as $item) {
            $img = strtolower($item->productType . "-" . $item->brand . "-" . $item->mpn);
            $response[$iterator]['id'] = $item->id;
            $response[$iterator]['name'] = $item->productType . " " . $item->brand . " " . $item->mpn;
            $response[$iterator]['images'][0]['small'] = 'assets/images/productos/medium/' . $img . '.jpg';
            $response[$iterator]['images'][0]['medium'] = 'assets/images/productos/medium/' . $img . '.jpg';

            //empieza la seccion de precios
            if (isset($item->offer) && $item->offer == 'si') {
                $response[$iterator]['discount'] = "Oferta";

                if ($item->PrecioDeLista > $item->oferta) {
                    $response[$iterator]['oldPrice'] = $item->PrecioDeLista;
                    $response[$iterator]['newPrice'] = $item->oferta;
                }
                else {
                    $response[$iterator]['newPrice'] = $item->oferta;
                }
            }
            else {
                if ($item->PrecioDeLista > $item->price) {
                    $response[$iterator]['oldPrice'] = $item->PrecioDeLista;
                    $response[$iterator]['newPrice'] = $item->price;
                }
                else {
                    $response[$iterator]['newPrice'] = $item->price;

                }
            }
            //termina seccion de precios
            $response[$iterator]['availibilityCount'] = 100;
            $response[$iterator]['stock'] = $item->availability == 'in stock' ? true : false;
            if (isset($item->cantidad)) {
                $response[$iterator]['cartCount'] = $item->cantidad;
            }
            else {
                $response[$iterator]['cartCount'] = 0;
            }
            $response[$iterator]['brand'] = $item->brand;
            $response[$iterator]['mpn'] = $item->mpn;
            $response[$iterator]['productType'] = $item->productType;
            $response[$iterator]['inventory'] = $item->cantidadInventario;

            $iterator++;
        }
        return $response;
    }

}
