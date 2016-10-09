/**
 * Created by lengxue on 2016/4/19.
 */
$(function(){
    var defaultopt="<option value='0'>无</option>";
    $("#par0").append(defaultopt);
    var opt;
    var one0=0;
    //这就决定了，目前只能添加一，二级分类
    $.get("/getlevel",{pid:one0},function(data,status){
        for(var i=0;i<data.length;i++){
            opt="<option  value="+data[i].cat_id+">"+data[i].cat_name+"</option>";
            $("#par0").append(opt);
        }
    });
    
    //文本框失去焦点后
    $('form :input').blur(function(){
         var $parent = $(this).parent();
         $parent.find(".text-danger").remove();
         //分类名称
         if ($(this).is('#catname') ){
                if ($(this).val().length < 2 ){
                    var errorMsg = '分类名称必须填写.';
                    $parent.append('<span class="text-danger onError">'+errorMsg+'</span>');
                }
         }
         if ($(this).is('#description') ){
	        	 if ($(this).val().length < 6 ) {
	        		 var errorMsg = '分类描述必须填写.';
	        		 $parent.append('<span class="text-danger onError">'+errorMsg+'</span>');
	        	 }
         }
    });
    
});