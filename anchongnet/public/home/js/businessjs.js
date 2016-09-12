
$(function(){

//商机主页导航下拉
    $('.buslist').click(function(){
        $('.cart').toggle();
    });

    $('.buslist1').click(function(){
        $('.cart1').toggle();
    });
    $('.buslist2').click(function(){
        $('.cart2').toggle();
    });

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