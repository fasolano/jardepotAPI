<?php


namespace App\Http\Controllers;


use App\PaymentMethods\MercadoPago;
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
                        $token = $this->getExternalReference($content->preference_id);
                        if ($token == null) {
                            return response()->json(['data' => 'failed'], 500);
                        }
                        $order = $this->repository->verifyTokenAndPaymentMethod($payment, $token);
                        if ($order == null) {
                            return response()->json(['data' => 'failed'], 500);
                        }
                        $this->repository->createDeposit($order->total, $order->idPedidos, $payment, $order->fk_carrito);
                        return response()->json(['data' => 'success'], 201);
                        break;

                    case 'PayPal':
                        $token = $this->getTokenFromPayment($content);
                        $order = $this->repository->verifyTokenAndPaymentMethod($payment, $token);
                        if ($order == null) {
                            return response()->json(['data' => 'failed'], 500);
                        }
                        $this->repository->createDeposit($order->total, $order->idPedidos, $payment, $order->fk_carrito);
                        return response()->json(['data' => 'success'], 201);
                        break;
                }
                break;

            case 'pending':
                return response()->json(['data' => 'success'], 201);
                break;

            /*case 'failure':

                break;*/
        }


    }

    public function getTokenFromPayment($content){
        $paypal = new Paypal();
        $result = $paypal->executePayment($content->paymentId, $content->PayerID);
        $transactions = $result->getTransactions();
        foreach ($transactions as $transaction) {
            $token = $transaction->getDescription();
        }
        return $token;
    }

    public function getExternalReference($preference_id) {
        $mercado_pago = new MercadoPago();
        return $mercado_pago->verifyPayment($preference_id);
    }

    public function getAccessToken(){
        $ch = curl_init();
        $clientId = "AXYsm9VJ1VvDrdy5xzQHHJBnnhuhEKcFWhhFPkXBZI9V-G4CmfiXDpNh2DaKT06EaWDFnqWG_1z5ztbi";
        $secret = "EB_7zrhzobGhC9Pp4NrLp-uMw_VhowRAvdDROZfGKtHto6LTMz1aUhtTS50INu-Jq5Qodx6raDPEp5fO";

        curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/oauth2/token");
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSLVERSION , 6); //NEW ADDITION
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $clientId.":".$secret);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

        $result = curl_exec($ch);

        if(empty($result))die("Error: No response.");
        else
        {
            $json = json_decode($result);
        }

        curl_close($ch); //THIS CODE IS NOW WORKING!

        return $json->access_token;
    }

    public function sendConfirmationMails($order){
        $url = 'http://digicom.mx/instalar_virus/ajax/sitios/jardepot/ventas/correoProcesamientoPedido/web?idPedidos='.$order.'&mail=sistemas1@jardepot.com';
        //open connection
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);

        $url = 'https://digicom.mx/instalar_virus/sitios/jardepot/ventas/90-100/enviar90-100web.php?idPedidos='.$order.'&username=Sistemas&user_email=sistemas1@jardepot.com';
//        $url = 'http://localhost/digicom5/public/instalar_virus/sitios/jardepot/ventas/90-100/enviar90-100web.php?idPedidos=18571&username=Sistemas&user_email=sistemas1@jardepot.com';

        //open connection
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);

    }

    public function prueba(){

        $url = 'http://digicom.mx/instalar_virus/ajax/sitios/jardepot/ventas/correoProcesamientoPedido/web?idPedidos=18571&mail=sistemas1@jardepot.com';

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);

        //execute post
        $result = curl_exec($ch);

        print_r($result);

        //close connection
        curl_close($ch);










        $url = 'https://digicom.mx/instalar_virus/sitios/jardepot/ventas/90-100/enviar90-100.php?idPedidos=18572&username=Sistemas&user_email=sistemas1@jardepot.com';
        $url = 'http://localhost/digicom5/public/instalar_virus/sitios/jardepot/ventas/90-100/enviar90-100web.php?idPedidos=18571&username=Sistemas&user_email=sistemas1@jardepot.com';

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);

        //execute post
        $result = curl_exec($ch);

        print_r($result);

        //close connection
        curl_close($ch);
    }
}
