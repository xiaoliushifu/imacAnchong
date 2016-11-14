$(function(){
    $("#submit").click(function(){
        $(this).attr("disabled",true);
        $(this).attr("value","请稍后");
        $(this).css("background-color","gray");
        //执行ajax提交
        $("#myform").ajaxSubmit({
            type:'post',
            success: function (data) {
                if(data.ServerNo == 0){
                    var url=data.ResultData.payurl+"?outTradeNo="+data.ResultData.outTradeNo+"&totalFee="+data.ResultData.totalFee+"&body="+data.ResultData.body+"&subject="+data.ResultData.subject;
                    location.href=url;
                }else{
                    alert(data.ResultData.Message);
                }
            }
        });
    });
});
