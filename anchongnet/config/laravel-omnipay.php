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
        ]
    ],

    'unionpay' => [
        'driver' => 'UnionPay_Express',
        'options' => [
            'merId' => '777290058120462',
            'certPath' => '/path/to/storage/app/unionpay/certs/PM_700000000000001_acp.pfx',
            'certPassword' =>'000000',
            'certDir'=>'/path/to/certs',
            'returnUrl' => 'Your ReturnUrl Here',
            'notifyUrl' => 'Your NotifyUrl Here'
        ]
    ]

];
