$(function(){
		//规格参数
        $(".param").click(function(){
            $("#param").show();
            $("#package").hide();
            $("#mainpic").hide();
        });
        //商品详情
        $(".mainpic").click(function(){
            $("#mainpic").show();
            $("#package").hide();
            $("#param").hide();
        });
        //相关资料
        $(".package").click(function(){
            $("#package").show();
            $("#mainpic").hide();
            $("#param").hide();
        });
    //属性的选中
    $('.suit ul li').click(function () {
        $(this).addClass('ms').siblings('li').removeClass('ms');
        $(this).css({'color':'#f53745','border':'1px solid #f53745'}).siblings('li').css({'color':'#4a4a4a','border':'1px solid #606060'});
        //切换商品属性时
        var goods_type='';
        $('.ms').each(function(i){
    			goods_type+=$(this).text()+" ";
        });
        $.get('/equipment/goodspe',{gn:goods_type,goodid:location.pathname.split('/')[3]},function(data){
        		if(data.msg) {
        			layer.msg(data.msg);
        		}else{
        			$('#whgid').val(data.gid);
        			if (data.ur != 1) {//认证
        				if (data.promotion_price > 0 && data.promotion_price < data.vip_price) {
        					$('.goodsprice p:first').replaceWith('<p><span>促销价：￥<i id="pro-price" class="goods-price">'+data.promotion_price+'</i></span></p>');
        					$('.goodsprice p:eq(1)').replaceWith('<p><span>会员价：￥<i id="v-price">'+data.vip_price+'</i></span></p>');
        					$('#v-price').removeClass('goods-price');
        				} else {
        					$('.goodsprice p:first').replaceWith('<p>价格：￥<i id="price">'+data.market_price+'</i></p>');
        					$('.goodsprice p:eq(1)').replaceWith('<p><span>会员价：￥<i id="v-price" class="goods-price">'+data.vip_price+'</i></span></p>');
        					$('#pro-price').removeClass('goods-price');
        				}
        			//未认证
        			} else {
        				if (data.promotion_price > 0) {
        					$('.goodsprice p:first').replaceWith('<p><span>促销价：￥<i id="pro-price" class="goods-price">'+data.promotion_price+'</i></span></p>');
        				} else {
        					$('.goodsprice p:first').replaceWith('<p>价格：￥<i id="price" class="goods-price">'+data.market_price+'</i></p>');
        				}
        			}
        			$('.mastermap img').attr('src',data.goods_img);
        		}
        });
    });
    //oem的操作
    $('.oem').click(function () {
        $(this).attr('id','oem').siblings('li').removeAttr('id');
        $(this).css({'color':'#f53745','border':'1px solid #f53745'}).siblings('li').css({'color':'#4a4a4a','border':'1px solid #606060'});
    })
    /*
    点击切换图片
   */
      $('.thumb img').click(function(){
          $("#tail").attr("src",$(this).attr('src'));
      });
});
/*
选择商品数量
 */
//数量减少1
function Minus() {
    var num = $('#goodsnum').val();
    if(num > 1 ){
        num = parseInt(num);
        num = num - 1;
        $('#goodsnum').val(num);
    }else{
        $('#goodsnum').val('1');
    }
}
//数量增加1
function Add() {
    var num = $('#goodsnum').val();
    num = parseInt(num);
    num = num + 1;
    $('#goodsnum').val(num);
}
function Buy() {
    console.log('No Supported');
}
