/**
 * Created by lengxue on 2016/4/24.
 */
$(function(){
    //当gallery模块点击的时候执行事件转移
    $("body").on("click",'.gallery',function(){
        $(this).siblings(".pic").click();
    });

    //建立一個可存取到該file的url
    function getObjectURL(file) {
        var url = null ;
        if (window.createObjectURL!=undefined) { // basic
            url = window.createObjectURL(file) ;
        } else if (window.URL!=undefined) { // mozilla(firefox)
            url = window.URL.createObjectURL(file) ;
        } else if (window.webkitURL!=undefined) { // webkit or chrome
            url = window.webkitURL.createObjectURL(file) ;
        }
        return url ;
    }


});
