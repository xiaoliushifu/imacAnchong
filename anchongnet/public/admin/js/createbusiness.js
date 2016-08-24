/**
 * Created by lengxue on 2016/6/9.
 */
$(function(){
    /**
     *  获得所有商机标签
     */
    $.get('/getag',function(data,status){
        var opt;
        for(var i=0;i<data.length;i++){
            opt='<option value='+data[i].tag+'>'+data[i].tag+'</option>';
            $("#tag").append(opt);
        }
    });
});

/*商品图片添加*/
$('#detail').diyUpload({
    url:'/businessimg',
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