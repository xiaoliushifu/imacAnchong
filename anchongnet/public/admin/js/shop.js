/**
 * Created by lengxue on 2016/5/16.
 */
$(function(){
    //查看详情
    $(".view").click(function(){
        var id=$(this).attr("data-id");
        var dl;
        var dd;
        $("#brands").empty();
        $("#cat").siblings().remove();
        $.get('/getbrand',{'sid':id},function(data,status){
            for(var i=0;i<data.length;i++){
                dl='<hr><dl class="dl-horizontal"> <dt>主营品牌：</dt> <dd>'+data[i].brand_name+'</dd> </dl> <dl class="dl-horizontal"> <dt>品牌授权书：</dt> <dd><a href='+data[i].authorization+' target="_blank"><img src='+data[i].authorization+' width="100"></a></dd> </dl>';
                $("#brands").append(dl);
            }
        });
        $.get('/getcat',{'sid':id},function(data,status){
            for(var i=0;i<data.length;i++){
                dd='<dd>'+data[i].cat_name+'</dd>';
                $("#cat").after(dd);
            }
        })
    });

    /*----审核通过----*/
    $("body").on("click",'.check-success',function(){
        if(confirm('确定要通过吗？')){
            var id=parseInt($(this).attr("data-id"));
            $.get("/checkShop",{"sid":id,"certified":"yes"},function(data,status){
                alert(data);
                setTimeout(function(){location.reload()},1000);
            });
        }
    });

    /*----审核不通过----*/
    $("body").on("click",'.check-failed',function(){
        if(confirm('确定审核不通过吗？')){
            var id=parseInt($(this).attr("data-id"));
            $.get("/checkShop",{"sid":id,"certified":"no"},function(data,status){
                alert(data);
                setTimeout(function(){location.reload()},1000);
            });
        }
    })
});