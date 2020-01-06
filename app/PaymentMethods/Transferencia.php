<?php


namespace App\PaymentMethods;


class Transferencia {


    public function setupPaymentAndGetRedirectURL($order, $products): string {
        # Create a preference object
        $preference = new Preference();
        $items = array();

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

            array_push($items, $item);
        }

        //    $item->picture_url = $order->featured_img;

        # Create a payer object
        $payer = new Payer();
        //$payer->email = $order->preorder->billing['email'];
        $payer->email = 'test@test.com';

        # Setting preference properties
//        $preference->items = [$item];
        $preference->payer = $payer;
        $preference->items = $items;

        # Save External Reference
        $preference->external_reference = $order->idPedidos;
        $preference->back_urls = [
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
