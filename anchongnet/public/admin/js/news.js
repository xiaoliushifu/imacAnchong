/**
/*
 * Created by lengxue on 2016/6/6.
 */
$(function(){
    //异步编辑发布
    $(".edit").click(function(){
        var id=$(this).attr("data-id");
        $("#updateform").attr("action","/advert/inforupdate");
        $.get("/advert/firstinfor/"+id,function(data,status){
            $("#infor_id").val(data[0].infor_id);
            $("#title").val(data[0].title);
            $("#updateimg").attr("src",data[0].img);
            $("#newsimg").val(data[0].img);
            UE.getEditor('content').setContent(data[0].content);
        })
    });
    //异步图片
    $("#newspic").change(function(){
        $("#formToUpdateimg").ajaxSubmit({
            type: 'POST',
            url: '/img',
            data:{imgtype:4},
            success: function (data) {
                alert(data.message);
                if(data.isSuccess==true){
                    $("#updateimg").attr("src", data.url);
                    $("#newsimg").val(data.url);
                }
            }
        });
    });
    //修改保存
    $("#save").click(function(){
        $("#updateform").ajaxSubmit({
            type: 'POST',
            url: '/advert/inforupdate',
            success: function (data) {
                alert(data.message);
                location.reload();
            },
        });
    });
    //点击删除
    $(".del").click(function(){
        //资讯ID
        infor_id=$(this).attr("data_id");
        if(confirm('确认要删除吗？')){
            $.ajax({
                url: "/advert/infordel/"+infor_id,
                type:'get',
                success:function( response ){
                    if(response.ServerNo == 0){
                        alert('删除成功');
                        location.reload();
                    }else{
                        alert('删除失败');
                    }
                }
            });
    	}
    });

    //点击“广告轮播图”按钮，出现弹框
        $(".advertpic").click(function(){
            $("#advert-bid").val($(this).attr("data-id"));
        });

        //该图片修改模块的表单与图片还有文件inpu的命名根据数据库广告表的id进行设置
        //商机轮播图
        $(".appbusinesspic21").change(function(){
            //获取商机ID
            var bid=$("#advert-bid").attr("value");
            //进行ajax表单提交
            $("#formToUpdate21").ajaxSubmit({
                type: 'post',
                url: '/advert/addpic',
                //传递数据adid为该广告在广告表的id
                data:{adid:1,goods_id:'news',gid:bid},
                //假如返回成功则执行函数
                success: function (data) {
                    alert('商机首页轮播图1'+data.message);
                    if(data.isSuccess==true){
                        $(".img21").attr("src", data.url);
                    }
                }
            });
        });
        //商机轮播图
        $(".appbusinesspic22").change(function(){
            var bid=$("#advert-bid").attr("value");
            $("#formToUpdate22").ajaxSubmit({
                type: 'post',
                url: '/advert/addpic',
                data:{adid:2,goods_id:'news',gid:bid},
                success: function (data) {
                    alert('商机首页轮播图2'+data.message);
                    if(data.isSuccess==true){
                        $(".img22").attr("src", data.url);
                    }
                }
            });
        });
        //商机轮播图
        $(".appbusinesspic23").change(function(){
            var bid=$("#advert-bid").attr("value");
            $("#formToUpdate23").ajaxSubmit({
                type: 'post',
                url: '/advert/addpic',
                data:{adid:3,goods_id:'news',gid:bid},
                success: function (data) {
                    alert('商机首页轮播图3'+data.message);
                    if(data.isSuccess==true){
                        $(".img23").attr("src", data.url);
                    }
                }
            });
        });
        //商机轮播图
        $(".appbusinesspic24").change(function(){
            var bid=$("#advert-bid").attr("value");
            $("#formToUpdate24").ajaxSubmit({
                type: 'post',
                url: '/advert/addpic',
                data:{adid:4,goods_id:'news',gid:bid},
                success: function (data) {
                    alert('商机首页轮播图4'+data.message);
                    if(data.isSuccess==true){
                        $(".img24").attr("src", data.url);
                    }
                }
            });
        });
    //最新招标项目
        $(".appbusinesspic41").change(function(){
            //获取商机ID
            var bid=$("#advert-bid").attr("value");
            $("#formToUpdate41").ajaxSubmit({
                type: 'post',
                url: '/advert/addpic',
                data:{adid:9,goods_id:'北京市',gid:bid},
                success: function (data) {
                    alert('最新招标项目1'+data.message);
                    if(data.isSuccess==true){
                        $(".img41").attr("src", data.url);
                    }
                }
            });
        });
        $(".appbusinesspic42").change(function(){
            //获取商机ID
            var bid=$("#advert-bid").attr("value");
            $("#formToUpdate42").ajaxSubmit({
                type: 'post',
                url: '/advert/addpic',
                data:{adid:10,goods_id:'上海市',gid:bid},
                success: function (data) {
                    alert('最新招标项目2'+data.message);
                    if(data.isSuccess==true){
                        $(".img42").attr("src", data.url);
                    }
                }
            });
        });
        $(".appbusinesspic43").change(function(){
            //获取商机ID
            var bid=$("#advert-bid").attr("value");
            $("#formToUpdate43").ajaxSubmit({
                type: 'post',
                url: '/advert/addpic',
                data:{adid:11,goods_id:'南京市',gid:bid},
                success: function (data) {
                    alert('最新招标项目3'+data.message);
                    if(data.isSuccess==true){
                        $(".img43").attr("src", data.url);
                    }
                }
            });
        });
        $(".appbusinesspic44").change(function(){
            //获取商机ID
            var bid=$("#advert-bid").attr("value");
            $("#formToUpdate44").ajaxSubmit({
                type: 'post',
                url: '/advert/addpic',
                data:{adid:12,goods_id:'河北省',gid:bid},
                success: function (data) {
                    alert('最新招标项目4'+data.message);
                    if(data.isSuccess==true){
                        $(".img44").attr("src", data.url);
                    }
                }
            });
        });

    //商机工程轮播图
        $(".appbusinesspic111").change(function(){
            //获取商机ID
            var bid=$("#advert-bid").attr("value");
            $("#formToUpdate111").ajaxSubmit({
                type: 'post',
                url: '/advert/addpic',
                data:{adid:36,goods_id:'news',gid:bid},
                success: function (data) {
                    alert('工程轮播图1'+data.message);
                    if(data.isSuccess==true){
                        $(".img111").attr("src", data.url);
                    }
                }
            });
        });
        $(".appbusinesspic112").change(function(){
            //获取商机ID
            var bid=$("#advert-bid").attr("value");
            $("#formToUpdate112").ajaxSubmit({
                type: 'post',
                url: '/advert/addpic',
                data:{adid:37,goods_id:'news',gid:bid},
                success: function (data) {
                    alert('工程轮播图2'+data.message);
                    if(data.isSuccess==true){
                        $(".img112").attr("src", data.url);
                    }
                }
            });
        });
        $(".appbusinesspic113").change(function(){
            //获取商机ID
            var bid=$("#advert-bid").attr("value");
            $("#formToUpdate113").ajaxSubmit({
                type: 'post',
                url: '/advert/addpic',
                data:{adid:38,goods_id:'news',gid:bid},
                success: function (data) {
                    alert('工程轮播图3'+data.message);
                    if(data.isSuccess==true){
                        $(".img113").attr("src", data.url);
                    }
                }
            });
        });
        $(".appbusinesspic114").change(function(){
            //获取商机ID
            var bid=$("#advert-bid").attr("value");
            $("#formToUpdate114").ajaxSubmit({
                type: 'post',
                url: '/advert/addpic',
                data:{adid:39,goods_id:'news',gid:bid},
                success: function (data) {
                    alert('工程轮播图4'+data.message);
                    if(data.isSuccess==true){
                        $(".img114").attr("src", data.url);
                    }
                }
            });
        });

    //商机人才轮播图
        $(".appbusinesspic121").change(function(){
            //获取商机ID
            var bid=$("#advert-bid").attr("value");
            $("#formToUpdate121").ajaxSubmit({
                type: 'post',
                url: '/advert/addpic',
                data:{adid:40,goods_id:'news',gid:bid},
                success: function (data) {
                    alert('人才轮播图1'+data.message);
                    if(data.isSuccess==true){
                        $(".img121").attr("src", data.url);
                    }
                }
            });
        });
        $(".appbusinesspic122").change(function(){
            //获取商机ID
            var bid=$("#advert-bid").attr("value");
            $("#formToUpdate122").ajaxSubmit({
                type: 'post',
                url: '/advert/addpic',
                data:{adid:41,goods_id:'news',gid:bid},
                success: function (data) {
                    alert('人才轮播图2'+data.message);
                    if(data.isSuccess==true){
                        $(".img122").attr("src", data.url);
                    }
                }
            });
        });
        $(".appbusinesspic123").change(function(){
            //获取商机ID
            var bid=$("#advert-bid").attr("value");
            $("#formToUpdate123").ajaxSubmit({
                type: 'post',
                url: '/advert/addpic',
                data:{adid:42,goods_id:'news',gid:bid},
                success: function (data) {
                    alert('人才轮播图3'+data.message);
                    if(data.isSuccess==true){
                        $(".img123").attr("src", data.url);
                    }
                }
            });
        });
        $(".appbusinesspic124").change(function(){
            //获取商机ID
            var bid=$("#advert-bid").attr("value");
            $("#formToUpdate124").ajaxSubmit({
                type: 'post',
                url: '/advert/addpic',
                data:{adid:43,goods_id:'news',gid:bid},
                success: function (data) {
                    alert('人才轮播图4'+data.message);
                    if(data.isSuccess==true){
                        $(".img124").attr("src", data.url);
                    }
                }
            });
        });
    //商机找货轮播图
        $(".appbusinesspic131").change(function(){
            //获取商机ID
            var bid=$("#advert-bid").attr("value");
            $("#formToUpdate131").ajaxSubmit({
                type: 'post',
                url: '/advert/addpic',
                data:{adid:44,goods_id:'news',gid:bid},
                success: function (data) {
                    alert('找货轮播图1'+data.message);
                    if(data.isSuccess==true){
                        $(".img131").attr("src", data.url);
                    }
                }
            });
        });
        $(".appbusinesspic132").change(function(){
            //获取商机ID
            var bid=$("#advert-bid").attr("value");
            $("#formToUpdate132").ajaxSubmit({
                type: 'post',
                url: '/advert/addpic',
                data:{adid:45,goods_id:'news',gid:bid},
                success: function (data) {
                    alert('找货轮播图2'+data.message);
                    if(data.isSuccess==true){
                        $(".img132").attr("src", data.url);
                    }
                }
            });
        });
        $(".appbusinesspic133").change(function(){
            //获取商机ID
            var bid=$("#advert-bid").attr("value");
            $("#formToUpdate133").ajaxSubmit({
                type: 'post',
                url: '/advert/addpic',
                data:{adid:46,goods_id:'news',gid:bid},
                success: function (data) {
                    alert('找货轮播图3'+data.message);
                    if(data.isSuccess==true){
                        $(".img133").attr("src", data.url);
                    }
                }
            });
        });
        $(".appbusinesspic134").change(function(){
            //获取商机ID
            var bid=$("#advert-bid").attr("value");
            $("#formToUpdate134").ajaxSubmit({
                type: 'post',
                url: '/advert/addpic',
                data:{adid:47,goods_id:'news',gid:bid},
                success: function (data) {
                    alert('找货轮播图4'+data.message);
                    if(data.isSuccess==true){
                        $(".img134").attr("src", data.url);
                    }
                }
            });
        });

});
