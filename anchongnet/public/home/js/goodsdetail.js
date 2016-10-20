$(function(){
//详情。参数。相关
    $(document).ready(function(){
        $(".param").click(function(){
            $("#param").show();
            $("#package").hide();
            $("#mainpic").hide();
        });
        $(".mainpic").click(function(){
            $("#mainpic").show();
            $("#package").hide();
            $("#param").hide();
        });
        $(".package").click(function(){
            $("#package").show();
            $("#mainpic").hide();
            $("#param").hide();
        });
    });

    $('.suit ul li').click(function () {
        $(this).attr('id','t-selected').siblings('li').removeAttr('id');
        $(this).css({'color':'#f53745','border':'1px solid #f53745'}).siblings('li').css({'color':'#4a4a4a','border':'1px solid #606060'});
    });
    $('.sizetype ul li').click(function () {
        $(this).attr('id','m-selected').siblings('li').removeAttr('id');
        $(this).css({'color':'#f53745','border':'1px solid #f53745'}).siblings('li').css({'color':'#4a4a4a','border':'1px solid #606060'});
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