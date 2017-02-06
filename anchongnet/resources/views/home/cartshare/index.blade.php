<!DOCTYPE html>
<html>
   <head>
       <title>购物车-安虫分享</title>
       <meta name="author" content="m.jd.com">
       <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
       <meta name="apple-mobile-web-app-capable" content="yes">
       <meta name="apple-mobile-web-app-status-bar-style" content="black">
       <meta name="format-detection" content="telephone=no">
       <meta http-equiv="Expires" CONTENT="-1">
       <meta http-equiv="Cache-Control" CONTENT="no-cache">
       <meta http-equiv="Pragma" CONTENT="no-cache">
   </head>

<body id="body">
<header>
    <div id="m_common_header"></div>
</header>

<link href="/home/cartshare/btn.css" media="all" rel="stylesheet" type="text/css">
<link href="/home/cartshare/spinner.css" media="all" rel="stylesheet" type="text/css">
<link href="/home/cartshare/recommend.css" media="all" rel="stylesheet" type="text/css">
<link href="/home/cartshare/shopping-cart5.3.css" media="all" rel="stylesheet" type="text/css">
<link href="/home/cartshare/toast.css" media="all" rel="stylesheet" type="text/css">
<div style="width:100%;z-index:1001;position:absolute;overflow:hidden;display:none" id="background" ></div>

<style>
.cart_item_text{
   font-size:13px;
   font-weight: bold;
   overflow:hidden;
   display: -webkit-box;
   -webkit-line-clamp: 2;
   -webkit-box-orient: vertical;
}
.cart_item_title{
   font-size:14px;
}
.cart_item_gift{
   font-size:13px;
   color: #999;
}
.cart_item_price{
   font-size:12px;
}
.cart_cutwords{
   overflow:hidden;
   display: -webkit-box;
   -webkit-line-clamp: 1;
   -webkit-box-orient: vertical;
   }

</style>
<div class="login-wrapper"  style="display:block" >
   <div class="header-login-info">
       <div class="header-login-info-left">还没有安装安虫APP？快点击下载吧！(微信请在右上角选择在浏览器中打开下载)</div>
       <div class="header-login-info-right">
           <a href="#" id="appdown" class="btn-jd-gray" >下载</a>
       </div>
   </div>
</div>

@if(!Auth::check())
<div class="login-wrapper" id="notEmptyCartLogin"  style="display:block" >
   <div class="header-login-info">
       <div class="header-login-info-left">请先登录</div>
       <div class="header-login-info-right">
           <a href="http://www.anchong.net/user/login/{{$shareId}}" class="btn-jd-red" >登录</a>
       </div>
   </div>
</div>
@else
<div class="login-wrapper" id="notEmptyCartLogin"  style="display:block" >
   <div class="header-login-info">
       <div class="header-login-info-left">切换用户</div>
       <div class="header-login-info-right">
           <a href="http://www.anchong.net/user/logout" class="btn-jd-red" >退出</a>
       </div>
   </div>
</div>
@endif
<div class="pop" id="giftWares11" style="margin-top:45px;margin-bottom:5%;z-index:1005;position: absolute;display:none" ></div>
@if($cartarr)
<div id="notEmptyCart"  style="display:block" >
    <form action="/cartshare" method="POST" class="form-horizontal form-inline f-ib" id="form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="shop-group">
        @foreach($cartarr as $shop)
        <div class="shop-group-item" data-vendorid="8888">
             <div class="shop-title customize-shtit">
                 <div class="item">
                      <!-- <div class="check-wrapper">
                           <span id="checkShop8888" class="cart-checkbox check-wrapper-unit" data-shopId="8888"  onclick="selectGroup('8888')" ></span>
                       </div> -->
                       <div class="shop-title-content">
                               <!-- <span class="shop-title-icon">
                                    <img src="//st.360buyimg.com/order/images/cart5.0/JDshopTitle.png?v=20161025">
                               </span> -->
                               <span class="shop-title-name">{{$shop['sname']}}</span>
                                   <!-- <input type="hidden" id="freeFreightPrice" value="79"/>
                                   <input type="hidden" id="vendorPrice" value=50.9> -->
                                   <div class="shop-btn-com freeFreight">
                                   </div>
                        </div>

                </div>
         </div>
         @foreach($shop['goods'] as $goods)
<ul class="shp-cart-list">
    <li name="productGroup-1">
       <div class="items">
               <input type="hidden" name="gid[]" class="editPara" value="{{$goods['gid']}}">

           <div class="check-wrapper">
                <input type="checkbox" name="goodsinfo[]" class="goodscheck" value="{{$goods['goodsinfo']}}" checked>
           </div>
           <div class="shp-cart-item-core shop-cart-display  ">
               <a class="cart-product-cell-1" href="#">
                   <img class="cart-photo-thumb" alt="" src="{{$goods['img']}}" onerror="#" />
               </a>
               <div class="cart-product-cell-2">
                   <div class="cart-product-name">
                       <a href="#">
                           <span>{{$goods['goods_name']}}</span>
                       </a>
                   </div>
                   <div class="cart-product-prop eles-flex">
                       <span class="prop1">商品规格:{{$goods['goods_type']}}</span>
                    </div>
                    <div class="cart-product-prop eles-flex">
                        <span class="prop1">OEM:{{$goods['oem']?$goods['oem']:"无"}}</span>
                     </div>
                    <!-- <div class="icon-list">
                       <span class="prop1">OEM:{{$goods['oem']?$goods['oem']:"无"}}</span>
                    </div> -->
                   <div class="cart-product-cell-3">
                    <span class="shp-cart-item-price goods_price">￥{{$goods['goods_price']}}</span>
					<span class="goods_num" style="display:none">.{{$goods['goods_num']}}</span>
                        <div class="quantity-wrapper customize-qua">
                           <!-- <input type="hidden" id="limitSukNum1895082" value="200">
                           <input type="hidden" id="remainNumInt1895082" value="-1">
                           <input type="hidden" id="atLeastNum1895082" value="-1"> -->
                           <a class="quantity-decrease disabled" href="javascript:subWareBybutton('8888','1895082');" onclick="checkLimitNum();"><span class="glyphicon glyphicon-minus"></span></a>
                           <input type="tel" size="4" value=" {{$goods['goods_num']}}" name="num[]" class="quantity" readonly="true">
                           <a class="quantity-increase" href="javascript:addWareBybutton('8888','1895082');"></a>
                       </div>
                   </div>
                   <!-- price move to here end -->
               </div>
                           <div class="cart-product-cell-5 main-pro-btns">
               </div>
           </div>
           </div>
    </li>
