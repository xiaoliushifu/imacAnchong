$(document).ready(function() {
	/**
	 * 列表项的单击，展示与合并
	 */
    $('.inactive').click(function(){
        if($(this).siblings('ul').css('display')=='none'){
            $(this).siblings('ul').slideDown(100).children('li');
            if($(this).parents('li').siblings('li').children('ul').css('display')=='block'){
                $(this).parents('li').siblings('li').children('ul').slideUp(100);
            }
         //显示的时候，再点击则合上
        }else{
            $(this).siblings('ul').slideUp(100);
            $(this).siblings('ul').children('li').children('ul').slideUp(100);
        }
    })
    
    /**
     * 单项点击 内容展示
     */
    //$('.item').on('click',function(event){
    //		alert($(this).text());
    //		$.get('/pcenter/fbgc',{name:'aaa',age:20},function(data){
    //			//编写逻辑
    //		});
    //		//阻止默认动作
    //		event.preventDefault();
    //});
    
    /**
     * 其他方法
     */
    
});