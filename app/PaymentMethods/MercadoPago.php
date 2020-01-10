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
        SDK::setClientId(
            config("payment-methods.mercadopago.client")
        );
        SDK::setClientSecret(
            config("payment-methods.mercadopago.secret")
        );
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

            array_push($items, $item);
        }

    //    $item->picture_url = $order->featured_img;

        # Create a payer object
        $payer = new Payer();
        //$payer->email = $order->preorder->billing['email'];
        $payer->email = $client['email'];
        $payer->first_name = $client['nombre'];
        $payer->last_name = $client['apellidos'];

        # Setting preference properties
        $preference->payer = $payer;
        $preference->items = $items;

        # Save External Reference
        $preference->external_reference = $order->token;
        $preference->back_urls = [
            "success" => 'http://localhost:4200/confirmation/success/MercadoPago',
            "pending" => 'http://localhost:4200/confirmation/pending/MercadoPago',
            "failure" => 'http://localhost:4200/confirmation/failure/MercadoPago',
        ];

        $preference->auto_return = "all";
        # Save and POST preference
        $preference->save();

        if (config('payment-methods.use_sandbox')) {
            return $preference->sandbox_init_point;
        }

        return $preference->init_point;
    }
}
