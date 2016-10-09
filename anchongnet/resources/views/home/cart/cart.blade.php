<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>购物车</title>
    <link rel="stylesheet" type="text/css" href="home/css/cart.css">
    <link rel="stylesheet" href="home/css/top.css">
    <script src="home/js/top.js"></script>

</head>
<body>
@include('inc.home.top')
<div class="header">
    <div class="header-container">
        <div class="logo">
            <a href="{{url('/')}}">
                <img  src="home/images/cart/logo_01.jpg"/>
                <span class="logo-title">安虫购物车</span>
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
@include('inc.home.site-foot')
</body>
</html>