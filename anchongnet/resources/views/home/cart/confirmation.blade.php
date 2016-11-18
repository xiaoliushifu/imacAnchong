<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>订单确认</title>
    <link rel="stylesheet" type="text/css" href="home/css/confirmation.css">
    <link rel="stylesheet" href="home/css/top.css">
    <script src="home/js/jquery-3.1.0.js"></script>
    <script src="home/js/top.js"></script>
</head>
<body>
@include('inc.home.top')
<div class="header">
    <div class="header-container">
        <div class="logo">
            <a href="{{url('/')}}">
            <img  src="home/images/cart/logo.jpg"/>
            </a>
        </div>
        <div class="search">
            <form class="search-form" method="post">
                <input type="text" name="search" class="search-text" placeholder="找工程&nbsp;找人才&nbsp;聊生活" />
                <input value="搜索" class="search-btn"/>
            </form>
        </div>
        <div class="cl"></div>
    </div>
</div>
<div class="site-middle">
    <div class="middle-cont">
        <div class="middle-top">
            <i class="site-location">您的位置:</i>
            <i class="home">首页</i>
            <span class =connector"">></span>
            <i class="personal">我的个人中心</i>
            <span class ="connector">></span>
            <i class="owner-order">我的订单</i>
            <span class ="connector">></span>
            <i class = "order-detail">订单详情</i>
        </div>
        <div class="order-stauts">
            <img src="home/images/cart/pay.png"/>
        </div>
        <div class="address">
            <div class="address-title">
                <i class="choose">添加/选择收货地址</i>
                <i class="manage"><a href="/adress">管理收货地址</a></i>
            </div>
            <form action="/order" method="post" id="myform">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <ul class="address-list">
                @foreach($deaddr as $value)
                <a href="javascript:void(0)"><li class="default" onclick="selectd($(this));">
                    <input type="hidden" name="name" id="name" value="{{$value -> add_name}}">
                    <input type="hidden" name="phone" id="phone" value="{{$value -> phone}}">
                    <input type="hidden" name="address" id="address" value="{{$value ->region}}&nbsp;{{$value -> address}}">
                    <p class="consignee">收货人：{{$value->add_name}}</p>
                    <p class="telphone">联系电话：{{$value ->phone}}</p>
                    <p class="reciver-add">收货地址：{{$value->region}}&nbsp;&nbsp;{{$value->address}}</p>
                    <!-- <p class="selected"><img src="home/images/cart/selected.png"></p> -->
                </li></a>
                @endforeach
                @if(count($addr)==0)
                <input type="hidden" name="name" value="">
                <input type="hidden" name="phone" value="">
                <input type="hidden" name="address" value="">
                <a href="javascript:void(0)"><li class="o-add" onclick="selectd($(this));">
                    <p style="text-align: center;color:#f53745;line-height: 50px">请填写收货地址</p>
                </li></a>
                <a href="javascript:void(0)"><li class="o-add" onclick="selectd($(this));">
                    <p style="text-align: center;color: #f53745;line-height: 50px">暂无更多地址</p>
                </li></a>
                @elseif(count($addr)==1)
                    @foreach($addr as $v)
                <a href="javascript:void(0)"><li class="o-add" onclick="selectd($(this));">
                    <p class="consignee">收货人：{{$v -> add_name}}</p>
                    <p class="telphone">联系电话：{{$v -> phone}}</p>
                    <p class="reciver-add">收货地址：{{$v ->region}}&nbsp;{{$v -> address}}</p>
                    <!-- <p class="select"><img src="home/images/cart/selected.png"></p> -->
                </li>
                <!-- <a href="javascript:void(0)"><li class="o-add" onclick="selectd($(this));">
                    <p style="text-align: center;color: #f53745;line-height: 50px">暂无更多地址</p>
                </li></a> -->
                        @endforeach
                @elseif(count($addr) >= 2)
                    @foreach($addr as $v)
                        <a href="javascript:void(0)"><li class="o-add" onclick="selectd($(this));">
                            <p class="consignee">收货人：{{$v -> add_name}}</p>
                            <p class="telphone">联系电话：{{$v -> phone}}</p>
                            <p class="reciver-add">收货地址：{{$v -> region}}&nbsp;{{$v -> address}}</p>
                            <!-- <p class="select"><img src="home/images/cart/selected.png"></p> -->
                        </li></a>
                    @endforeach
                @endif
                <li class="add-address"><a href="/adress"><img src="home/images/cart/add_address.png"></a></li>
                <div class="cl"></div>
            </ul>
            <!-- <p class="show-add"><a href="">显示全部地址</a></p> -->
        </div>
        <ul class="confirmed">
            <input type="hidden" name="orderinfo" value="{{$cartjson}}">
            <h3>确认订单信息</h3>
            <ul class="">
                <li class="shopname">商铺与商品</li>
                <li class="price">单价</li>
                <li class="number">数量</li>
                <li class="count">总计</li>
            </ul>
            @foreach($cartarr as $shop)
            <li class="order-nav">
                <ul>
                    <li class="shop-name">商铺:<a href="">{{$shop['sname']}}</a></li>
                    <li class="shop_total_price" style="display:none">￥{{$shop['total_price']}}</li>
                    <li class="shop_freight" style="display:none">￥{{$shop['freight']}}</li>
                    <div class="cl"></div>
                </ul>
            </li>
                @foreach($shop['goods'] as $value)
                <span class="partition"></span>
                <li class="order-info">
                    <ul>
                        <li class="goods-img"><img src="{{$value['img']}}"></li>
                        <li class="goods-desc">
                            <h5 class="goods-name">{{$value['goods_name']}}</h5>
                            <p class="goods-type">规格：{{$value['goods_type']}}&nbsp;{{$value['oem']?"oem:".$value['oem']:""}}</p>
                        </li>
                        <li class="goods-price">￥{{$value['goods_price']}}</li>
                        <li class="goods-number">{{$value['goods_num']}}</li>
                        <li class="count-price">￥{{$value['goods_num'] * $value['goods_price']}}</li>
                    </ul>
                </li>
                @endforeach
            @endforeach
            <li class="sum">
                <p class="order-price">订单总额：<i id="order-price">0</i>元</p>
                <p class="freight">运费：<i id="freight">0</i>元</p>
            </li>
            <li class="order-other">
                <h3 class="bill">发票信息</h3>
                <div class="col-sm-3">
                    填写发票信息(开发票会产生额外费用):
                    <input type="checkbox" id="useinvoice" onclick="display();">
                </div>
                <div style="display:none">
                    <input type="radio" id="nedit" name="invoicetype" value="0" checked="checked">
                </div>
                <div class="col-sm-10" id="invoicetype" style="display:none">

                    <div class="col-sm-3">
                        普通发票(5%):
                        <input type="radio" id="medit" name="invoicetype" value="1">
                    </div>
                    <div class="col-sm-3">
                        增值发票(10%):
                        <input type="radio" id="hedit" name="invoicetype" value="2">
                    </div>
                    <div class="col-sm-10" id="putong" style="display:block">
                        <input type="text" name="invoice1" placeholder="发票抬头">
                        <input type="text" name="invoice2" placeholder="开票项目">
                    </div>
                    <div class="col-sm-10" id="zengzhi" style="display:none">
                        <input type="text" name="invoice3" placeholder="发票名称">
                        <input type="text" name="invoice4" placeholder="纳税人识别号">
                        <input type="text" name="invoice5" placeholder="地址、电话">
                        <input type="text" name="invoice6" placeholder="开户行及账号">
                        <input type="text" name="invoice7" placeholder="货物名称">
                    </div>
                </div>
            </li>
            <input type="hidden" name="acpid" value="">
            <input type="hidden" name="cvalue" value="">
            <input type="hidden" name="shop" value="">
            <ul class="payment">
                <input type="hidden" name="paytype" id="paytype" value="2">
                <h3>支付方式</h3>
                <!-- <a href="javascript:void(0)"><li class="COD" onclick="pay($(this));" data-id="1">余额付款</li></a> -->
                <a href="javascript:void(0)"><li class="COD" onclick="pay($(this));" data-id="2">支付宝支付</li></a>
                <a href="javascript:void(0)"><li class="common" onclick="pay($(this));" data-id="3">微信支付</li></a>
                <div class="cl"></div>
            </ul>
            <span class="partition"></span>
            <li class="submit">
                <span class="amount">应付总额：<i></i></span>
                    <input type="button" class="btn" id="submit" value="提交订单">
            </li>

        </ul>
    </form>
    </div>
