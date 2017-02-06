<?php

namespace App\Http\Controllers\Api\Pay;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Omnipay;

/*
*   银联支付控制器
*/
class UnionpayController extends Controller
{
    //
    public function pay(){

        $gateway = Omnipay::gateway('unionpay');

        $order = [
            'orderId' => date('YmdHis'),
            'txnTime' => date('YmdHis'),
            'orderDesc' => 'My test order title', //订单名称
            'txnAmt' => '100', //订单价格
        ];

        $response = $gateway->purchase($order)->send();
        $response->redirect();
    }
}
