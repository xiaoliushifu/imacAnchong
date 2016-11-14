$(function(){
    $("#ss").on("click", function(e){
        if($("#hh").is(":hidden")){
            $("#hh").slideDown();
        }else{
            $("#hh").slideUp();
        }

        $(document).one("click", function(){
            $("#hh").slideUp();
        });

        e.stopPropagation();
    });
    $("#hh").on("click", function(e){
        e.stopPropagation();
    });
})
