<?php

return [

    // 默认支付网关
    'default' => 'alipay',

    // 各个支付网关配置
    'gateways' => [
        'paypal' => [
            'driver' => 'PayPal_Express',
            'options' => [
                'solutionType' => '',
                'landingPage' => '',
                'headerImageUrl' => ''
            ]
        ],

        'alipay' => [
            'driver' => 'Alipay_Express',
            'options' => [
                'partner' => 'your pid here',
                'key' => 'your appid here',
                'sellerEmail' =>'your alipay account here',
                'returnUrl' => 'your returnUrl here',
                'notifyUrl' => 'your notifyUrl here'
            ]
        ],
        //银联支付配置
        'unionpay' => [
            'driver' => 'UnionPay_Express',
            'options' => [
                'merId' => '777290058136340',
                'certPath' =>  __DIR__ . '/cert/700000000000001_acp.pfx',
                'certPassword' =>'000000',
                'certDir'=> __DIR__ . '/cert',
                'returnUrl' => 'Your ReturnUrl Here',
                'notifyUrl' => 'Your NotifyUrl Here'
            ]
        ]
    ]
];
