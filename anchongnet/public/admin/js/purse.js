/**
 * Created by
 */
$(function(){

    /*
    * 修改状态
    * */
    $(".withdraw").click(function(){
        if(confirm("确定已经给用户打款成功了吗？")){
            var id=$(this).attr("data-id");
            $.ajax({
                url: '/purse/'+id,
                type:'PUT',
                success:function(result){
                    alert(result);
                    location.reload();
                }
            });
        }
    });
    //提现详情查看
    $(".withdrawinfo").click(function(){
        var id=$(this).attr("data-users");
        $("#vremark").text($(this).attr("data-remark"));
        $("#vorder_num").text($(this).attr("data-order"));
        $("#vprice").text($(this).attr("data-price"));
        $("#vtime").text($(this).attr("data-time"));
        var paynum=$(this).attr("data-pay").split(":");
        //判断是否有提现人与电话
        if(paynum.length>1){
            $("#vname").text(paynum[0]);
            $("#vaccount").text(paynum[1]);
        }else{
            $("#vname").text("无");
            $("#vaccount").text("无");
        }
        $.ajax({
            url: '/purse/'+id,
            type:'GET',
            success:function(result){
                $("#vusers_id").text(result.phone);
                $("#vusable_money").text(result.usable_money);
            }
        });
    });

});
