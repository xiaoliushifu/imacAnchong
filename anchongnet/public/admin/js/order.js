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
    });
    $(".check").click(function(){
        $("#cbody").empty();
        var num=$(this).attr("data-num");
        var dl;
        var id=$(this).attr("data-id");
        $.get("/getsiblingsorder",{num:num},function(data,status){
            for(var i=0;i<data.length;i++){
                dl='<dl class="dl-horizontal"> <dt>订单编号</dt> <dd>'+data[i].order_num+'</dd> <dt>商品名称</dt> <dd>'+data[i].goods_name+'</dd> <dt>规格型号</dt> <dd>'+data[i].goods_type+'</dd> <dt>商品数量</dt> <dd>'+data[i].goods_num+'</dd> <dt>商品价格</dt> <dd>'+data[i].goods_price+'</dd></dl>';
                $("#cbody").append(dl);
            }
        });
        $("#pass").attr("data-id",id).attr("data-num",num);
        $("#fail").attr("data-id",id).attr("data-num",num);
    });
    $("#pass").click(function(){
        if(confirm("确定要审核通过吗？")){
            var id=$(this).attr("data-id");
            $.post('/checkorder',{'oid':id,'isPass':"yes"},function(data,status){
                alert(data);
                location.reload();
            })
        }
    });
    $("#fail").click(function(){
        if(confirm("确定审核不通过吗？")){
           var id=$(this).attr("data-id");
           $.post('/checkorder',{'oid':id,'isPass':"no"},function(data,status){
               alert(data);
               location.reload();
           })
        }
    });

    //发货操作
    $(".shipbtn").click(function(){
        var id=$(this).attr("data-id");
        var num=$(this).attr("data-num");
        $("#orderid").val(id);
        $("#ordernum").val(num);
    });
    $("#inlineRadio2").click(function(){
        $("#logs").empty();
        $.get("/getlogis",function(data,status){
            for(var i=0;i<data.length;i++){
                var opt='<option value='+data[i].name+'>'+data[i].name+'</option>';
                $("#logs").append(opt);
                $("#logistics").removeClass("hidden");
            }
        })
    });
    $("#inlineRadio1").click(function(){
        $("#logistics").addClass("hidden");
    });
    $("#go").click(function(){
        $("#goform").ajaxSubmit({
            type:'post',
            url:'/ordership',
            success:function(data){
                alert(data);
                location.reload();
            },
        });
    });
});