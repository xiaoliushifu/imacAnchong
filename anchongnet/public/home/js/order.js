$(function(){
	var msg=$('.my-info-list li');
		for(var t = 0; t< msg.length; t++){
		msge(t);
	}
	function msge(t){
		$('.my-info-list li').eq(t).click(function(){
				$(".my-info-list div").eq(t).toggle();
		});
	}
	$(".userinfo").click(function(){
		$(".cart").toggle();
	});
	var info = $(".information-nav li");
	for(var i = 0; i < info.length; i++ ){
		infor(i);
	}
	function infor(i){
		$(".information-nav li").eq(i).mousemove(function(){
			$(".information-nav li a").eq(i).css({
					"color":"#1dabd8","font-size":"20px","font-weight":"blod"
				})
		});
		$(".information-nav li").eq(i).mouseout(function(){
			$(".information-nav li a").eq(i).css({
					"font-size":"18px","color":"#4a4a4a"
				})
		});
	}
});
