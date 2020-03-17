<?php


namespace App\PaymentMethods;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Order;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;
use PayPal\Validation\UrlValidator;


class Paypal {
//    PRODUCCCIÓN

//    protected $client_id = "AU1Jzf7ziTCncrNsNBjmk_tD03Iz_1o8J4FNGTh5Z2mYHRSV21eh6rQbPDiQgOzTFiVXFmLdtzT4XzI_";
//    protected $client_secret = "EOAduWQh9BvX-i78i9RPD0emR85RE2PWwDaMEs2KG96Z5cOSShn7Sepw_YKmU5Z2GKapucmXO9zFIsYo";
    protected $client_id = "AXYsm9VJ1VvDrdy5xzQHHJBnnhuhEKcFWhhFPkXBZI9V-G4CmfiXDpNh2DaKT06EaWDFnqWG_1z5ztbi";
    protected $client_secret = "EB_7zrhzobGhC9Pp4NrLp-uMw_VhowRAvdDROZfGKtHto6LTMz1aUhtTS50INu-Jq5Qodx6raDPEp5fO";
//    protected $client_id = "AYAWXUIMnFBovXTj57RtxbQFwgrTaAjRUPILde-muG1r0K0M66v38z5cSc257seAsYSwqprwQOf9RQBv";
//    protected $client_secret = "ED2g_88Piw3c-hQ14FVz-aPTOFW1XI7Iuq8L2ASH-_EKXg6RCUM-DUTl_sI3NpIRlPOHkAziHhux-rrJ";

    public function setupPaymentAndGetRedirectURL($order, $products, $client, $delivery){
        $apiContext = new ApiContext(new OAuthTokenCredential(
            $this->client_id,
            $this->client_secret
        ));

        $apiContext->setConfig(
            array(
                'log.LogEnabled' => true,
                'log.FileName' => 'PayPal.log',
                'log.LogLevel' => 'DEBUG',
                'mode' => 'live'
            )
        );

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

        if($totalprice < $delivery->deliveryMethod->min){
            $item = new Item();
            $item->setName('Manejo de Mercancía Envío paquetería')
                ->setCurrency('MXN')
                ->setQuantity(1)
                ->setSku('ENV001') // Similar to `item_number` in Classic API
                ->setPrice($delivery->deliveryMethod->cost);

            $totalprice += $delivery->deliveryMethod->cost;
            array_push($items, $item);
        }
        $commission = $totalprice * 0.04;

        $item = new Item();
        $item->setName('Comisión de pago en paypal')
            ->setCurrency('MXN')
            ->setQuantity(1)
            ->setSku('COM001') // Similar to `item_number` in Classic API
            ->setPrice($commission);
        array_push($items, $item);

        $totalprice += $commission;

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
            ->setInvoiceNumber($order->token)
            ->setItemList($itemList)
            ->setDescription($order->token)
            ->setReferenceId($order->token);

//        $checkUrlSuccess = 'https://seragromex.com/confirmation/success/PayPal';
//        $checkUrlFail = 'https://seragromex.com/confirmation/failure/PayPal';

        $checkUrlSuccess = 'https://jardepot.com/confirmation/success/PayPal';
        $checkUrlFail = 'https://jardepot.com/confirmation/failure/PayPal';

//        $checkUrlSuccess = 'http://localhost/jardepot/confirmation/success/PayPal';
//        $checkUrlFail = 'http://localhost/jardepot/confirmation/failure/PayPal/'.$order->token;
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($checkUrlSuccess)
            ->setCancelUrl($checkUrlFail);

        $payment = new Payment();
        $payment->setIntent("sale")
            ->setId($order->token)
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

    public function executePayment($paymentId, $payerID){
        $apiContext = new ApiContext(new OAuthTokenCredential(
            $this->client_id,
            $this->client_secret
        ));


        $apiContext->setConfig(
            array(
                'log.LogEnabled' => true,
                'log.FileName' => 'PayPal.log',
                'log.LogLevel' => 'DEBUG',
                'mode' => 'live'
            )
        );
        try {

            $payment = Payment::get($paymentId, $apiContext);

            $execution = new PaymentExecution();
            $execution->setPayerId($payerID);

            $result = $payment->execute($execution, $apiContext);
            $payment->getId();
            try {
                $payment = Payment::get($paymentId, $apiContext);
            } catch (Exception $ex) {
                response()->json(['data' => 'failed'], 201);
                exit(1);
            }
        }catch (\Exception $ex) {
            response()->json(['data' => 'failed'], 201);
            exit(1);
        }
        return $payment;
    }

    public function setNotifyUrl($notify_url)
    {
        if(!empty($notify_url)){
            UrlValidator::validate($notify_url, "NotifyUrl");
        }

        $this->notify_url = $notify_url;
        return $this;
    }

    public function validateID($id){
        $apiContext = new ApiContext(new OAuthTokenCredential(
            $this->client_id,
            $this->client_secret
        ));

        $apiContext->setConfig(
            array(
                'log.LogEnabled' => true,
                'log.FileName' => 'PayPal.log',
                'log.LogLevel' => 'DEBUG',
                'mode' => 'live'
            )
        );
        try {
            $result = Order::get($id, $apiContext);
        } catch (PayPalConnectionException $ex) {
            $result = null;
        }
        return $result;
    }

    public function prueba(){
        $apiContext = new ApiContext(new OAuthTokenCredential(
            $this->client_id,
            $this->client_secret
        ));

        /*$apiContext->setConfig(
            array(
                'log.LogEnabled' => true,
                'log.FileName' => 'PayPal.log',
                'log.LogLevel' => 'DEBUG',
                'mode' => 'live'
            )
        );*/
        try {
            $result = Order::get('6J5596838D3243006', $apiContext);
        } catch (PayPalConnectionException $ex) {
            $result = null;
        }
        return $result;
    }

}
