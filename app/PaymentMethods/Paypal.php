<?php


namespace App\PaymentMethods;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PayPal\Validation\UrlValidator;


class Paypal {

    public function setupPaymentAndGetRedirectURL($order, $products, $client){
        $apiContext = new ApiContext(new OAuthTokenCredential(
            'AXYsm9VJ1VvDrdy5xzQHHJBnnhuhEKcFWhhFPkXBZI9V-G4CmfiXDpNh2DaKT06EaWDFnqWG_1z5ztbi',
            'EB_7zrhzobGhC9Pp4NrLp-uMw_VhowRAvdDROZfGKtHto6LTMz1aUhtTS50INu-Jq5Qodx6raDPEp5fO'
        ));

        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $items = array();
        $totalprice = 0;

        foreach ($products as $key => $product) {
            if($product->offer == 'si'){
                $price = $product->oferta;
            }else{
                $price = $product->priceweb;
            }

            # Create an item object
            $item = new Item();
            $item->setName($product->producto)
                ->setCurrency('MXN')
                ->setQuantity($product->cantidad)
                ->setSku($product->id) // Similar to `item_number` in Classic API
                ->setPrice($price);

            $totalprice += $price * $product->cantidad;
            array_push($items, $item);
        }

        $itemList = new ItemList();
        $itemList->setItems($items);

        $details = new Details();
        $details->setShipping(0)
            ->setTax(0)
            ->setSubtotal($totalprice);

        $amount = new Amount();
        $amount->setCurrency("MXN")
            ->setTotal($totalprice)
            ->setDetails($details);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Pago por compra en linea")
            ->setInvoiceNumber(uniqid());

//        $baseUrl = getBaseUrl();
        $checkUrl = 'http://koot.mx/jardepotAPI/public/api/checkout/success';
        $checkUrl = 'http://koot.mx/jardepotAPI/public/api/checkout/success';
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($checkUrl)
            ->setCancelUrl($checkUrl);

        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));


        try {
            $response = $payment->create($apiContext);
        } catch (PayPal\Exception\PPConnectionException $pce) {
            // Don't spit out errors or use "exit" like this in production code
            echo '<pre>';print_r(json_decode($pce->getData()));exit;
        }


//        $approvalUrl = $payment->getApprovalLink();

        return $response->getApprovalLink();
    }

    public function setNotifyUrl($notify_url)
    {
        if(!empty($notify_url)){
            UrlValidator::validate($notify_url, "NotifyUrl");
        }

        $this->notify_url = $notify_url;
        return $this;
    }

}
