$(function(){
	$('.userinfo').click(function(){
		$('.cart').toggle();
	});
	var list = $('.navigation li');
	for (var i = 0; i<list.length; i++) {
		nav(i);
	}
	function nav(i){
		$('.navigation li').eq(i).mousemove(function(){
			$('.navigation li').eq(i).css('background-color','#1DABD8');
		});
		$('.navigation li').eq(i).mousemove(function(){
			$('.navigation li a').eq(i).css('color','#FFFFFF');
		});
		$('.navigation li').eq(i).mouseout(function(){
			$('.navigation li a').eq(i).css('color','#606060');
		});
		$('.navigation li').eq(i).mouseout(function(){
			$('.navigation li').eq(i).css('background-color','');
		});
	}
});
