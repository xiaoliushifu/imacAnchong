/**
 * Created by lengxue on 2016/4/19.
 */
$('#detail').diyUpload({
    url:'/img',
    formData:{
        imgtype:1
    },
    buttonText:'a',
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
