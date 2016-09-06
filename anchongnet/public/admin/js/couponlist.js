$(function(){
	/**
	 * 启用
	 */
    $("body").on("click",'.act',function(){
    		//判断点击类型
    		var o = $(this);
    		var carr = this.getAttribute('class').split(/\s+/);
    		var sta = o.parent().prev();
		$.ajax({
				url:"/coupon/404",
				data:{"xid":o.attr("data-id"),"act":carr[0]},
				type:'PATCH',
				success:function(data,status){
					if (data) {
						o.toggleClass('disabled');
			    			o.siblings('button').toggleClass('disabled');
						sta.text(o.text());
					}
					console.log(data);
				},
		});
	})
	
	/**
	 * 编辑
	 */
	$("body").on("click",'.edit',function(){
		var o = $(this);
		
		var tr = o.parents('tr');
		var hid = tr.children(':first').text();
		$('#hid').val(hid);
		$('#title').val(tr.children(':eq(1)').text());
		$('#cvalue').val(tr.children(':eq(2)').text());
		$('#beans').val(tr.children(':eq(5)').text());
		//类型处理
		$('#type option[value="'+tr.children(':eq(3)').attr('value').trim()+'"]').attr('selected',true);
		$('#type2').attr('placeholder',$('#type option[value="'+tr.children(':eq(3)').attr('value').trim()+'"]').attr('tit'));
		$('#myform').attr('action','/coupon/'+hid);
		
		
		
		//编辑页面，列表change事件
//		$('body').on('change','#type',function(){
//			//类型处理
//			$('#type2').attr('placeholder',$(this).find('option:selected').attr('tit'));
//		});
		
	});
	
})