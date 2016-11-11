<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>购物车</title>
    <link rel="stylesheet" type="text/css" href="{{asset('home/css/cart.css')}}">
    <link rel="stylesheet" href="{{asset('home/css/top.css')}}">
    <script src="{{asset('home/js/jquery-3.1.0.js')}}"></script>
    <script src="{{asset('home/js/top.js')}}"></script>
    <script src="{{asset('home/org/layer/layer.js')}}"></script>
    <script src="{{asset('home/js/cartdetail.js')}}"></script>
</head>
<body>
@include('inc.home.top')
<div class="header">
    <div class="header-container">
        <div class="logo">
            <a href="{{url('/')}}">
                <img  src="{{asset('home/images/cart/logo_01.jpg')}}"/>
                <span class="logo-title">安虫购物车</span>
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
            @if(count($cartarr) == 0)
                <li style="text-align: center;color:#f53745;font-size: 22px">购物车暂无商品</li>
            @else
            @foreach($cartarr as $shop)
            <li class="shop">
                <i class="store">店铺：</i>
                <a class="shop-name" href="">{{$shop['sname']}}</a>
            </li>
                @foreach($shop['goods'] as $value)
                <li class="goods-info">
                    <ul>
                        <li><input type="checkbox" name="goodsinfo[]" class="select" value="{{$value['goodsinfo']}}" onclick="totalcheck()" checked></li>
                        <li class="goods-img"><img src="{{$value['img']}}"></li>
                        <li class="goods-desc">
                            <p class="goods-name"><a href="">{{$value['goods_name']}}</a></p>
                            <p class="goods-type">规格：{{$value['goods_type']}}&nbsp;&nbsp;{{$value['oem']?"oem:".$value['oem']:""}}</p>
                        </li>
                        <li class="goods-price">￥{{$value['goods_price']}}</li>
                        <li class="goods-number">
                            <a class="minus" onclick="Minus(this)" data-id={{$value['cart_id']}}></a>
                            <input class="count" type="text" value="{{$value['goods_num']}}">
                            <a class="add" onclick="Add(this)" data-id={{$value['cart_id']}}></a>
                        </li>
                        <li class="total-price">￥{{$value['goods_num'] * $value['goods_price']}}</li>
                        <li class="goods-handle">
                            <p class="favorite"><a onclick="Favorite({{$value['gid']}})">转为收藏</a></p>
                            <p class="del"><a onclick="DelCart({{$value['cart_id']}})">删除</a></p>
                        </li>
                    </ul>
            </li>
            @endforeach
        @endforeach
        @endif
        </ul>
        <ul class="settlement">
            <li class="all">
                <input type="checkbox" class="check1" id="checkall" onclick="checkall();">
                <a href="javascript:">全选</a>
            </li>
            <div style="float:right">
            <li class="selected-good" >
                <i class="amount"></i>
                已选商品
                <i class="count-num">0</i>
                种
            </li>
            <li class="freight">
                合计（不含运费）
                <i class="count-price" id="cart_realPrice">￥0</i>
            </li>
            <li ><a class="pay" href="{{url('/cartconfirm')}}">去结算</a></li>
        </div>
            <div class="cl">
            </div>
        </ul>
    </div>
</div>
@include('inc.home.site-foot')
</body>

<script>
//总价格和总数量修改
function totalcheck(){
    total_price=0;
    price=$('.select:checked').parent().siblings('.total-price').text().split("￥");
    for($i=0;$i<price.length;$i++){
        total_price+=Number(price[$i]);
    }
    $(".count-num").text($('.select:checked').length);
    $("#cart_realPrice").text("￥"+total_price);
}

function checkall(){
    //定义全选全不选
    if($('#checkall').is(':checked')){
        $('.select').prop('checked','checked');
    }else{
        $('.select').prop('checked',false);
    }
    total_price=0;
    price=$('.select:checked').parent().siblings('.total-price').text().split("￥");
    for($i=0;$i<price.length;$i++){
        total_price+=Number(price[$i]);
    }
    $(".count-num").text($('.select:checked').length);
    $("#cart_realPrice").text("￥"+total_price);
}

function DelCart(cart_id) {
    layer.confirm('你确定要删除这个商品么？',{
        btn:['确定','取消']
    },function () {
        $.post("{{url('/cart')}}/"+cart_id,{'_method':'delete','_token':'{{csrf_token()}}'},function (data) {
            if(data.status == 0){
                location.href=location.href;
                layer.msg(data.msg,{icon:6});
            }else{
                location.href=location.href;
                layer.msg(data.msg,{icon:5});
            }
        })
    },
    function () {

    })
}
function Favorite(gid) {
    var data = {'users_id':'{{$msg->users_id}}','coll_id':gid,'coll_type':'1','_token':'{{csrf_token()}}'};
    $.post('/collect',data,function (msg) {
        layer.msg(msg.msg,{icon: 6});
    });
}
</script>
<script src="/home/js/cart.js"></script>
</html>
