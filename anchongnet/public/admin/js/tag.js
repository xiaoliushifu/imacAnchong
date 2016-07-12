/**
 * Created by lengxue on 2016/5/6.
 */
$(function(){

    /*
    * 删除标签
    * */
    $(".del").click(function(){
        if(confirm("确定要删除该条标签吗？")){
            var id=$(this).attr("data-id");
            $.ajax({
                url: '/tag/'+id,
                type:'DELETE',
                success:function(result){
                    // Do something with the result
                    alert(result);
                    location.reload();
                }
            });
        }
    });
});
