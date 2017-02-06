/**
 * Created by somebody
 */
$(function(){
	
	//券类型 change事件
	$('body').on('change','#shop',function(){
		if ($('#shop').val() == 0 ) {
			$('#type2').val('通用');
			$('#type2').attr('readonly',true);
			$('#type').val('1');
			$('#type').attr('readonly',false);
		}
		return;
	});
	//子类型
	$('body').on('change','#type',function(){
		//类型处理
		$('#type2').attr('placeholder',$(this).find('option:selected').attr('tit'));
		if ($('#type').val()==1) {
			$('#type2').attr('readonly',true);
		} else {
			$('#type2').attr('readonly',false);
		}
		//获得该商铺的其他信息，如商品，品牌等组成列表供录入者筛选
	});
	
	//表单验证逻辑
	$("#myform").validate({
 	   //绑定规则
 	   rules:{
 	  		   type:{
 	  			   range:[0,14],
 	  		   },
 	  		   cvalue:{
 	  			   required:true,
 	  			   digits:true,
 	  		   },
 	  		   endline:{
 	  			   required:true,
 	  			   dateISO:true,
 	  		   },
 	  		   target:{
 	  			   required:true,
 	  		   }
 	   },
 	   //自定义错误提示
 	   messages:{
	 		     type:{
		   			range:'必须在0-14之间哟！',
		   		 },
		   		cvalue:{
		   			required:'面额必须得填吧',
	 	  			digits:'面额必须得是整数吧',
	 	  		},
	 	  		endline:{
	 	  			dateISO:'日期格式不行 xxxx-xx-xx',
	 	  		},
	 	  		target:{
	 	  			required:'必须填啊!',
	 	  		}
 	   }
	});
	
});
