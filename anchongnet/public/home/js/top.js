$(function(){
	//top头像点击
    $("#ss").on("click", function(e){
        if($("#hh").is(":hidden")){
            $("#hh").slideDown();
        }else{
            $("#hh").slideUp();
        }
        e.stopPropagation();
    });
    
})
