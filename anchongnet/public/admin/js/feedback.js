/**
 * Created by lengxue on 2016/6/6.
 */
$(function(){
    //异步编辑发布
    $(".view").click(function(){
        //获取ID
        var id=$(this).attr("data-id");
        var title=$(this).attr("data-title");
        var state=$(this).attr("data-state");
        var users_id=$(this).attr("data-uid");
        //先将编辑的div清空
        $("#imgcontent").empty();
        //赋值反馈标题
        $('#feedbacktitle').text(title);
        //赋值反馈内容
        $('#feedbackcontent').text($(this).attr("data-content"));
        //判断
        if(state == 1){
            //已查看，给用户反馈已查看的信息
            $.ajax({
                url: '/feedback/feedbackview',
                type:'POST',
                data:{feed_id:id,title:title,users_id:users_id},
                success:function(result){
                    alert(result);
                }
            });
        }
        //获取社区图片
        $.get("/feedback/imgshow/"+id,function(data,status){
            //判断是否有图片
            if(data[0]){
                //判断有多少图片
                for(var b=0;b < data.length;b++){
                    comtent='<td><div class="gallery text-center"><a target="_blank" href="'+data[b].img+'"><img src="'+data[b].img+'" style="height:100px;width:100px;" class="imgcontent'+b+'"></a></div></td>';
                    $("#imgcontent").append(comtent);
                }
            }
        })
    });

    //删除发布
    $(".del").click(function(){
        if(confirm("确定要删除吗？")){
            var id=$(this).attr("data-id");
            $.ajax({
                url: '/feedback/feedbackdel/'+id,
                type:'GET',
                success:function(result){
                    alert(result);
                    location.reload();
                }
            });
        }
    });

    //点击回复
    $(".comment").click(function(){
        var id=$(this).attr("data-id");
        $("#commentfeedid").val(id);
        $("#commentfeedusersid").val($(this).attr("data-uid"));
    });

    //已修复
    $(".success").click(function(){
        if(confirm("确定已经反馈给工程师了吗？")){
            var id=$(this).attr("data-id");
            $.ajax({
                url: '/feedback/feedbackedit/'+id,
                type:'POST',
                success:function(result){
                    alert(result);
                    location.reload();
                }
            });
        }
    });

});
