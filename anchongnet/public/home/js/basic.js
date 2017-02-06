$(function(){
	
	/*商品图片添加*/
	$('#detail').diyUpload({
	    url:'/pcenter/upload',
	    success:function( data ) {
	        console.info( data.message );
	        var len=$("#img").find("li").length;
	        var lis='<li> <input type="hidden" name="pic[]" value="'+data.url+'"> </li>';
	        $("#img").append(lis);
	    },
	    error:function( err ) {
	        console.info( err );
	    },
	});
});