</ul>
         @endforeach
</div>
@endforeach
</div>
</form>
</div>
@else

<div id="emptyCart">

   <div class="shp-cart-empty">
       <em class="cart-empty-icn"></em>
       <span class="empty-msg">您来晚了，购物车分享已经结束了！</span>
   </div>
</div>

@endif

<div id="payment_p"  style="display:block" >
   <div id="paymentp"></div>
   <div class="payment-total-bar payment-total-bar-new box-flex-f" id="payment">
       <div class="shp-chk shp-chk-new  box-flex-c">
           <input type="checkbox" style="float: left;" id="checkall" value="" onclick="checkall();">
           <span class="cart-checkbox-text">全选</span>
       </div>
       <div class="shp-cart-info shp-cart-info-new  box-flex-c">
           <strong  id="shpCartTotal" data-fsizeinit="14" class="shp-cart-total">合计:<span class="bottom-bar-price" id="cart_realPrice">￥0</span></strong>
           <span id="saleOffNew" data-fsizeinit="10" class="sale-off sale-off-new  bottom-total-price">总额:<span class="money-unit-bf" id="cart_oriPrice">￥0</span></span>
       </div>
       @if(Auth::check())
       <a class="btn-right-block btn-right-block-new  box-flex-c" id="submit">加入购物车</a>
       @else
       <a class="btn-right-block btn-right-block-new  box-flex-c" style="background:#C4C4C4">请先登录</a>
       @endif
   </div>
</div>
<script src="/home/js/jquery-3.1.0.min.js"></script>
<script src="/admin/js/jquery.form.js"></script>
<script>

    function checkall(){
        //定义全选全不选
        if($('#checkall').is(':checked')){
            $('.goodscheck').prop('checked','checked');
        }else{
            $('.goodscheck').prop('checked',false);
        }
    }

    //定义总价
    var total_price=0;
    var price=$(".goods_price").text().split("￥");
    var num=$(".goods_num").text().split(".");
    for($i=0;$i<price.length;$i++){
        total_price+=Number(price[$i])*Number(num[$i]);
    }
    $("#cart_realPrice").text("￥"+total_price);
    $("#cart_oriPrice").text(total_price);
    //当点击加入购物车的时候把表单提交了
    $("#submit").click(function(){
        $("#form").ajaxSubmit({
            success: function (data) {
                alert(data);
            }
        });
    });
</script>
<script>
    function flexible(desW){
        var winW = document.documentElement.clientWidth;
        var scale = desW/100;
        if(winW>desW){/*设备宽度大于设计稿宽度时*/
            document.documentElement.style.fontSize = "100px"
        }else{
            document.documentElement.style.fontSize = winW/scale+"px";
        }
    }
    flexible(640);
    // 获取终端的相关信息
    var Terminal = {
        // 辨别移动终端类型
        platform : function(){
            var u = navigator.userAgent, app = navigator.appVersion;
            return {
                // android终端或者uc浏览器
                android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1,
                // 是否为iPhone或者QQHD浏览器
                iPhone: u.indexOf('iPhone') > -1 ,
                // 是否iPad
                iPad: u.indexOf('iPad') > -1
            };
        }(),
        // 辨别移动终端的语言：zh-cn、en-us、ko-kr、ja-jp...
        language : (navigator.browserLanguage || navigator.language).toLowerCase()
    }

    // 根据不同的终端，跳转到不同的地址
    var theUrl = 'http://app.anchong.net/';
    if(Terminal.platform.android){
        theUrl = 'http://app.anchong.net/app.anchong.net.apk';
    }else if(Terminal.platform.iPhone){
        theUrl = 'https://itunes.apple.com/cn/app/an-chong/id1135316311?l=en&mt=8';
    }else if(Terminal.platform.iPad){
        // 还可以通过language，区分开多国语言版
        switch(Terminal.language){
            case 'en-us':
                theUrl = 'https://itunes.apple.com/cn/app/an-chong/id1135316311?l=en&mt=8';
                break;
            case 'ko-kr':
                theUrl = 'https://itunes.apple.com/cn/app/an-chong/id1135316311?l=en&mt=8';
                break;
            case 'ja-jp':
                theUrl = 'https://itunes.apple.com/cn/app/an-chong/id1135316311?l=en&mt=8';
                break;
            default:
                theUrl = 'https://itunes.apple.com/cn/app/an-chong/id1135316311?l=en&mt=8';
        }
    }
    $("#appdown").attr('href',theUrl);
    //location.href = theUrl;

</script>
</body>
</html>
