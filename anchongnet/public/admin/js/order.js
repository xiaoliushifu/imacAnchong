/**
 * Created by lengxue on 2016/4/27.
 */
$(function(){
    $(".view").click(function(){
        $("#mbody").empty();
        var num=$(this).attr("data-num");
        var dl;
        $.get("/getsiblingsorder",{num:num},function(data,status){
            for(var i=0;i<data.length;i++){
                dl='<dl class="dl-horizontal"> <dt>订单编号</dt> <dd>'+data[i].order_num+'</dd> <dt>商品名称</dt> <dd>'+data[i].goods_name+'</dd> <dt>规格型号</dt> <dd>'+data[i].goods_type+'</dd> <dt>商品数量</dt> <dd>'+data[i].goods_num+'</dd> <dt>商品价格</dt> <dd>'+data[i].goods_price+'</dd></dl><hr>';
                $("#mbody").append(dl);
            }
        })
    })
    $(".send").click(function(){
        if(confirm("确定要发货吗？")){
            var id=$(this).attr("data-id");
            $.ajax({
                url: '/order/'+id,
                type:'PUT',
                data:{iSend:true,status:3},
                success:function( response ){
                    alert(response);
                    location.reload();
                }
            });
        }
    })
});