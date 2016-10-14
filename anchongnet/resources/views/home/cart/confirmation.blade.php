<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>订单确认</title>
    <link rel="stylesheet" type="text/css" href="home/css/confirmation.css">
    <link rel="stylesheet" href="home/css/top.css">
    <script src="home/js/top.js"></script>
    <script src="home/js/jquery-3.1.0.js"></script>
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
                <i class="manage"><a href="">管理收货地址</a></i>
            </div>
            <ul class="address-list">
                @foreach($deaddr as $value)
                <li class="default">
                    <p class="consignee">收货人：{{$value->add_name}}</p>
                    <p class="telphone">联系电话：{{$value ->phone}}</p>
                    <p class="reciver-add">收货地址：{{$value->region}}&nbsp;&nbsp;{{$value->address}}</p>
                    <p class="selected"><img src="home/images/cart/selected.png"></p>
                </li>
                @endforeach
                @if(count($addr)==0)

                <li class="o-add">
                    <p style="text-align: center;color:#f53745;line-height: 50px">暂无更多地址</p>
                </li>
                <li class="o-add">
                    <p style="text-align: center;color: #f53745;line-height: 50px">暂无更多地址</p>
                </li>
                @elseif(count($addr)==1)
                    @foreach($addr as $v)
                <li class="o-add">
                    <p class="consignee">收货人：{{$v -> add_name}}</p>
                    <p class="telphone">联系电话：{{$v -> phone}}</p>
                    <p class="reciver-add">收货地址：{{$v ->region}}&nbsp;&nbsp;{{$v -> address}}</p>
                    <p class="select"><img src="home/images/cart/selected.png"></p>
                </li>
                <li class="o-add">
                    <p style="text-align: center;color: #f53745;line-height: 50px">暂无更多地址</p>
                </li>
                        @endforeach
                @elseif(count($addr)==2)
                    @foreach($addr as $v)
                        <li class="o-add">
                            <p class="consignee">收货人：{{$v -> add_name}}</p>
                            <p class="telphone">联系电话：{{$v -> phone}}</p>
                            <p class="reciver-add">收货地址：{{$v ->region}}&nbsp;&nbsp;{{$v -> address}}</p>
                            <p class="select"><img src="home/images/cart/selected.png"></p>
                        </li>
                    @endforeach
                @endif
                <li class="add-address"><a href=""><img src="home/images/cart/add_address.png"></a></li>
                <div class="cl"></div>
            </ul>
            <p class="show-add"><a href="">显示全部地址</a></p>
        </div>
        <ul class="payment">
            <h3>支付方式</h3>
            <li class="COD">货到付款</li>
            <li class="alipay">支付宝支付</li>
            <li class="wechatpay">微信支付</li>
            <li class="online-pay">在线付款</li>
            <div class="cl"></div>
        </ul>
        <ul class="confirmed">
            <h3>确认订单信息</h3>
            <li class="order-nav">
                <ul>
                    <li class="shop-name">商品/商铺:<a href="">小白白的店</a></li>
                    <li class="price">单价</li>
                    <li class="number">数量</li>
                    <li class="count">总计</li>
                    <div class="cl"></div>
                </ul>
            </li>
            <span class="partition"></span>
            <li class="order-info">
                <ul>
                    <li class="goods-img"><img src="home/images/cart/goods.jpg"></li>
                    <li class="goods-desc">
                        <h5 class="goods-name">312-双门双向网络型控制板&nbsp;AT8002</h5>
                        <p class="goods-type">商品规格：312</p>
                    </li>
                    <li class="goods-price">130</li>
                    <li class="goods-number">2</li>
                    <li class="count-price">260</li>
                </ul>
            </li>
            <li class="order-info">
                <ul>
                    <li class="goods-img"><img src="home/images/cart/goods.jpg"></li>
                    <li class="goods-desc">
                        <h5 class="goods-name">312-双门双向网络型控制板&nbsp;AT8002</h5>
                        <p class="goods-type">商品规格：312</p>
                    </li>
                    <li class="goods-price">130</li>
                    <li class="goods-number">2</li>
                    <li class="count-price">260</li>
                </ul>
            </li>
            <li class="order-info">
                <ul>
                    <li class="goods-img"><img src="home/images/cart/goods.jpg"></li>
                    <li class="goods-desc">
                        <h5 class="goods-name">312-双门双向网络型控制板&nbsp;AT8002</h5>
                        <p class="goods-type">商品规格：312</p>
                    </li>
                    <li class="goods-price">130</li>
                    <li class="goods-number">2</li>
                    <li class="count-price">260</li>
                </ul>
            </li>
            <li class="sum">
                <p class="order-price">订单总额：<i>780</i>元</p>
                <p class="freight">运费：<i>0</i>元</p>
            </li>
            <li class="order-other">
                <p class="remark">添加订单备注</p>
                <form>
                    <input class="remark-info" type="text">
                </form>
                <h3 class="bill">发票信息</h3>
                <span class="bill-type">普通发票（电子）</span>
                <span class="bill-title">个人</span>
                <span class="bill-info">明细</span>
                <span class="change"><a>修改</a></span>
            </li>
            <span class="partition"></span>
            <li class="submit">
                <span class="amount">应付总额：<i>780元</i></span>
                <form class="commit">
                    <input class="btn" type="submit" value="提交订单">
                </form>
            </li>
        </ul>
    </div>
</div>
@include('inc.home.site-foot')
</body>
</html>
