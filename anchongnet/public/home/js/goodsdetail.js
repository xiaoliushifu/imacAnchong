$(function(){
		//规格参数
        $(".param").click(function(){
            $("#param").show();
            $("#package").hide();
            $("#mainpic").hide();
        });
        //商品详情
        $(".mainpic").click(function(){
            $("#mainpic").show();
            $("#package").hide();
            $("#param").hide();
        });
        //相关资料
        $(".package").click(function(){
            $("#package").show();
            $("#mainpic").hide();
            $("#param").hide();
        });
    //属性1的选中
    $('.suit ul nobr').click(function () {
    		//选中当前，排除其他
        $(this).find('li').attr('id','t-selected').css({'color':'#f53745','border':'1px solid #f53745'}).parent().siblings().find('li').removeAttr('id').css({'color':'#4a4a4a','border':'1px solid #606060'});
    });
    //属性2选中
    $('.sizetype ul li').click(function () {
        $(this).attr('id','m-selected').siblings('li').removeAttr('id');
        $(this).css({'color':'#f53745','border':'1px solid #f53745'}).siblings('li').css({'color':'#4a4a4a','border':'1px solid #606060'});
    });
    
    $('.oem').click(function () {
        $(this).attr('id','oem').siblings('li').removeAttr('id');
        $(this).css({'color':'#f53745','border':'1px solid #f53745'}).siblings('li').css({'color':'#4a4a4a','border':'1px solid #606060'});
    })
    
    /*
    点击切换图片
   */
      $('.thumb img').click(function(){
          $("#tail").attr("src",$(this).attr('src'));
      });
});
/*
选择商品数量
 */
//数量减少1
function Minus() {
    var num = $('#goodsnum').val();
    if(num > 1 ){
        num = parseInt(num);
        num = num - 1;
        $('#goodsnum').val(num);
    }else{
        $('#goodsnum').val('1');
    }
}
//数量增加1
function Add() {
    var num = $('#goodsnum').val();
    num = parseInt(num);
    num = num + 1;
    $('#goodsnum').val(num);
}
function Buy() {
    console.log('No Supported');
}
