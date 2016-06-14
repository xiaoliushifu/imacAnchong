/**
 * Created by lengxue on 2016/6/7.
 */
$(function (){
    $("#add").click(function(){
        $("#myform").ajaxSubmit({
            type: 'post',
            success: function (data) {
                alert(data);
            },
        });
    })
});