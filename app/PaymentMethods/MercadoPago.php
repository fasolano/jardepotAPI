<?php


namespace App\PaymentMethods;

use Illuminate\Http\Request;
use MercadoPago\Item;
use MercadoPago\MerchantOrder;
use MercadoPago\Payer;
use MercadoPago\Payment;
use MercadoPago\Preference;
use MercadoPago\SDK;

class MercadoPago{

    public function __construct()
    {
        /*SDK::setClientId("5218597946840536");
        SDK::setClientSecret("jRqFu65og5OeqwhTIicRMROzVJWTM0jv");
        SDK::setPublicKey('TEST-f69e04b9-b984-490f-ac0f-48bf0b6f48ca');
        SDK::setAccessToken('TEST-5218597946840536-011519-f0feee1d9aa73c866bf25d8975e45fa9-509669228');*/
        SDK::setClientId("8224945122859735");
        SDK::setClientSecret("oezGzmodwi7mKkC7xOQ7wvi8niF6xKSd");
        SDK::setPublicKey('TEST-6dd5ef51-65da-4835-90ac-015e71ae3621');
        SDK::setAccessToken('TEST-8224945122859735-122615-d88844d56e86f435b36882b456e1adfb-191284474');
    }

    public function notification($id){
        $payment = new Payment();
        $res = $payment::get($id);
        return $res;
    }

    public function setupPaymentAndGetRedirectURL($order, $products, $client, $delivery): string {
        # Create a preference object
        $preference = new Preference();
        $items = array();
        $total = 0;

        foreach ($products as $key => $product) {
            if($product->offer == 'si'){
                $price = $product->oferta;
            }else{
                $price = $product->priceweb;
            }
            # Create an item object
            $item = new Item();
            $item->id = $product->id; // numero de pedio
            $item->title = $product->producto; //Articulo
            $item->quantity = $product->cantidad;
            $item->currency_id = 'MXN';
            $item->unit_price = $price;

            $total += $product->cantidad * $price;
            array_push($items, $item);
        }

        if($total < $delivery->deliveryMethod->min){
            $item = new Item();
            $item->id = 'paq001'; // numero de pedio
            $item->title = 'Manejo de Mercancía Envío paquetería'; //Articulo
            $item->quantity = 1;
            $item->currency_id = 'MXN';
            $item->unit_price = $delivery->deliveryMethod->cost;
            $total += $delivery->deliveryMethod->cost;
            array_push($items, $item);
        }

        $commission = $total * 0.04;
        $item = new Item();
        $item->id = 'COMI001'; // numero de pedio
        $item->title = 'Comisión por pago en MercadoPago'; //Articulo
        $item->quantity = 1;
        $item->currency_id = 'MXN';
        $item->unit_price = $commission;

        array_push($items, $item);

    //    $item->picture_url = $order->featured_img;

        # Create a payer object
        $payer = new Payer();
        //$payer->email = $order->preorder->billing['email'];
        $payer->email = $client['email'];
        $payer->first_name = $client['nombre'];
        $payer->last_name = $client['apellidos'];
        $payer->phone = array(
            "number" => $client['telefono']
        );
        $payer->address = array(
            "street_name" => $client['calle'],
            "zip_code" => $client['cp']
        );

        # Setting preference properties
        $preference->payer = $payer;
        $preference->items = $items;

        # Save External Reference
        $preference->external_reference = $order->token;
        /*$preference->back_urls = [
            "success" => 'http://koot.mx/jardepot/confirmation/success/MercadoPago',
            "pending" => 'http://koot.mx/jardepot/confirmation/pending/MercadoPago',
            "failure" => 'http://koot.mx/jardepot/confirmation/failure/MercadoPago',
        ];*/
        /*$preference->back_urls = [
            "success" => 'http://localhost/jardepot/confirmation/success/MercadoPago',
            "pending" => 'http://localhost/jardepot/confirmation/pending/MercadoPago',
            "failure" => 'http://localhost/jardepot/confirmation/failure/MercadoPago',
        ];*/
        $preference->back_urls = [
            "success" => 'http://jardepot.com/confirmation/success/MercadoPago',
            "pending" => 'http://jardepot.com/confirmation/pending/MercadoPago',
            "failure" => 'http://jardepot.com/confirmation/failure/MercadoPago',
        ];

//        $preference->notification_url = 'http://koot.mx/jardepot/jardepotAPI/public/api/confirm/prueba/confirmation/notification/MercadoPago';

//        $preference->notification_url = 'http://localhost/jardepotAPI/public/api/confirmation/notification/MercadoPago';

        $preference->notification_url = 'http://jardepot.com/jardepotAPI/public/api/confirm/prueba/confirmation/notification/MercadoPago';

        $preference->auto_return = "all";
        # Save and POST preference
        $preference->save();

        if (config('payment-methods.use_sandbox')) {
            return $preference->sandbox_init_point;
        }

        return $preference->init_point;
    }

    public function verifyPayment($preference_id){
        $payment = Payment::search(['external_reference' => $preference_id]);
        if(count($payment)){
            if($payment[0]->external_reference == 'approved' && $payment[0]->external_reference == 'accredited'){
                return $payment[0]->external_reference;
            }else{
                return null;
            }
        }else{
            return null;
        }
    }

    public function getPaymentFromNotification($data){
        $payment = null;

        switch($data["topic"]) {
            case "payment":
                $payment = MercadoPago\Payment::find_by_id($data["id"]);
                // Get the payment and the corresponding merchant_order reported by the IPN.
//                $merchant_order = MercadoPago\MerchantOrder::find_by_id($payment->order->id);
                break;
            case "merchant_order":
//                $merchant_order = MercadoPago\MerchantOrder::find_by_id($_GET["id"]);
                break;
        }

        return $payment;
    }

    public function prueba(){
        $payment = Payment::search(['external_reference' => 'e84dfd93bfeff87acf21de3651cd32b2c4c95c4832178c37e610ce542f3f']);
        return $payment;
    }

}
