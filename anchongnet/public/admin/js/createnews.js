/**
 * Created by lengxue on 2016/4/26.
 */
$(function(){
	
	/*商品图片添加，Jquery多图片上传插件*/
	$('#detail').diyUpload({
	    url:'/img',
	    formData:{
	        imgtype:1
	    },
	    fileNumLimit:1,//只允许同时上传一个，但可多次上传达到上传多张目的
	    success:function( data ) {
	        console.info( data.message );
	        var len=$("#img").find("li").length;
	        if (len == 1) {
	        		alert('只上传一张图片即可');
	        		return;
	        }
	        var lis='<li> <input type="hidden" name="pic['+len+'][url]" value="'+data.url+'"> <input type="hidden" name="pic['+len+'][imgtype]" value="1"> </li>';
	        $("#img").append(lis);
	    },
	    error:function( err ) {
	        console.info( err );
	    },
	});
	
	/**
	 * 表单验证
	 */
	//图片必须上传
	$('body').on('submit','form',function(){
		//已经上传图片的数量
		var len=$("#img").find("li").length;
		if (len < 1) {
			$('small:eq(0)').removeClass('hidden');
			return false;
		}
		//详情必填,ue在视图中由 UE.getEditor得出。
		if(!ue.hasContents()){
			$('small:eq(1)').removeClass('hidden');
			return false;
		}
	});

});

