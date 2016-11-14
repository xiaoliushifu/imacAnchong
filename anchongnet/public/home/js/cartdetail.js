/*
购物车商品数量更改
 */
function Minus(obj) {
    var num = $(obj).parent('li').children('input').val();
    if(num > 1){
        num = parseInt(num);
        num = num - 1;
        $(obj).parent('li').children('input').val(num);
    }else{
        $(obj).parent('li').children('input').val(1);
    }

}

function Add(obj) {
    var num = $(obj).parent('li').children('input').val();
    num = parseInt(num);
    num = num + 1;
    $(obj).parent('li').children('input').val(num);
}
/*
数量更改后更新数据库
 */
