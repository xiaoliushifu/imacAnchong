<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>购物车</title>
    <link rel="stylesheet" type="text/css" href="home/css/cart.css">
</head>
<body>
<div class="site-top">
    <div class="top-container">
        <i><a class="index" href="">安虫首页</a></i>
        <ul class="info">
            <li>邮箱:<a href="mailto:www@anchong.net">www@anchong.net</a></li>
            <li><a href="">购物车<i class="carticon"></i></a></li>
            <li class="tel">垂询电话：010-88888888</li>
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
            <img  src="home/images/cart/logo_01.jpg"/>
            <span class="logo-title">安虫购物车</span>
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
        <ul class="cart-title">
            <li><span class="check1"></span><a href="javascript:">全选</a></li>
            <li class="goods">商品</li>
            <li class="price">单价（元）</li>
            <li class="number">数量</li>
            <li class="total">总价（元）</li>
            <li class="handle">操作</li>
            <div class="cl"></div>
        </ul>
        <ul class="order">
            <li class="shop">
                <i class="store">店铺：</i>
                <a class="shop-name" href="">小白白的店</a>
            </li>
            <li class="goods-info">
                <ul>
                    <li><input type="checkbox" class="select"></li>
                    <li class="goods-img"><img src="home/images/cart/goods.jpg"></li>
                    <li class="goods-desc">
                        <p class="goods-name"><a href="">普通一拓扑打&nbsp;普通双磁力锁停车管理系统</a></p>
                        <p class="goods-type">白色#300612号</p>
                    </li>
                    <li class="goods-price">130</li>
                    <li class="goods-number">
                        <a class="minus" href=""></a>
                        <input class="count" type="text"value="1">
                        <a class="add" href=""></a>
                    </li>
                    <li class="total-price">130</li>
                    <li class="goods-handle">
                        <p class="favorite"><a href="">转为收藏</a></p>
                        <p class="del"><a href="">删除</a></p>
                    </li>
                </ul>
            </li>
            <li class="goods-info" style="margin-top: 1px">
                <ul>
                    <li><input type="checkbox" class="select"></li>
                    <li class="goods-img"><img src="home/images/cart/goods.jpg"></li>
                    <li class="goods-desc">
                        <p class="goods-name"><a href="">普通一拓扑打&nbsp;普通双磁力锁停车管理系统</a></p>
                        <p class="goods-type">白色#300612号</p>
                    </li>
                    <li class="goods-price">130</li>
                    <li class="goods-number">
                        <a class="minus" href=""></a>
                        <input class="count" type="text"value="1">
                        <a class="add" href=""></a>
                    </li>
                    <li class="total-price">13000</li>
                    <li class="goods-handle">
                        <p class="favorite"><a href="">转为收藏</a></p>
                        <p class="del"><a href="">删除</a></p>
                </ul>
            </li>
            <li class="goods-info" style="margin-top: 1px">
                <ul>
                    <li><input type="checkbox" class="select"></li>
                    <li class="goods-img"><img src="home/images/cart/goods.jpg"></li>
                    <li class="goods-desc">
                        <p class="goods-name"><a href="">普通一拓扑打&nbsp;&nbsp;普通双磁力锁停车管理系统普通一拓扑达&nbsp;普通双磁力锁停车管理系统</a></p>
                        <p class="goods-type">白色#300612号</p>
                    </li>
                    <li class="goods-price">130</li>
                    <li class="goods-number">
                        <a class="minus" href=""></a>
                        <input class="count" type="text"value="1">
                        <a class="add" href=""></a>
                    </li>
                    <li class="total-price">3560</li>
                    <li class="goods-handle">
                        <p class="favorite"><a href="">转为收藏</a></p>
                        <p class="del"><a href="">删除</a></p>
                </ul>
            </li>
        </ul>
        <ul class="order1">
            <li class="shop">
                <input type="checkbox" class="selected">
                <i class="store1">店铺：</i>
                <a class="shop-name" href="">小白白的店</a>
            </li>
            <li class="goods-info">
                <ul>
                    <li><input type="checkbox" class="selected"></li>
                    <li class="goods-img"><img src="home/images/cart/goods.jpg"></li>
                    <li class="goods-desc">
                        <p class="goods-name"><a href="">普通一拓扑打&nbsp;普通双磁力锁停车管理系统</a></p>
                        <p class="goods-type">白色#300612号</p>
                    </li>
                    <li class="goods-price">130</li>
                    <li class="goods-number">
                        <a class="minus" href=""></a>
                        <input class="count" type="text"value="1">
                        <a class="add" href=""></a>
                    </li>
                    <li class="total-price">130</li>
                    <li class="goods-handle">
                        <p class="favorite"><a href="">转为收藏</a></p>
                        <p class="del"><a href="">删除</a></p>
                </ul>
            </li>
            <li class="goods-info" style="margin-top: 1px">
                <ul>
                    <li><input type="checkbox" class="selected"></li>
                    <li class="goods-img"><img src="home/images/cart/goods.jpg"></li>
                    <li class="goods-desc">
                        <p class="goods-name"><a href="">普通一拓扑打&nbsp;&nbsp;普通双磁力锁停车管理系统普通一拓扑达&nbsp;普通双磁力锁停车管理系统</a></p>
                        <p class="goods-type">白色#300612号</p>
                    </li>
                    <li class="goods-price">130</li>
                    <li class="goods-number">
                        <a class="minus" href=""></a>
                        <input class="count" type="text" value="1">
                        <a class="add" href=""></a>
                    </li>
                    <li class="total-price">4000</li>
                    <li class="goods-handle">
                        <p class="favorite"><a href="">转为收藏</a></p>
                        <p class="del"><a href="">删除</a></p>
                </ul>
            </li>
        </ul>
        <ul class="settlement">
            <li class="all">
                <input type="checkbox" class="check1">
                <a href="javascript:">全选</a>
            </li>
            <li class="delete">
                <a href="">删除</a>
            </li>
            <li class="collect">
                <a href="">转为收藏</a>
            </li>
            <li class="unit-price">单价（元）</li>
            <li class="selected-good">
                <i class="amount">数量</i>
                已选商品
                <i class="count-num">5</i>
                件
            </li>
            <li class="freight">
                合计（不含运费）
                <i class="count-price">4013.00</i>
            </li>
            <li><a class="pay" href="">去结算</a></li>
            <div class="cl"></div>
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