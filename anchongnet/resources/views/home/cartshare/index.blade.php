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
<div class="login-wrapper" id="notEmptyCartLogin"  style="display:block" >
   <div class="header-login-info">
       <div class="header-login-info-left">登录后可同步电脑与手机购物车中的商品</div>
       <div class="header-login-info-right">
           <a href="javascript:beLogin('http://www.anchong.net')" class="btn-jd-red" >
                                       登录
       </a>
       </div>
   </div>
</div>

<div report-eventid="MHome_BacktoTop" page_name="index" class="bottom-to-top J_ping" id="indexToTop">
   <img src="//st.360buyimg.com/order/images/cart/scroll-to-top-icon.png?v=20161025" style="width: 100%;">
</div>
<div class="pop" id="giftWares11" style="margin-top:45px;margin-bottom:5%;z-index:1005;position: absolute;display:none" ></div>
<div id="notEmptyCart"  style="display:block" >


       <div class="shop-group">





           <div class="shop-group-item" id="shop-1" data-vendorid="8888">


               <div class="shop-title customize-shtit">
                   <div class="item">
                       <div class="check-wrapper">
                           <span id="checkShop8888" class="cart-checkbox check-wrapper-unit" data-shopId="8888"  onclick="selectGroup('8888')" ></span>
                       </div>
                       <div class="shop-title-content">
                               <span class="shop-title-icon">
                                    <img src="//st.360buyimg.com/order/images/cart5.0/JDshopTitle.png?v=20161025">
                               </span>
                               <span class="shop-title-name">京东自营</span>
                                   <input type="hidden" id="freeFreightPrice" value="79"/>
                                   <input type="hidden" id="vendorPrice" value=50.9>
                                        <div class="shop-btn-com" id="freeFreight">
                                        </div>

                           </div>

                   </div>
               </div>
               <ul class="shp-cart-list">
                       <input type="hidden" name="skuIds"  value="1895082">

               <input type="hidden" name="skuIds8888" id="1895082" value="1895082">
       <input type="hidden" name="skuIdSelected8888" id="selected1895082" value="1">

<li id="product1895082" name="productGroup-1">
   <div class="items">
           <input type="hidden" name="editPara" class="editPara" value='{"isPure":true,"shopId":"-1","skuId":"1895082","suitId":"","suitNum":"","sType":"","skuNum":"1","venderId":"8888","mainSkuId":"","mainSkuNum":"","limitSkuNum":"200","remainNumInt":"-1","canExtendedWarrenty": false,"numAtLeast":-1,"isSamPro": false}'>
       <div class="check-wrapper">
           <span id="checkIcon1895082" data-sku="1895082@@1"   class="cart-checkbox group-8888 checked"  onclick="changeSelected('8888',1895082,1)" ></span>
       </div>
       <div class="shp-cart-item-core shop-cart-display  ">
           <a class="cart-product-cell-1" href="javascript:beWareDetail('1895082')">
               <img class="cart-photo-thumb" alt="" src="//img10.360buyimg.com/n7/jfs/t2284/285/1812862953/100750/d4cb1772/567ba6c7N7a89ffbc.jpg!q70.jpg" onerror="//misc.360buyimg.com/lib/skin/e/i/error-jd.gif" />
           </a>
           <div class="cart-product-cell-2">
               <div class="cart-product-name">
                   <a href="javascript:beWareDetail('1895082')">
                       <span>【京东超市】内蒙特产 天美华乳 额颉奶贝 250g（原奶味）</span>
                   </a>
               </div>
               <div class="cart-product-prop eles-flex">
                   <span class="prop1">口味:牛奶奶片 250g</span>
                </div>
                <div class="icon-list">
                                       <!-- 比加入时降价信息-->
                </div>
               <div class="cart-product-cell-3">
                <span class="shp-cart-item-price" id="price1895082">¥11.00</span>
                    <div class="quantity-wrapper customize-qua">
                       <input type="hidden" id="limitSukNum1895082" value="200">
                       <input type="hidden" id="remainNumInt1895082" value="-1">
                       <input type="hidden" id="atLeastNum1895082" value="-1">
                       <a class="quantity-decrease disabled" id="subnum1895082" href="javascript:subWareBybutton('8888','1895082');" onclick="checkLimitNum();"><span class="glyphicon glyphicon-minus"></span></a>
                       <input type="tel" size="4" value="1" name="num" id="num1895082" class="quantity" onchange="checkLimitToast(-1);modifyWare('8888','1895082')">
                       <a class="quantity-increase " id="addnum1895082" href="javascript:addWareBybutton('8888','1895082');"></a>
                   </div>
               </div>
               <!-- price move to here end -->
           </div>
                       <div class="cart-product-cell-5 main-pro-btns">
           </div>
       </div>
       </div>
</li>

                       <input type="hidden" name="skuIds"  value="1685734">

               <input type="hidden" name="skuIds8888" id="1685734" value="1685734">
       <input type="hidden" name="skuIdSelected8888" id="selected1685734" value="1">

