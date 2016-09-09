
$(function(){

    //
    //$('.buslist').toggle(function(){
    //    $(this).next(".cart").hide();
    //},function(){
    //    $(this).next(".cart1").show();
    //},function(){
    //    $(this).next(".cart2").show();
    //})


    $('.buslist').on("click", function(e){
        $(".cart").show();

        $(document).one("click", function(){
            $(".cart").hide();
        });

        e.stopPropagation();
    });
    $(".cart").on("click", function(e){
        e.stopPropagation();
    });



    $('.buslist1').on("click", function(e){
        $(".cart1").show();

        $(document).one("click", function(){
            $(".cart1").hide();
        });

        e.stopPropagation();
    });
    $(".cart1").on("click", function(e){
        e.stopPropagation();
    });

    $('.buslist2').on("click", function(e){
        $(".cart2").show();

        $(document).one("click", function(){
            $(".cart2").hide();
        });

        e.stopPropagation();
    });
    $(".cart2").on("click", function(e){
        e.stopPropagation();
    });







})



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