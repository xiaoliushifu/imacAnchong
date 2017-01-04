/**
 * Created by
 */
$(function(){
    //数据保存
    $("body").on("click",'.savebeans',function(){
        var signin_id=$(this).attr('data-id');
        //找出所有上级td的所有DOM对象
        var tds=$(this).parent().siblings();
        var beans=tds.find(".beans").val();
        //进行ajax修改
        $.ajax({
            url: '/signin/'+signin_id,
            data:{beans:beans},
            type:'PUT',
            success:function(result){
                alert(result);
                location.reload();
            }
        });
    });
});
