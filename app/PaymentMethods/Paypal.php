<?php


namespace App\PaymentMethods;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PayPal\Validation\UrlValidator;


class Paypal {
//    PRODUCCCIÓN

    protected $client_id = "AV2uvUfs9XUFfpi6s-mEsyTNyqYknJcHxGwSo6gzluCfn9ALf0m7f1qgFrscrUQ0rq54KZ2PTDrsqDYh";
    protected $client_secret = "EH9p-fTzo0TkwZGTjD04kg4Clpqd3_tSUBtFaLfJe6kdisZUWweWVX27AEpSTK4wVwKNrHLg1uyeDeEa";
//    protected $client_id = "AU1Jzf7ziTCncrNsNBjmk_tD03Iz_1o8J4FNGTh5Z2mYHRSV21eh6rQbPDiQgOzTFiVXFmLdtzT4XzI_";
//    protected $client_secret = "EOAduWQh9BvX-i78i9RPD0emR85RE2PWwDaMEs2KG96Z5cOSShn7Sepw_YKmU5Z2GKapucmXO9zFIsYo";
//    protected $client_id = "ASOLVloSK-ZQqY7U_hPQeRih6TuIW49a6KMmmj3l1CMC4GjEZfJN6bdG8QwuT1g38Uxg31ASTovsaSR2";
//    protected $client_secret = "EKh5fZe4QqiJwXTn7kBH-L1oAZ5yG8UTV9DiekA5-CuT3N2-Pmd_6P3KVglIZl_N5d8PXaaZWLdOhT1B";

    public function setupPaymentAndGetRedirectURL($order, $products, $client, $delivery){
        $apiContext = new ApiContext(new OAuthTokenCredential(
            $this->client_id,
            $this->client_secret
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

//        $checkUrlSuccess = 'http://koot.mx/jardepot/confirmation/success/PayPal';
//        $checkUrlFail = 'http://koot.mx/jardepot/confirmation/failure/PayPal';

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
        try {

            $payment = Payment::get($paymentId, $apiContext);

            $execution = new PaymentExecution();
            $execution->setPayerId($payerID);

            $result = $payment->execute($execution, $apiContext);
            $payment->getId();
            try {
                $payment = Payment::get($paymentId, $apiContext);
            } catch (Exception $ex) {
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

    public function prueba(){
        $apiContext = new ApiContext(new OAuthTokenCredential(
            $this->client_id,
            $this->client_secret
        ));
        $ps = Payment::all([], $apiContext);
        print_r($ps);
    }

}
