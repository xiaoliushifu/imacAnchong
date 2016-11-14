/**
 * Created by lengxue on 2016/6/8.
 */
$(function(){
    //后台强制关闭直播
    $(".closes").click(function(){
        if(confirm("确定要强制关闭该直播吗")){
            var id=$(this).attr("data-id");
            var users_id=$(this).attr("data-usersid");
            $.ajax({
                url: "/live/"+id,
                type:'PUT',
                data:{type:'close',users_id:users_id},
                success:function( response ){
                    alert(response);
                }
            });
        }
    });
    //后台再次启用直播
    $(".open").click(function(){
        if(confirm("确定要开启该直播吗")){
            var id=$(this).attr("data-id");
            var users_id=$(this).attr("data-usersid");
            $.ajax({
                url: "/live/"+id,
                type:'PUT',
                data:{type:'open',users_id:users_id},
                success:function( response ){
                    alert(response);
                }
            });
        }
    });

    //后台顶置直播
    $(".recommend").click(function(){
        if(confirm("确定要顶置该直播吗")){
            var id=$(this).attr("data-id");
            $.ajax({
                url: "/live/"+id,
                type:'PUT',
                data:{type:'recommend'},
                success:function( response ){
                    alert(response);
                }
            });
        }
    });

    //后台取消顶置直播
    $(".cancel").click(function(){
        if(confirm("确定要取消顶置吗")){
            var id=$(this).attr("data-id");
            $.ajax({
                url: "/live/"+id,
                type:'PUT',
                data:{type:'cancel'},
                success:function( response ){
                    alert(response);
                }
            });
        }
    });

});
