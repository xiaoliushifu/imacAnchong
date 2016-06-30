/**
 * Created by lengxue on 2016/6/6.
 */
$(function(){
    //异步编辑发布
    $(".edit").click(function(){
        var id=$(this).attr("data-id");
        $("#updateform").attr("action","/advert/inforupdate");
        $.get("/advert/firstinfor/"+id,function(data,status){
            $("#infor_id").val(data[0].infor_id);
            $("#title").val(data[0].title);
            $("#updateimg").attr("src",data[0].img);
            $("#newsimg").val(data[0].img);
            UE.getEditor('content').setContent(data[0].content);
        })
    });
    //异步图片
    $("#newspic").change(function(){
        $("#formToUpdateimg").ajaxSubmit({
            type: 'POST',
            url: '/img',
            data:{imgtype:4},
            success: function (data) {
                alert(data.message);
                if(data.isSuccess==true){
                    $("#updateimg").attr("src", data.url);
                    $("#newsimg").val(data.url);
                }
            }
        });
    });
    //修改保存
    $("#save").click(function(){
        $("#updateform").ajaxSubmit({
            type: 'POST',
            url: '/advert/inforupdate',
            success: function (data) {
                alert(data.message);
                location.reload();
            },
        });
    });
    //点击删除
    $(".del").click(function(){
        //资讯ID
        infor_id=$(this).attr("data_id");
        if(confirm('确认要删除吗？')){
            $.ajax({
                url: "/advert/infordel/"+infor_id,
                type:'get',
                success:function( response ){
                    if(response.ServerNo == 0){
                        alert('删除成功');
                        location.reload();
                    }else{
                        alert('删除失败');
                    }
                }
            });
    	}
    });
});
