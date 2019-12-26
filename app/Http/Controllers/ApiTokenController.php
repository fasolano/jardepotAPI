<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisterController;
use App\Repositories\CartRepository;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ApiTokenController extends Controller {

    use AuthenticatesUsers;

    public function evaluate($cookie){
        $user = null;
        if($cookie->user && $cookie->api_token) {
            $userController = new User();
            $user = $userController->getUserByTokenAndId($cookie->user, $cookie->api_token);
            if($user){
                $user = $this->guard()->loginUsingId($user->id);
            }else{
                $user = null;
            }
        }else{
            $registro = new RegisterController();
            $user = $registro->register();
        }
        return $user;
    }

    public function getSession(Request $request){
        $user = null;
        $registro = new RegisterController();
        $user = $registro->register();

        //Tambien se inicia el carrito para que se agreguen los productos
        $carritoController = new CartRepository();
        $carrito = $carritoController->addCart($user);

        return $user->getSession($carrito);
    }

}
