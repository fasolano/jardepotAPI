<?php


namespace App\Http\Controllers;


use App\Repositories\ConfirmRepository;
use Illuminate\Http\Request;

class ConfirmController extends Controller {

    protected $repository = null;

    public function index(Request $request){
        $this->repository = new ConfirmRepository();
        $content = json_decode($request->get('data'));
        $state = $request->get('state');
        $payment = $request->get('payment');
        if($state == "success"){
            switch ($payment){
                case 'MercadoPago':
                    $token = $content->external_reference;
                    $order = $this->repository->verifyTokenAndPaymentMethod($payment, $token);
                    $this->repository->createDeposit();
                    break;

                case 'PayPal':

                    break;
            }
        }else{
            return response()->json(['data' => 'denied'], 206);
        }


    }
}
