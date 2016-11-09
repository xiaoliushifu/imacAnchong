/**
 * Created by
 */
$(function(){
    //数据保存
    $("body").on("click",'.savebeans',function(){
        var notice_id=$(this).attr('data-id');
        //找出所有上级td的所有DOM对象
        var tds=$(this).parent().siblings();
        var notice=tds.find(".notice").val();
        //进行ajax修改
        $.ajax({
            url: '/notice/'+notice_id,
            data:{notice:notice},
            type:'PUT',
            success:function(result){
                alert(result);
                location.reload();
            }
        });
    });
});
