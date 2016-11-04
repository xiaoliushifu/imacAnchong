/**
 * Created by lengxue on 2016/5/16.
 */
$(function(){
    //查看详情
    $(".view").click(function(){
        var id=$(this).attr("data-id");
        var str='';
        $("#brand").empty();
        $("#cat").siblings().remove();
        $.get('/shop/shopbc',{'sid':id},function(data,status){
            for(var i=0;i<data['brand'].length;i++){
                str+='<hr><dl class="dl-horizontal"> <dt>主营品牌：</dt> <dd>'+data['brand'][i].brand_id+'</dd> </dl> <dl class="dl-horizontal"> <dt>品牌授权书：</dt> <dd><a href='+data['brand'][i].authorization+' target="_blank"><img src='+data['brand'][i].authorization+' width="100"></a></dd> </dl>';
            }
            $("#brand").append(str),str='';
	        for(var i=0;i<data['cat'].length;i++){
	            str+='<dd>'+data['cat'][i].cat_id+'</dd>';
	        }
	        $("#cat").after(str);
        });
    });

    /*----审核操作----*/
    $("td.check").on("click",'button',function(){
        if(confirm('确定要审核'+$(this).text()+'吗？')){
            //获取商铺ID与用户ID
        		var parent = $(this).parent('td');
            var id=parseInt($(this).attr("data-id"));
            var uid=parseInt($(this).attr("data-uid"));
            $.get("/shop/check",{sid:id,users_id:uid,act:$(this).attr('act')},function(data,status){
                if(data.indexOf('已经') != -1){
                		parent.text('审核已通过');
                } else {
                		parent.parent('tr').empty();
                }
            });
        }
    });

    //商铺开关
    $("td").on('click','button.shop',function(){
        //提示用户
        if(confirm('确定要'+$(this).text()+'此店铺吗?')){
            //获取商铺ID
        		var that = $(this);
            var sid=$(this).attr("data-id");
            var sta = $(this).attr('state');
            var parent = $(this).parent('td');
            //ajax调用接口
            $.post('/shop/state',{'sid':sid,state:sta},function(data,status){
            		if(data.indexOf('成功') != -1){
            			if (sta==4) {
            				parent.prev().text('商铺已关闭');
            			} else {
            				parent.prev().text('审核已通过');
            			}
            			that.siblings('.shop').toggleClass('hidden');
            			that.toggleClass('hidden');
            		} else {
            			alert(data);
            		}
                console.log(data,status);
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
