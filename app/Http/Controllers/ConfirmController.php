<?php


namespace App\Http\Controllers;


use App\PaymentMethods\Paypal;
use App\Repositories\ConfirmRepository;
use Illuminate\Http\Request;

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
                        $token = $content->external_reference;
                        $order = $this->repository->verifyTokenAndPaymentMethod($payment, $token);
                        if ($order == null) {
                            return response()->json(['data' => 'failed'], 201);
                        }
                        $this->repository->createDeposit($order->total, $order->idPedidos, $payment, $order->fk_carrito);
                        return response()->json(['data' => 'success'], 201);
                        break;

                    case 'Paypal':
                        $url = 'https://api.sandbox.paypal.com/v2/payments/authorizations/'.$content->paymentId;

                        //open connection
                        $ch = curl_init();

                        //set the url, number of POST vars, POST data
                        curl_setopt($ch,CURLOPT_URL, $url);
                        curl_setopt($ch,CURLOPT_HEADER, "Content-Type: application/json");
                        curl_setopt($ch,CURLOPT_HEADER, "Authorization: AXYsm9VJ1VvDrdy5xzQHHJBnnhuhEKcFWhhFPkXBZI9V-G4CmfiXDpNh2DaKT06EaWDFnqWG_1z5ztbi:EB_7zrhzobGhC9Pp4NrLp-uMw_VhowRAvdDROZfGKtHto6LTMz1aUhtTS50INu-Jq5Qodx6raDPEp5fO");

                        //execute post
                        $result = curl_exec($ch);

                        echo "1";
                        print_r($result);
                        die();
                        //close connection
                        curl_close($ch);

                        break;
                }
                break;

            /*case 'pending':

                break;

            case 'failure':

                break;*/
        }


    }

    public function prueba(Request $request){

        $this->repository = new ConfirmRepository();
        $content = json_decode($request->get('data'));
        $state = $request->get('state');
        $payment = $request->get('payment');

        $paypal = new Paypal();
        $result = $paypal->executePayment($content->paymentId, $content->PayerID);
        $transactions = $result->getTransactions();
        $token = "";
        foreach ($transactions as $transaction) {
            echo "paso";
            print_r($transaction);
            $token = $transaction->getReferenceId();
        }
        echo $token;
//        print_r($result);
        die();
        $url = 'https://api.sandbox.paypal.com/v2/payments/authorizations/'.$content->paymentId;


        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_HEADER, "Content-Type: application/json");
        curl_setopt($ch,CURLOPT_HEADER, "AXYsm9VJ1VvDrdy5xzQHHJBnnhuhEKcFWhhFPkXBZI9V-G4CmfiXDpNh2DaKT06EaWDFnqWG_1z5ztbi:EB_7zrhzobGhC9Pp4NrLp-uMw_VhowRAvdDROZfGKtHto6LTMz1aUhtTS50INu-Jq5Qodx6raDPEp5fO");

        //execute post
        $result = curl_exec($ch);

        //close connection
        curl_close($ch);

        echo "1";
        print_r($result);
        die();
    }
}
