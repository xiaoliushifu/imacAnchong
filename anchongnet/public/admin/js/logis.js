/**
 * Created by lengxue on 2016/5/19.
 */
$(function(){
	
	/**
	 * 编辑物流
	 */
//    $(".edit").click(function(){
//        var id=$(this).attr("data-id");
//        //确定 保存物流时 提交的url
//        $("#updateform").attr("action","/logis/"+id);
//        $.get("/logis/"+id,function(data,status){
//            $("#name").val(data.name);
//        })
//    });
    /**
     * 绑定表单提交事件
     */ 
//    $('#updateform').submit(function() {
//        var options = {
//            type:"POST",//请求方式：get或post
//            dataType:"json",//数据返回类型：xml、json、script
//            success:function(data){//表单提交成功回调函数
//                alert(data.mes);
//                location.reload();
//            },
//            error:function(err){
//                var str=err.responseText
//                var obj=JSON.parse(str);
//                alert(obj.name);
//            }
//        };
//        $(this).ajaxSubmit(options);
//
//        // 为了防止普通浏览器进行表单提交和产生页面导航（防止页面刷新？）返回false
//        return false;
//    });
    
    /**
     * 删除物流
     */
//    $(".del").click(function(){
//        if(confirm("您确定要删除该条记录吗？")){
//            var id=$(this).attr("data-id");
//            $.ajax({
//                url: "/logis/" + id,
//                type: 'DELETE',
//                success: function (result) {
//                    alert(result);
//                    location.reload();
//                }
//            });
//        }
//    });
});