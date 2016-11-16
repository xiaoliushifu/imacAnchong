$(function () {
    var state=true;
    console.log($('.select:checked').parent().siblings('.total-price').text());
    //定义总价
    var total_price=0;
    var price=$(".total-price").text().split("￥");
    for($i=0;$i<price.length;$i++){
        total_price+=Number(price[$i]);
    }
    //数量与价格修改
    $(".count-num").text($('.select:checked').length);
    $("#cart_realPrice").text("￥"+total_price);
    //增加购物车数量的按钮
    $('.add').click(function(){
    		//先设置页面数量
    		var num = $(this).parent('li').children('input').val();
    		var id=$(this).attr('data-id');
        num = parseInt(num)+1;
        $(this).parent('li').children('input').val(num);
        $(this).prev().prev().attr('disabled',false);
        var that=$(this);
        if(state){
            state=false;
            setTimeout(function(){
                var num=that.prev().val();
                $.get('/cart/'+id+'/edit',{goods_num:num},function(result){
                        if(result){
                            that.prev().val(result);
                            that.parent().next().text("￥"+Number(that.parent().prev().text().replace('￥',''))*Number(result));
                            totalcheck();
                        }
                });
                state=true;
            },1000);
        }
    });
    //减少购物车数量的按钮
    $('.minus').click(function(){
	    	//先改变页面数量
	    	var num = $(this).parent('li').children('input').val();
	    if (num > 1) {
	        num = parseInt(num);
	        num = num - 1;
	        $(this).parent('li').children('input').val(num);
	    } else {
	        $(this).parent('li').children('input').val(1);
	        $(this).attr('disabled',true);
	        return false;
	    }
	    //去服务端更新数量
	    var id=$(this).attr('data-id');
	    var that=$(this);
	    if(state){
	        state=false;
	        setTimeout(function(){
	            var num=that.next().val();
	            $.get('/cart/'+id+'/edit',{goods_num:num},function(result){
	                    if(result){
	                        that.next().val(result);
	                        that.parent().next().text("￥"+Number(that.parent().prev().text().replace('￥',''))*Number(result));
	                        totalcheck();
	                    }
	            });
	        state=true;
	        },1000);
	    }
    });
	//直接输入数量
    $(".count").keyup(function(){
    		var num = $(this).val();
	    if (num > 1) {
	        $(this).val(num);
	        $(this).prev().attr('disabled',false);
	    } else {
	        $(this).val(1);
	        $(this).prev().attr('disabled',true);
	    }
        var id=$(this).prev().attr('data-id');
        var that=$(this);
        if(state){
            state=false;
            setTimeout(function(){
                var num=that.val();
                $.get('/cart/'+id+'/edit',{goods_num:num},function(result){
                        if(result){
                            that.val(result);
                            that.parent().next().text("￥"+Number(that.parent().prev().text().replace('￥',''))*Number(result));
                            totalcheck();
                        }
                });
                state=true;
            },1000);
        }
        $(this).blur();
    });
});
