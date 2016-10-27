/**
 * Created by lengxue on 2016/6/8.
 */
$(function(){
    //后台强制关闭直播
    $(".closes").click(function(){
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

    });
    //后台再次启用直播
    $(".open").click(function(){
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

    });
});
