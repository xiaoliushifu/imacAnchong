/**
 * Created by
 */
$(function(){

    //点击编辑按钮
    $(".edit").click(function(){
        $("#pro_gid").text($(this).attr('data-gid'));
		$("#pro_price").val($(this).attr('data-price'));
		$("#pro_num").text($(this).attr('data-num'));
        $("#pro_sort").val($(this).attr('data-sort'));
        $("#pg_id").val($(this).attr('data-id'));
    });

    //促销修改保存
	$("#save").click(function(){
        //获得ID
        var id=$("#pg_id").val();
        //进行ajax修改
		$("#promotionForm").ajaxSubmit({
            url:"/promotioninfo/"+id,
            type:"PUT",
			success: function (data) {
				alert(data);
				location.reload();
			}
		});
	});

    //删成条目
    $(".del").click(function(){
        if(confirm('确定要删除这个促销商品吗？')){
            //拿到ID
            var promotion_id=$(this).attr('data-id');
            //进行ajax删除
            $.ajax({
                url: '/promotioninfo/'+promotion_id,
                type:'DELETE',
                success:function(result){
                    alert(result);
                    location.reload();
                }
            });
        }
    });
});
