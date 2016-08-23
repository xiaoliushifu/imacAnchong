<?php

return [
    /**
     * Debug 模式，bool 值：true/false
     *
     * 当值为 false 时，所有的日志都不会记录
     */
    'debug'  => true,

    /**
     * 使用 Laravel 的缓存系统
     */
    'use_laravel_cache' => true,

    /**
     * 账号基本信息，请从微信公众平台/开放平台获取
     */
    'app_id'  => env('WECHAT_APPID', 'wx496c753bbea165c9'),         // AppID
    'secret'  => env('WECHAT_SECRET', '18c0ac572a04628741edf7a67f9cf278'),     // AppSecret
    'token'   => env('WECHAT_TOKEN', '7s2jBwhXOma57WG87HQj'),          // Token
    'aes_key' => env('WECHAT_AES_KEY', '99bfw9bUndwGgOsDPk03WiHoXsEdmbCpvJbF95BrYB9'),                    // EncodingAESKey

    /**
     * 日志配置
     *
     * level: 日志级别，可选为：
     *                 debug/info/notice/warning/error/critical/alert/emergency
     * file：日志文件位置(绝对路径!!!)，要求可写权限
     */
    // 'log' => [
    //     'level' => env('WECHAT_LOG_LEVEL', 'debug'),
    //     'file'  => env('WECHAT_LOG_FILE', storage_path('logs/wechat.log')),
    // ],

    /**
     * OAuth 配置
     *
     * scopes：公众平台（snsapi_userinfo / snsapi_base），开放平台：snsapi_login
     * callback：OAuth授权完成后的回调页地址(如果使用中间件，则随便填写。。。)
     */
    // 'oauth' => [
    //     'scopes'   => array_map('trim', explode(',', env('WECHAT_OAUTH_SCOPES', 'snsapi_userinfo'))),
    //     'callback' => env('WECHAT_OAUTH_CALLBACK', '/examples/oauth_callback.php'),
    // ],

    /**
     * 微信支付
     */
    'payment' => [
        'merchant_id'        => env('WECHAT_PAYMENT_MERCHANT_ID', '1379969502'),
        'key'                => env('WECHAT_PAYMENT_KEY', 'a2b7d40c9d02ef0e3de12b48dd44516b'),
        'cert_path'          => env('WECHAT_PAYMENT_CERT_PATH', '../cert/apiclient_cert.pem'), // XXX: 绝对路径！！！！
        'key_path'           => env('WECHAT_PAYMENT_KEY_PATH', '../cert/apiclient_key.pem'),      // XXX: 绝对路径！！！！
        // 'device_info'     => env('WECHAT_PAYMENT_DEVICE_INFO', ''),
        // 'sub_app_id'      => env('WECHAT_PAYMENT_SUB_APP_ID', ''),
        // 'sub_merchant_id' => env('WECHAT_PAYMENT_SUB_MERCHANT_ID', ''),
        // ...
    ],
];
