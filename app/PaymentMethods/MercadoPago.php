<?php


namespace App\PaymentMethods;

use App\Order;
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


    public function setupPaymentAndGetRedirectURL($order, $products): string
    {
        # Create a preference object
        $preference = new Preference();

        # Create an item object
        $item = new Item();
        $item->id = $order->idPedidos; // numero de pedio
        $item->title = $order->idPedidos; //Articulo
        $item->quantity = 1;
        $item->currency_id = 'MXN';
        $item->unit_price = $order->total;
    //    $item->picture_url = $order->featured_img;

        # Create a payer object
        $payer = new Payer();
        //$payer->email = $order->preorder->billing['email'];
        $payer->email = 'test@test.com';

        # Setting preference properties
        $preference->items = [$item];
        $preference->payer = $payer;

        # Save External Reference
        $preference->external_reference = $order->idPedidos;
        $preference->back_urls = [
//            "success" => route('checkout.thanks'),
//            "pending" => route('checkout.pending'),
//            "failure" => route('checkout.error'),
            "success" => 'http://localhost:4200/checkout/success',
            "pending" => 'http://localhost:4200/checkout/pending',
            "failure" => 'http://localhost:4200/checkout/failure',
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
