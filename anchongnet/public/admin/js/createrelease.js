/**
 * Created by lengxue on 2016/6/7.
 */
$(function (){
    $("#add").click(function(){
        $("#myform").ajaxSubmit({
            type: 'post',
            success: function (data) {
                alert(data);
            }
        });
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

