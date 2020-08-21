<?php


namespace App\PaymentMethods;

use Illuminate\Http\Request;
use MercadoPago\Item;
use MercadoPago\MerchantOrder;
use MercadoPago\Payer;
use MercadoPago\Payment;
use MercadoPago\Preference;
use MercadoPago\SDK;
use MercadoPago\Shipments;

class MercadoPago{

    /*protected $client_id = "5218597946840536";
    protected $client_secret = "jRqFu65og5OeqwhTIicRMROzVJWTM0jv";
    protected $public_key = "TEST-f69e04b9-b984-490f-ac0f-48bf0b6f48ca";
    protected $access_token = "TEST-5218597946840536-011519-f0feee1d9aa73c866bf25d8975e45fa9-509669228";*/

    protected $client_id = "8224945122859735";
    protected $client_secret = "oezGzmodwi7mKkC7xOQ7wvi8niF6xKSd";
    protected $public_key = "APP_USR-63cd8043-c639-4031-84dd-648178659e68";
    protected $access_token = "APP_USR-8224945122859735-122615-a76e6f063a67e18cdf0480846f99ba5e-191284474";

    public function __construct() {
        /*SDK::setClientId("5218597946840536");
        SDK::setClientSecret("jRqFu65og5OeqwhTIicRMROzVJWTM0jv");
        SDK::setPublicKey('TEST-f69e04b9-b984-490f-ac0f-48bf0b6f48ca');
        SDK::setAccessToken('TEST-5218597946840536-011519-f0feee1d9aa73c866bf25d8975e45fa9-509669228');*/
        SDK::setClientId("8224945122859735");
        SDK::setClientSecret("oezGzmodwi7mKkC7xOQ7wvi8niF6xKSd");
        SDK::setPublicKey('APP_USR-63cd8043-c639-4031-84dd-648178659e68');
        SDK::setAccessToken('APP_USR-8224945122859735-122615-a76e6f063a67e18cdf0480846f99ba5e-191284474');
    }

    public function notification($id){
        $payment = new Payment();
        $res = $payment::get($id);
        return $res;
    }

    public function setupPaymentAndGetRedirectURL($products, $client, $cart = null): string {
        # Create a preference object
        $preference = new Preference();
        $items = array();
        $total = 0;

        foreach ($products as $key => $product) {
            if($product->offer == 'si'){
                $price = $product->oferta;
            }else{
                $price = $product->price;
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

        if($total < 3000){
            $item = new Item();
            $item->id = 'paq001'; // numero de pedio
            $item->title = 'Manejo de Mercancía Envío paquetería'; //Articulo
            $item->quantity = 1;
            $item->currency_id = 'MXN';
            $item->unit_price = 300;
            $total += 300;
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

        # Create a payer object
        $payer = new Payer();
        $payer->email = $client['email'];
        $payer->name = $client['nombre'];
        $payer->surname = $client['apellidos'];
        $payer->phone = array(
            "number" => $client['telefono']
        );
        $payer->address = array(
            "street_name" => $client['direccion'],
            "zip_code" => $client['cp']
        );

        # Create a payer object
        $shipment = new Shipments();
        $shipment->receiver_address = array(
            'zip_code' => $client['cp'],
            'street_name' => $client['colonia'].", ".$client['direccion'],
            'street_number' => "",
            'floor' => "",
            'apartment' => "",
            'city_name' => $client['ciudad'],
            'state_name' => $client['estado'],
            'country_name' => "México",
        );

        $preference->external_reference = $cart;
        # Setting preference properties
        $preference->payer = $payer;
        $preference->items = $items;
        $preference->shipments = $shipment;

        # Save External Reference
        //$preference->external_reference = $order->token;

        /*$preference->back_urls = [
            "success" => 'http://localhost/jardepotAPI/public/confirmacion/mercadopago/success',
            "pending" => 'http://localhost/jardepotAPI/public/confirmacion/mercadopago/pending',
            "failure" => 'http://localhost/jardepotAPI/public/confirmacion/mercadopago/failure',
        ];*/

        $preference->back_urls = [
            "success" => 'https://www.jardepot.com/c0nf1rm4c10n/m3rc4d0p4g0/success',
            "pending" => 'https://www.jardepot.com/c0nf1rm4c10n/m3rc4d0p4g0/pending',
            "failure" => 'https://www.jardepot.com/c0nf1rm4c10n/m3rc4d0p4g0/failure',
        ];

        $preference->notification_url = 'https://www.jardepot.com/jardepotAPI/public/api/confirm/prueba/confirmation/notification/MercadoPago';

        $preference->auto_return = "all";
        # Save and POST preference
        $preference->save();

        /*if (config('payment-methods.use_sandbox')) {
            return $preference->sandbox_init_point;
        }*/

        return $preference->init_point;
    }

    public function verifyPayment($preference_id){
        $url = 'https://api.mercadopago.com/checkout/preferences/'.$preference_id.'?access_token='.$this->access_token;
        //open connection
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $err = curl_error($ch);

        $resp = $response;
        curl_close($ch);

        if ($err) {
            return 'error';
        } else {
            return $resp;
        }
    }
}
