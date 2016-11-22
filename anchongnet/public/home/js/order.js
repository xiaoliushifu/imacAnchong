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
	//支付宝支付
	$(".alipay").click(function(){
		var id=$(this).attr("data-oid");
		var price=$(this).attr("data-price");
		var info=$(this).attr("data-info");
		$.ajax({
			url: "/pay/aliweborderpay",
			type:'POST',
			//添加csrf请求头
			beforeSend: function (xhr) {
				var token = $('[name="_token"]').val();
				if (token) {
					  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
				}
			},
			data:{order_id:id,totalFee:price,body:info},
			success:function( data ){
				if(data.ServerNo == 0){
					var url=data.ResultData.payurl+"?outTradeNo="+data.ResultData.outTradeNo+"&totalFee="+data.ResultData.totalFee+"&body="+data.ResultData.body+"&subject="+data.ResultData.subject;
                    location.href=url;
				}else{
					alert(data.ResultData.Message);
				}
			}
		});
	});

	//微信支付
	$(".wxpay").click(function(){
		var id=$(this).attr("data-oid");
		var price=$(this).attr("data-price");
		var info=$(this).attr("data-info");
		$.ajax({
			url: "/pay/wxweborderpay",
			type:'POST',
			//添加csrf请求头
			beforeSend: function (xhr) {
				var token = $('[name="_token"]').val();
				if (token) {
					  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
				}
			},
			data:{order_id:id,totalFee:price,body:info},
			success:function( data ){
				if(data.ServerNo == 0){
					var url=data.ResultData.payurl+"?outTradeNo="+data.ResultData.outTradeNo+"&totalFee="+data.ResultData.totalFee+"&body="+data.ResultData.body+"&subject="+data.ResultData.subject;
                    location.href=url;
				}else{
					alert(data.ResultData.Message);
				}
			}
		});
	});

	//确认收货
	$(".confirm").click(function(){
		if(confirm('确认或已收到了吗？')){
			var id=$(this).attr("data-oid");
			var order_num=$(this).attr("data-number");
			//进行ajax请求
			$.ajax({
				url: "/order/"+id,
				type:'PUT',
				//添加csrf请求头
				beforeSend: function (xhr) {
					var token = $('[name="_token"]').val();
					if (token) {
						  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
					}
				},
				data:{action:7,order_id:id,order_num:order_num},
				success:function( data ){
					if(data.ServerNo == 0){
						alert(data.ResultData.Message);
						location.reload();
					}else{
						alert(data.ResultData.Message);
					}
				}
			});
		}
	});

	//取消订单
	$(".cancelorder").click(function(){
		if(confirm('确认要取消订单吗？')){
			var id=$(this).attr("data-oid");
			var order_num=$(this).attr("data-number");
			//进行ajax请求
			$.ajax({
				url: "/order/"+id,
				type:'PUT',
				//添加csrf请求头
				beforeSend: function (xhr) {
					var token = $('[name="_token"]').val();
					if (token) {
						  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
					}
				},
				data:{action:6,order_id:id,order_num:order_num},
				success:function( data ){
					if(data.ServerNo == 0){
						alert(data.ResultData.Message);
						location.reload();
					}else{
						alert(data.ResultData.Message);
					}
				}
			});
		}
	});

	//申请退款
	$(".applyrefund").click(function(){
		if(confirm('确认要申请退款吗？')){
			var id=$(this).attr("data-oid");
			var order_num=$(this).attr("data-number");
			//进行ajax请求
			$.ajax({
				url: "/order/"+id,
				type:'PUT',
				//添加csrf请求头
				beforeSend: function (xhr) {
					var token = $('[name="_token"]').val();
					if (token) {
						  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
					}
				},
				data:{action:4,order_id:id,order_num:order_num},
				success:function( data ){
					if(data.ServerNo == 0){
						alert(data.ResultData.Message);
						location.reload();
					}else{
						alert(data.ResultData.Message);
					}
				}
			});
		}
	});

	//订单删除
	$(".delete").click(function(){
		if(confirm('确认要删除吗？')){
			var id=$(this).attr("data-oid");
			var order_num=$(this).attr("data-number");
			//进行ajax请求
			$.ajax({
				url: "/order/"+id,
				type:'PUT',
				//添加csrf请求头
				beforeSend: function (xhr) {
					var token = $('[name="_token"]').val();
					if (token) {
						  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
					}
				},
				data:{action:8,order_id:id,order_num:order_num},
				success:function( data ){
					if(data.ServerNo == 0){
						alert(data.ResultData.Message);
						location.reload();
					}else{
						alert(data.ResultData.Message);
					}
				}
			});
		}
	});

});