</div>
<script>

    //显示发票
    function display(){
        if($('#useinvoice').is(':checked')){
            $('#invoicetype').css("display","block");
            $('#medit').prop("checked","checked");
        }else{
            $('#invoicetype').css("display","none");
            $('#nedit').prop("checked","checked");
        }
    }


    $("input:radio[name='invoicetype']").change(function(){
        if($(this).val() == 1){
            $('#putong').css("display","block");
            $('#zengzhi').css("display","none");
        }else if($(this).val() == 2) {
            $('#zengzhi').css("display","block");
            $('#putong').css("display","none");
        }
    });
    //console.log($('.shop_total_price').text());
    //计算所有商品的价格和运费
    var total_price=0;
    var total_freight=0
    var price=$('.shop_total_price').text().split("￥");
    var freight=$('.shop_freight').text().split("￥");
    for($i=0;$i<price.length;$i++){
        total_price+=Number(price[$i]);
    }
    for($i=0;$i<freight.length;$i++){
        total_freight+=Number(freight[$i]);
    }
    //将计算结果显示
    $("#order-price").text(total_price);
    $("#freight").text(total_freight);
    $(".amount").text("应付总额(不含发票)："+(total_freight+total_price)+"元");
    //收货地址的选择
    function selectd(li){
        $(".default").attr("class","o-add");
        li.attr("class","default");
        $("#name").val(li.find(".consignee").text().replace('收货人：',''));
        $("#phone").val(li.find(".telphone").text().replace('联系电话：',''));
        $("#address").val(li.find(".reciver-add").text().replace('收货地址：',''));
    }
    //付款方式的选择
    function pay(li){
        $(".COD").attr("class","common");
        li.attr("class","COD");
        $("#paytype").val(li.attr("data-id"));
    }
</script>
<script src="/admin/js/jquery.form.js"></script>
<script src="/home/js/cartconfirm.js"></script>
@include('inc.home.site-foot')
</body>
</html>
