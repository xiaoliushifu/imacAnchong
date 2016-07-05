/**
 * Created by lengxue on 2016/4/27.
 */
$(function(){
    $(".view").click(function(){
         $(".orderinfos").empty();
         //为了打印让后面页面隐藏
         $("#pageindex").attr("class","hidden");
         $('.main-footer').attr("class","hidden");
        var num=$(this).attr("data-num");
        //价格
        var price=$(this).attr("data-price");
        //运费
        var freight=$(this).attr("data-freight");
        //总价
        var total_price=Number(freight)+Number(price);
        //订单货品详情html
        var dl;
        //运费总价htm
        var al;
        $("#ordertime").text($(this).attr("data-time"));
        $("#ordernum").text($(this).attr("data-num"));
        $("#ordersname").text($(this).attr("data-sname"));
        $("#ordername").text($(this).attr("data-name"));
        $("#orderphone").text($(this).attr("data-phone"));
        $("#orderaddress").text($(this).attr("data-address"));
        if($(this).attr("data-invoice")){
            $('#orderinvoice').text($(this).attr("data-invoice"));
        }
        $.get("/getsiblingsorder",{num:num},function(data,status){
            for(var i=0;i<data.length;i++){
                dl='<tr class="orderinfos"><td align="center" valign="middle">'+data[i].goods_name+'</td><td align="center" valign="middle">'+data[i].goods_num+'</td><td align="center" valign="middle">'+data[i].goods_price+'</td></tr>';
                $("#mbody").append(dl);
            }
            al='<tr class="orderinfos"><td align="center" valign="middle"></td><td align="center" valign="middle">运费：</td><td align="center" valign="middle">'+freight+'</td></tr><tr class="orderinfos"><td align="center" valign="middle"></td><td align="center" valign="middle">总价：</td><td align="center" valign="middle">'+total_price+'</td></tr>';
            $("#mbody").append(al);
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
    $("#viewclose").click(function(){
        location.reload();
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