<li id="product1685734" name="productGroup-1">
   <div class="items">
           <input type="hidden" name="editPara" class="editPara" value='{"isPure":true,"shopId":"-1","skuId":"1685734","suitId":"","suitNum":"","sType":"","skuNum":"1","venderId":"8888","mainSkuId":"","mainSkuNum":"","limitSkuNum":"200","remainNumInt":"-1","canExtendedWarrenty": false,"numAtLeast":-1,"isSamPro": false}'>
       <div class="check-wrapper">
           <span id="checkIcon1685734" data-sku="1685734@@1"   class="cart-checkbox group-8888 checked"  onclick="changeSelected('8888',1685734,1)" ></span>
       </div>
       <div class="shp-cart-item-core shop-cart-display  ">
           <a class="cart-product-cell-1" href="javascript:beWareDetail('1685734')">
               <img class="cart-photo-thumb" alt="" src="//img10.360buyimg.com/n7/jfs/t1519/115/539376503/119462/58b5dfce/55936094Nd8f36e6a.jpg!q70.jpg" onerror="//misc.360buyimg.com/lib/skin/e/i/error-jd.gif" />
                                           </a>
           <div class="cart-product-cell-2">
               <div class="cart-product-name">
                   <a href="javascript:beWareDetail('1685734')">
                       <span>


                                                                                                               【京东超市】格兰特特浓黑咖啡（速溶）100g
                       </span>
                   </a>
               </div>                                  <div class="cart-product-prop eles-flex">
                                                               <span class="prop1">口味:特浓黑咖啡（速溶）100g</span>
                                                           </div>
                               <div class="icon-list">
                                       <!-- 比加入时降价信息-->
                                   </div>



               <div class="cart-product-cell-3">
                                       <span class="shp-cart-item-price" id="price1685734">¥39.90</span>
                                                                                                                                                                                                                                                                                       <div class="quantity-wrapper customize-qua">
                       <input type="hidden" id="limitSukNum1685734" value="200">
                       <input type="hidden" id="remainNumInt1685734" value="-1">
                       <input type="hidden" id="atLeastNum1685734" value="-1">
                       <a class="quantity-decrease disabled" id="subnum1685734" href="javascript:subWareBybutton('8888','1685734');" onclick="checkLimitNum();"></a>
                       <input type="tel" size="4" value="1" name="num" id="num1685734" class="quantity" onchange="checkLimitToast(-1);modifyWare('8888','1685734')">
                       <a class="quantity-increase " id="addnum1685734" href="javascript:addWareBybutton('8888','1685734');"></a>
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
        </div>
    </div>

</div>
<div id="emptyCart"  style="display:none" >

   <div class="shp-cart-empty"  style="display: none" >
       <em class="cart-empty-icn"></em>
       <span class="empty-msg">购物车空空如也,赶紧逛逛吧~</span>
   </div>

   <div class="shopping-guess-container" id="emptycartHotRecommend">
   <div class="shopping-guess   " id="guessID">
       <!-- 看看热卖 begin -->
       <div class="gray-text">
           <span class="gray-layout"><span class="gray-text-img"></span>看看热卖</span>
       </div>
       <ul class="similar-ul cf" id="emptyRecommendID">

       </ul>
       <img src="//st.360buyimg.com/order/images/cart5.0/no-more.png?v=20161025" class="no-more">
       <span class="txt-nomore-msg">热卖商品实时更新，常回来看看哦~</span>
       <!-- 看看热卖 end -->
   </div>
   </div>
</div>




<div class="shopping-guess-container" id="notEmptyRecommend">
   <div class="shopping-guess   " id="guessID">
       <!-- 看看热卖 begin -->
       <div class="gray-text">
           <span class="gray-layout"><span class="gray-text-img"></span>你可能还想要</span>
       </div>
       <ul class="similar-ul cf" id="recommendID">

       </ul>
       <img src="//st.360buyimg.com/order/images/cart5.0/no-more.png?v=20161025" class="no-more">
       <span class="txt-nomore-msg">以上根据您购物车中已有商品推荐</span>
       <!-- 看看热卖 end -->
   </div>
</div>


<div id="payment_p"  style="display:block" >
   <div id="paymentp"></div>
   <div class="payment-total-bar payment-total-bar-new box-flex-f" id="payment">
       <div class="shp-chk shp-chk-new  box-flex-c">
           <span onclick="checkAllHandler();"  class="cart-checkbox checked"  id="checkIcon-1"></span>
           <span class="cart-checkbox-text">全选</span>
       </div>
       <div class="shp-cart-info shp-cart-info-new  box-flex-c">
           <strong  id="shpCartTotal" data-fsizeinit="14" class="shp-cart-total">合计:<span class="bottom-bar-price" id="cart_realPrice"> ¥50.90</span></strong>
           <span id="saleOffNew" data-fsizeinit="10" class="sale-off sale-off-new  bottom-total-price">总额:<span class="money-unit-bf" id="cart_oriPrice">50.90</span>立减:<span class="money-unit-bf" id="cart_rePrice">0.00</span></span>
       </div>
       <a class="btn-right-block btn-right-block-new  box-flex-c" id="submit">加入购物车</a>
   </div>
</div>
</body>
</html>
