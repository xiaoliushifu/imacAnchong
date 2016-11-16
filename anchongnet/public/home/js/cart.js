$(function () {
    var state=true;
    // console.log($('.select:checked').parent().siblings('.total-price').text());
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
        var id=$(this).attr('data-id');
        var that=$(this);
        if(state){
            state=false;
            setTimeout(function(){
                var num=that.prev().val();
                $.ajax({
                    url: '/cart/'+id+'/edit',
                    data:{goods_num:num},
                    type:'get',
                    success:function(result){
                        if(result){
                            that.prev().val(result);
                            that.parent().next().text("￥"+Number(that.parent().prev().text().replace('￥',''))*Number(result));
                            totalcheck();
                        }
                    }
                });
                    state=true;
            },1000);

        }
    });
    //减少购物车数量的按钮
    $('.minus').click(function(){
        var id=$(this).attr('data-id');
        var that=$(this);
        if(state){
            state=false;
            setTimeout(function(){
                var num=that.next().val();
                $.ajax({
                    url: '/cart/'+id+'/edit',
                    data:{goods_num:num},
                    type:'get',
                    success:function(result){
                        if(result){
                            that.next().val(result);
                            that.parent().next().text("￥"+Number(that.parent().prev().text().replace('￥',''))*Number(result));
                            totalcheck();
                        }
                    }
                });
                    state=true;
            },1000);
        }
    });
    $(".count").blur(function(){

        var id=$(this).prev().attr('data-id');
        var that=$(this);
        if(state){
            state=false;
            setTimeout(function(){
                var num=that.val();
                $.ajax({
                    url: '/cart/'+id+'/edit',
                    data:{goods_num:num},
                    type:'get',
                    success:function(result){
                        if(result){
                            that.val(result);
                            that.parent().next().text("￥"+Number(that.parent().prev().text().replace('￥',''))*Number(result));
                            totalcheck();
                        }
                    }
                });
                    state=true;
            },1000);
        }
    });
});
