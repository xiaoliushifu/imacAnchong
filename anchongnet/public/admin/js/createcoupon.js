/**
 * Created by somebody
 */
$(function(){
	
	//优惠券类型 change事件
	$('body').on('change','#type',function(){
		//类型处理
		$('#type2').attr('placeholder',$(this).find('option:selected').attr('tit'));
		if ($('#type').val()==1) {
			$('#type2').attr('readonly',true);
		} else {
			$('#type2').attr('readonly',false);
		}
	});
	
	//表单验证逻辑
	$("#myform").validate({
 	   //绑定规则
 	   rules:{
 	  		   type:{
 	  			   range:[0,14],
 	  		   },
 	  		   title:{
 	  			   required:true,
 	  			   minlength:5,
 	  		   },
 	  		   cvalue:{
 	  			   required:true,
 	  			   digits:true,
 	  		   }
 	   },
 	   //自定义错误提示
 	   messages:{
	 		     type:{
		   			range:'必须在0-14之间哟！',
		   		 },
 		   		title:{
		   			required:'标题怎么能不填写呢! ',
		   			minlength:'标题写得也太少了吧',
		   		},
		   		cvalue:{
		   			required:'面额必须得填吧',
	 	  			digits:'面额必须得是整数吧',
	 	  		}
 	   }
	});
	
});
