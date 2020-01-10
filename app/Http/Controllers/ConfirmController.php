<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;

class ConfirmController extends Controller {

    public function index(Request $request){
        $content = unserialize($request->get('data'));
        $state = $request->get('state');
        $payment = $request->get('payment');
    }
}
