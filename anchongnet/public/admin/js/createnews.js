/**
 * Created by lengxue on 2016/4/26.
 */
$(function(){
    $("body").on("click",'.delcuspro',function(){
        var len=$(".line").length;
        if(len>1){
            $(this).parents(".line").remove();
        }
    });
});

/*商品图片添加*/
$('#detail').diyUpload({
    url:'/img',
    formData:{
        imgtype:1
    },
    success:function( data ) {
        console.info( data.message );
        var len=$("#img").find("li").length;
        var lis='<li> <input type="hidden" name="pic['+len+'][url]" value="'+data.url+'"> <input type="hidden" name="pic['+len+'][imgtype]" value="1"> </li>';
        $("#img").append(lis);
    },
    error:function( err ) {
        console.info( err );
    },
});
