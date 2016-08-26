/**
 * Created by lengxue on 2016/5/6.
 */
$(function(){

    /*
    * 删除标签
    * */
    $(".del").click(function(){
        if(confirm("确定要删除该条标签吗？")){
        		var o = $(this);
            var id=o.attr("data-id");
            $.ajax({
                url: '/tag/'+id,
                type:'DELETE',
                //delete方法也能传参
                data:'type='+o.attr("data-type"),
                success:function(result){
                    alert(result);
                    //needn't refresh
                    o.parents('tr').remove();
                }
            });
        }
    });
});
