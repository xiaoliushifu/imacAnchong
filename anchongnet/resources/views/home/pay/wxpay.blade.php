<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>微信扫码支付</title>
    <link rel="stylesheet" type="text/css" href="/home/css/wxpay.css">
    <script src="/home/js/jquery-3.1.0.js"></script>
</head>
<body>
    <div>
        <img class="logo" src="/images2/WePayLogo.png" alt="wxpay" />
    </div>
    <div class="info">
        <ul class="orderinfo">
            <li class="infoli">订单编号：{{$out_trade_no}}</li>
            <li class="paymoney">应付金额：￥{{$total_fee}}</li>
            <li class="infoli">订单类型：{{$subject}}</li>

        </ul>
    </div>
    <div class="illu">
        <img class="tab" src="/images2/WePayLogo.png" alt="wxpay" />
        <img class="tabbutton" src="/images2/button.png" alt="wxpay" />
        <dl class="payview">
            支付<font color="#FF7F00">{{$total_fee}}</font>元
        </dl>
    </div>
    <div class="qrcode">
        {!! $QrCode !!}
    </div>
    <div class="prompt">
        <img src="/images2/propmpt.png" alt="" />
    </div>
    <div class="alink">
        <a href="http://www.anchong.net/order">付款完成了？返回订单页面！</a>
    </div>
</body>
<html>
