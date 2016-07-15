/**
 * Created by lengxue on 2016/6/7.
 */
$(function (){
	
	//为表单，绑定jquery插件，来应用js验证功能
    $('#myform').validate({
    		//绑定submit回调
    		submitHandler:function(){
    			//执行ajax提交
    			$("#myform").ajaxSubmit({
                type: 'post',
                success: function (data) {
                    if(data.ServerNo == 0){
                        alert(data.ResultData.Message);
                        location.reload();
                    }else{
                        alert(data.ResultData.Message);
                    }
                },
            })
            //阻止浏览器默认动作
            return false;
    		},
    		//编写验证规则，在真正执行ajax提交前验证
    		rules:{
    			tag:"required",
    			title:"required",
    			content:"required",
    		},
    		messages:{
    			tag:'标签得选一个吧？',
    			title:'标题得写吧？',
    			content:'写点东西吧',
    		}
    });

    /*上传图片*/
    $('#detail').diyUpload({
        url:'/releaseimg',
        success:function( data ) {
            console.info( data.message );
            var len=$("#img").find("li").length;
            var lis='<li> <input type="hidden" name="pic[]" value="'+data.url+'"> </li>';
            $("#img").append(lis);
        },
        error:function( err ) {
            console.info( err );
        }
    });
});
