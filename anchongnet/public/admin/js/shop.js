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
    });

    //进行商铺的关闭
    $(".shopclose").click(function(){
        //提示用户
        if(confirm('确定要关闭此店铺吗?')){
            //获取商铺ID
            var sid=$(this).attr("data-id");
            //ajax调用接口
            $.post('/shop/shopstate',{'sid':sid,state:4},function(data,status){
                alert(data);
                location.reload();
            });
        }
    });

    //进行商铺的开启
    $(".shopopen").click(function(){
        //提示用户
        if(confirm('确定要开启此店铺吗?')){
            //获取商铺ID
            var sid=$(this).attr("data-id");
            //ajax调用接口
            $.post('/shop/shopstate',{'sid':sid,state:2},function(data,status){
                alert(data);
                location.reload();
            });
        }
    });
    
    /**---进入广告管理页面--**/
    $(".advert").click(function(){
        $("#advert-shopsname").text($(this).attr("data-name"));
        $("#advert-sid").val($(this).attr("data-id"));
    });
    
    //该图片修改模块的表单与图片还有文件inpu的命名根据数据库广告表的id进行设置
    //商城轮播图
    $(".newgoodspic31").change(function(){
        //获取轮播图类型
        var goods_id="shop";
        //获得轮播图所绑定的商铺
        var gid=$("#advert-sid").attr("value");
        $("#formToUpdate31").ajaxSubmit({
            type: 'post',
            url: '/advert/addpic',
            //传递数据adid为该广告在广告表的id,
            data:{adid:5,goods_id:goods_id,gid:gid},
            //假如返回成功则执行函数
            success: function (data) {
                alert('商城轮播图1'+data.message);
                if(data.isSuccess==true){
                    $(".img31").attr("src", data.url);
                }
            }
        });
    });
    //第二张图
    $(".newgoodspic32").change(function(){
        var goods_id="shop";
        var gid=$("#advert-sid").attr("value");
        $("#formToUpdate32").ajaxSubmit({
            type: 'post',
            url: '/advert/addpic',
            data:{adid:6,goods_id:goods_id,gid:gid},
            success: function (data) {
                alert('商城轮播图2'+data.message);
                if(data.isSuccess==true){
                    $(".img32").attr("src", data.url);
                }
            }
        });
    });
    $(".newgoodspic33").change(function(){
        var goods_id="shop";
        var gid=$("#advert-sid").attr("value");
        $("#formToUpdate33").ajaxSubmit({
            type: 'post',
            url: '/advert/addpic',
            data:{adid:7,goods_id:goods_id,gid:gid},
            success: function (data) {
                alert('商城轮播图3'+data.message);
                if(data.isSuccess==true){
                    $(".img33").attr("src", data.url);
                }
            }
        });
    });
    $(".newgoodspic34").change(function(){
        var goods_id="shop";
        var gid=$("#advert-sid").attr("value");
        $("#formToUpdate34").ajaxSubmit({
            type: 'post',
            url: '/advert/addpic',
            data:{adid:8,goods_id:goods_id,gid:gid},
            success: function (data) {
                alert('商城轮播图4'+data.message);
                if(data.isSuccess==true){
                    $(".img34").attr("src", data.url);
                }
            }
        });
    });
//金牌店铺的图片上传
    $(".newgoodspic61").change(function(){
        var goods_id="shop";
        var gid=$("#advert-sid").attr("value");
        $("#formToUpdate61").ajaxSubmit({
            type: 'post',
            url: '/advert/addpic',
            data:{adid:17,goods_id:goods_id,gid:gid},
            success: function (data) {
                alert('金牌店铺图1'+data.message);
                if(data.isSuccess==true){
                    $(".img61").attr("src", data.url);
                }
            }
        });
    });
    $(".newgoodspic62").change(function(){
        var goods_id="shop";
        var gid=$("#advert-sid").attr("value");
        $("#formToUpdate62").ajaxSubmit({
            type: 'post',
            url: '/advert/addpic',
            data:{adid:18,goods_id:goods_id,gid:gid},
            success: function (data) {
                alert('金牌店铺图2'+data.message);
                if(data.isSuccess==true){
                    $(".img62").attr("src", data.url);
                }
            }
        });
    });
    $(".newgoodspic63").change(function(){
        var goods_id="shop";
        var gid=$("#advert-sid").attr("value");
        $("#formToUpdate63").ajaxSubmit({
            type: 'post',
            url: '/advert/addpic',
            data:{adid:19,goods_id:goods_id,gid:gid},
            success: function (data) {
                alert('金牌店铺图3'+data.message);
                if(data.isSuccess==true){
                    $(".img63").attr("src", data.url);
                }
            }
        });
    });
    //单个店铺的图片上传
    $(".newgoodspic81").change(function(){
        var goods_id="shop";
        var gid=$("#advert-sid").attr("value");
        $("#formToUpdate81").ajaxSubmit({
            type: 'post',
            url: '/advert/addpic',
            data:{adid:26,goods_id:goods_id,gid:gid},
            success: function (data) {
                alert('单一店铺图'+data.message);
                if(data.isSuccess==true){
                    $(".img81").attr("src", data.url);
                }
            }
        });
    });
});
