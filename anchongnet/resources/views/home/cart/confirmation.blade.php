<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>订单确认</title>
    <link rel="stylesheet" type="text/css" href="home/css/confirmation.css">
</head>
<body>
<div class="site-top">
    <div class="top-container">
        <i><a class="index" href="">安虫首页</a></i>
        <ul class="info">
            <li>邮箱:<a href="mailto:www@anchong.net">www@anchong.net</a></li>
            <li><a href="">购物车<i class="carticon"></i></a></li>
            <li class="tel">垂询电话：0317-8155026</li>
            <li>
                <img class="little-tx" src="home/images/cart/tx.jpg"/>
                <span class="userinfo">
                    {{session('name')}}
                    <span class="info-triangle"></span>
                    <div class="cart">
                        <p><a href="">购物车</a></p>
                        <p><a href="">收藏夹</a></p>
                    </div>
                </span>
            </li>
        </ul>
    </div>
</div>
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
                <input type="submit" value="搜索" class="search-btn"/>
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
                <li class="default">
                    <p class="consignee">收货人：韩师傅</p>
                    <p class="telphone">联系电话：13845673333</p>
                    <p class="reciver-add">收货地址：北京市昌平区沙河镇于辛庄村天理家园C300</p>
                    <p class="selected"><img src="home/images/cart/selected.png"></p>
                </li>
                <li class="o-add">
                    <p class="consignee">收货人：韩师傅</p>
                    <p class="telphone">联系电话：13845673333</p>
                    <p class="reciver-add">收货地址：北京市昌平区沙河镇于辛庄村天理家园C300</p>
                    <p class="select"><img src="home/images/cart/selected.png"></p>
                </li>
                <li class="o-add">
                    <p class="consignee">收货人：韩师傅</p>
                    <p class="telphone">联系电话：13845673333</p>
                    <p class="reciver-add">收货地址：北京市昌平区沙河镇于辛庄村天理家园C300</p>
                    <p class="select"><img src="home/images/cart/selected.png"></p>
                </li>
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

<div class="site-footer">
    <div class="footer-top">
        <div class="footer-top-container">
            <div class="link">
                <h4>友情链接</h4>
                <hr class="line" />
                <div class="link-list">
                    <p><a href="">中国安防行业网</a></p>
                    <p><a href="">华强安防网</a></p>
                    <p><a href="">中国安防展览网</a></p>
                    <p><a href="">安防英才网</a></p>
                </div>
                <div class="link-list1">
                    <p><a href="">智能交通网</a></p>
                    <p><a href="">中国智能化</a></p>
                    <p><a href="">中关村在线</a></p>
                    <p><a href="">教育装备采购网</a></p>
                </div>
                <div class="link-list1">
                    <p><a href="">中国贸易网</a></p>
                    <p><a href="">华强电子网</a></p>
                    <p><a href="">研究报告中国测控网</a></p>
                    <p><a href="">五金机电网</a></p>
                </div>
                <div class="link-list1">
                    <p><a href="">中国安防展览网</a></p>
                    <p><a href="">民营企业网</a></p>
                    <p><a href="">中国航空新闻网</a></p>
                    <p><a href="">北极星电力</a></p>
                </div>
            </div>
            <div class="qr-code">
                <ul>
                    <li>
                        <h4>下载安虫APP客户端</h4>
                        <img src="home/images/1.jpg"/>
                    </li>
                    <li>
                        <h4>安虫微信订阅号</h4>
                        <img src="home/images/2.jpg"/>
                    </li>
                    <div class="cl"></div>
                </ul>
            </div>
            <div class="cl"></div>
        </div>
    </div>
    <div class="site-bottom">
        <div class="btottom">
            <div class="bottom-container">
                <p class="p1">
                    <a href="">关于安虫</a>
                    <span class="">|</span>
                    <a href="">联系我们</a>
                    <span class="">|</span>
                    <a href="">帮助中心</a>
                    <span class="">|</span>
                    <a href="">服务网点</a>
                    <span class="">|</span>
                    <a href="">法律声明</a>
                    <span class="">|</span>
                    客服热像400-888-888
                </p>
                <p class="p2">Copyright©北京安虫版权所有 anchong.net</p>
                <p class="p3">
                    <a href="">京ICP备111111号</a>
                    <span class="">|</span>
                    <a href="">出版物经营许可证</a>
                </p>
            </div>
        </div>
    </div>
</div>
</body>
</html>