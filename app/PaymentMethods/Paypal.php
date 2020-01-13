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

    public function setupPaymentAndGetRedirectURL($order, $products, $client, $delivery){
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
            ->setItemList($itemList)
            ->setDescription("Pago por compra en linea")
            ->setReferenceId($order->token);

//        $baseUrl = getBaseUrl();
        $checkUrlSuccess = 'http://localhost:4200/confirmation/success/Paypal';
        $checkUrlFail = 'http://localhost:4200/confirmation/failure/Paypal';
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($checkUrlSuccess)
            ->setCancelUrl($checkUrlFail);

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

    public function executePayment($paymentId, $payerID){
        $apiContext = new ApiContext(new OAuthTokenCredential(
            'AXYsm9VJ1VvDrdy5xzQHHJBnnhuhEKcFWhhFPkXBZI9V-G4CmfiXDpNh2DaKT06EaWDFnqWG_1z5ztbi',
            'EB_7zrhzobGhC9Pp4NrLp-uMw_VhowRAvdDROZfGKtHto6LTMz1aUhtTS50INu-Jq5Qodx6raDPEp5fO'
        ));

        $payment = Payment::get($paymentId, $apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($payerID);
        try {
            $result = $payment->execute($execution, $apiContext);
            $payment->getId();
            try {
                $payment = Payment::get($paymentId, $apiContext);
            } catch (Exception $ex) {
                exit(1);
            }
        }catch (\Exception $ex) {
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

}
