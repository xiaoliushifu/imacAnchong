/**
 * Created by lengxue on 2016/6/6.
 */
$(function(){
    //异步编辑发布
    $(".edit").click(function(){
        var id=$(this).attr("data-id");
        $("#updateform").attr("action","/release/"+id);
        $.get("/release/"+id+"/edit",function(data,status){
            $("#title").val(data.title);
            UE.getEditor('content').setContent(data.content);
        })
    });
    $("#save").click(function(){
        $("#updateform").ajaxSubmit({
            type: 'put',
            success: function (data) {
                alert(data);
                location.reload();
            },
        });
    });

    //删除发布
    $(".del").click(function(){
        if(confirm("确定要删除吗？")){
            var id=$(this).attr("data-id");
            $.ajax({
                url: '/release/'+id,
                type:'DELETE',
                success:function(result){
                    alert(result);
                    location.reload();
                }
            });
        }
    });
});