<?php

return [

    'enabled' => [
        'mercadopago',
        'paypal'
    ],

    'use_sandbox' => env('SANDBOX_GATEWAYS', true),

    'mercadopago' => [
        'logo' => '/img/payment/mercadopago.png',
        'display' => 'MercadoPago',
        'client' => env('MP_CLIENT'),
        'secret' => env('MP_SECRET'),
    ],

    'paypal' => [
        'display' => 'PayPal',
        'client' => env('PP_ID'),
        'secret' => env('PP_SECRET'),
    ]

];
