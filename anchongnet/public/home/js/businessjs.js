$(function(){

//商机主页导航下拉
    $('.buslist').click(function(){


        $('.cart2').slideUp();
    });



    $('.buslist2').click(function(){
        $('.cart').slideUp();
    });
    $(".buslist").on("click", function(e){
        if($(".cart").is(":hidden")){
            $(".cart").slideDown();
        }else{
            $(".cart").slideUp();
        }

        $(document).one("click", function(){
            $(".cart").slideUp();
        });

        e.stopPropagation();
    });
    $(".cart").on("click", function(e){
        e.stopPropagation();
    });
    $(".buslist2").on("click", function(e){
        if($(".cart2").is(":hidden")){
            $(".cart2").slideDown();
        }else{
            $(".cart2").slideUp();
        }

        $(document).one("click", function(){
            $(".cart2").slideUp();
        });

        e.stopPropagation();
    });
    $(".cart2").on("click", function(e){
        e.stopPropagation();
    });


    //$(document).ready(function(){
    //    $(".buslist").click(function(){
    //        $("#change").css("background","#1DABD8");
    //        $("#change1").css("background","none");
    //
    //        $("#change2").css("background","none");
    //    });
    //    $(".buslist1").click(function(){
    //        $("#change").css("background","none");
    //        $("#change1").css("background","#1DABD8");
    //        $("#change2").css("background","none");
    //    });
    //    $(".buslist2").click(function(){
    //        $("#change1").css("background","none");
    //        $("#change2").css("background","#1DABD8");
    //        $("#change").css("background","none");
    //    });
    //
    //});






})

//商机主页轮播

$(function(){
    var timer=setInterval(function(){
        if($(".banner li:last").is(":hidden")){
            $(".banner li:visible").addClass("on");
            $(".banner li[class=on]").next().fadeIn("slow");
            $(".banner li[class=on]").hide().removeClass("on");
        }else{
            $(".banner li:last").hide();
            $(".banner li:first").fadeIn("slow");
        }
    },2000)

    $(".banner li").hover(function(){
        clearInterval(timer);
    },function(){
        timer=setInterval(function(){
            if($(".banner li:last").is(":hidden")){
                $(".banner li:visible").addClass("on");
                $(".banner li[class=on]").next().fadeIn("slow");
                $(".banner li[class=on]").hide().removeClass("on");
            }else{
                $(".banner li:last").hide();
                $(".banner li:first").fadeIn("slow");
            }
        },5000)
    })
});
























