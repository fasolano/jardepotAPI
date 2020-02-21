<?php


namespace App\Http\Controllers;


use App\PaymentMethods\MercadoPago;
use App\PaymentMethods\Paypal;
use App\Repositories\ConfirmRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
                        $token = $request->get('token');
                        $order = $this->repository->verifyTokenAndPaymentMethod($payment, $token);
                        if ($order == null) {
                            return response()->json(['data' => 'failure'], 200);
                        }
                        $this->repository->createDeposit($order->total, $order->idPedidos, $payment, $order->fk_carrito);
                        $this->sendConfirmationMails($order->idPedidos);
                        return response()->json(['data' => 'success'], 200);
                        break;

                    case 'PayPal':
                        $token = $this->getTokenFromPayment($content);
                        $order = $this->repository->verifyTokenAndPaymentMethod($payment, $token);
                        if ($order == null) {
                            return response()->json(['data' => 'failure'], 200);
                        }
                        $this->repository->createDeposit($order->total, $order->idPedidos, $payment, $order->fk_carrito);
                        $this->sendConfirmationMails($order->idPedidos);
                        return response()->json(['data' => 'success'], 200);
                        break;
                }
                break;

            case 'pending':
                return response()->json(['data' => 'pending'], 200);
                break;

            case 'failure':
                switch ($payment) {
                    case 'MercadoPago':
                        $client = $this->getClient($content->external_reference);
                        $this->sendFailedMail($client, $payment);
                        break;

                    case 'PayPal':
                        break;
                }
                return response()->json(['data' => 'failure'], 200);
                break;
        }
    }

    public function mercadopagoToken(Request $request){
        $content = json_decode($request->get('data'));
        print_r($content);
        $token = $this->getExternalReference($content->external_reference);
        if ($token == null) {
            return response()->json(['data' => 'failure'], 200);
        }
        return response()->json(['data' => $token], 200);
    }

    public function getClient($external_reference){
        $this->repository = new ConfirmRepository();
        $client = $this->repository->getClientFromToken($external_reference);
        return $client;
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

    public function sendConfirmationMails($order){
        $url = 'http://digicom.mx/instalar_virus/ajax/sitios/jardepot/ventas/correoProcesamientoPedido/web?idPedidos='.$order.'&mail=sistemas1@jardepot.com';
//        $url = 'https://jardepot.com/digicom/public/instalar_virus/ajax/sitios/jardepot/ventas/correoProcesamientoPedido/web?idPedidos='.$order.'&mail=sistemas1@jardepot.com';
//        $url = 'http://koot.mx/digicom/public/instalar_virus/ajax/sitios/jardepot/ventas/correoProcesamientoPedido/web?idPedidos='.$order.'&mail=sistemas1@jardepot.com';
//        $url = 'https://seragromex.com/digicom/public/instalar_virus/ajax/sitios/jardepot/ventas/correoProcesamientoPedido/web?idPedidos='.$order.'&mail=sistemas1@jardepot.com';
//        $url = 'http://localhost/digicom5/public/instalar_virus/ajax/sitios/jardepot/ventas/correoProcesamientoPedido/web?idPedidos='.$order.'&mail=sistemas1@jardepot.com';
        //open connection
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_exec($ch);
        //close connection
        curl_close($ch);

        $url1 = 'http://digicom.mx/instalar_virus/sitios/jardepot/ventas/90-100/enviar90-100web.php?idPedidos='.$order.'&username=Sistemas&user_email=sistemas1@jardepot.com';
//        $url1 = 'https://jardepot.com/digicom/public/instalar_virus/sitios/jardepot/ventas/90-100/enviar90-100web.php?idPedidos='.$order.'&username=Sistemas&user_email=sistemas1@jardepot.com';
//        $url1 = 'http://koot.mx/digicom/public/instalar_virus/sitios/jardepot/ventas/90-100/enviar90-100web.php?idPedidos='.$order.'&username=Sistemas&user_email=sistemas1@jardepot.com';
//        $url1 = 'https://seragromex.com/digicom/public/instalar_virus/sitios/jardepot/ventas/90-100/enviar90-100web.php?idPedidos='.$order.'&username=Sistemas&user_email=sistemas1@jardepot.com';
//        $url1 = 'http://localhost/digicom5/public/instalar_virus/sitios/jardepot/ventas/90-100/enviar90-100web.php?idPedidos='.$order.'&username=Sistemas&user_email=sistemas1@jardepot.com';

        //open connection
        $ch1 = curl_init();
        curl_setopt($ch1,CURLOPT_URL, $url1);
        curl_exec($ch1);
        //close connection
        curl_close($ch1);

        return true;

    }

    public function sendFailedMail($client, $payment){
        $destino = $client->correo;

        $data = [
            'name' => $client->nombre,
            'payment' => $payment,
        ];
        Mail::send('mails.failedPayment', $data, function ($message) use ($destino) {
            $message->to($destino)->subject
            ('Pedido en linea Jardepot');
            $message->from('sistemas1@jardepot.com', 'Sitemas Jardepot');
        });
    }

    public function notification(){
        $mp = new MercadoPago();
        $payment = $mp->notification($_GET);
//        $destino = 'fasolanof@gmail.com';
        $destino = 'contabilidad@jardepot.com';
        $data = ['data' => $payment];

        Mail::send('mails.pendingPayment', $data, function ($message) use ($destino) {
            $message->to($destino)->subject('Pedido en linea Jardepot');
            $message->from('sistemas1@jardepot.com', 'Sitemas Jardepot');
        });

        return response()->json(['data' => 'success'], 204);
    }

    public function prueba(){
        $curl_info = curl_version();
        echo "protocol: " . $curl_info['ssl_version'];
        /*$mp = new Paypal();
        $mp->prueba();*/
    }

    public function createMercadopago(Request $request){
        $method = new \App\PaymentMethods\MercadoPago;
        $order = json_decode($request->get('order'));
        $products = json_decode($request->get('products'));
        $client = json_decode($request->get('client'), true);
        $delivery = json_decode($request->get('delivery'));
        $url =  $method->setupPaymentAndGetRedirectURL($order, $products, $client, $delivery);
        return response()->json(['data' => $url], 201);
    }
}
