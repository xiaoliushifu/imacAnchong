$(function(){
	/**
	 * 启用与停用
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
			    			o.siblings('button:eq(0)').toggleClass('disabled');
						sta.text(o.text());
					}
					console.log(data);
				}
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
		$('#target').val(tr.children(':eq(3)').text());
		$('#beans').val(tr.children(':eq(8)').text());
		//类型处理
//		$('#type option[value="'+tr.children(':eq(3)').attr('value').trim()+'"]').attr('selected',true);
//		$('#type2').attr('placeholder',$('#type option[value="'+tr.children(':eq(3)').attr('value').trim()+'"]').attr('tit'));
		$('#myform').attr('action','/coupon/'+hid);
		
		//”编辑表单“的验证逻辑
		$("#myform").validate({
	 	   rules:{
	 	  		   beans:{
	 	  			   min:0,
	 	  		   },
	 	  		   cvalue:{
	 	  			   required:true,
	 	  			   digits:true,
	 	  		   }
	 	   },
	 	   //自定义错误提示
	 	   messages:{
		 		     beans:{
			   			min:'输入的值不能小于0！',
			   		 },
			   		cvalue:{
			   			required:'面额必须得填吧',
		 	  			digits:'面额必须得是整数吧',
		 	  		}
	 	   }
		});
		
	});
    
    /**
     * 删除
     */
    $("body").on("click",'.del',function(){
    		if(confirm('如果不想使用该优惠券，建议选择【停用】而不是删除')) {
    			if(confirm('你确定要删除吗?')){
				var o = $(this);
				var tr = o.parents('tr');
				$.ajax({
					url:"/coupon/404",
					data:{"xid":o.attr("data-id")},
					type:'DELETE',
					success:function(data,status){
						if(parseInt(data)){
							tr.remove();
							return;
						}
						console.log(data);
					}
				});
    			}
    		}
	});
	
})