$(function(){
//详情。参数。相关
    $(document).ready(function(){
        $(".param").click(function(){
            $("#param").show();
            $("#package").hide();
            $("#mainpic").hide();
        });
        $(".mainpic").click(function(){
            $("#mainpic").show();
            $("#package").hide();
            $("#param").hide();
        });
        $(".package").click(function(){
            $("#package").show();
            $("#mainpic").hide();
            $("#param").hide();
        });
    });





});