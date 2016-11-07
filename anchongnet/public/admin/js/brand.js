/**
 * Created by lengxue on 2016/4/18.
 */
$(function(){
	/**
	 * 编辑品牌信息
	 */
    $(".act").click(function(){
        var id=parseInt($(this).attr("data-id"));
        $("#myform").attr("action","/goodbrand/"+id);
        $("#myform").find('input[name="brand_name"]').val($(this).parent().prev().prev().text());
    });
    /**
     * 禁用
     */
    $(".del").click(function(){
    		alert('暂无可用');
    });
});
