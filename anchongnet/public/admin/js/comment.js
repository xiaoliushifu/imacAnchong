/**
 * Created by lengxue on 2016/6/7.
 */
$(function(){
    $(".reply").click(function(){
        var id=$(this).attr("data-id");
        var comname=$(this).attr("data-comname");
        $("#comid").val(id);
        $("#comname").val(comname);
    });

    $("#reply").click(function(){
        $("#replyform").ajaxSubmit({
            type: 'post',
            success: function (data) {
                alert(data);
                location.reload();
            },
        });
    });

    $(".del").click(function(){
        if(confirm("你确定要删除吗？")){
            var id=$(this).attr("data-id");
            var o=$(this);
            $.ajax({
                url: '/comment/'+id,
                type:'DELETE',
                success:function(res){
                    console.log(res)
                    if(res.indexOf('成功')!=-1){
                    		o.parents('tr').remove();
                    }
                }
            });
        }
    });
});
