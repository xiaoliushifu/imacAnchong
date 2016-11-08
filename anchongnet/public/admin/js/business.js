/**
 * Created by lengxue on 2016/6/8.
 */
$(function(){
    /*
     * 编辑商机弹框，获得所有商机标签
     */
    $.get('/getag',function(data,status){
        var opt;
        for(var i=0;i<data.length;i++){
            opt+='<option value='+data[i].tag+'>'+data[i].tag+'</option>';
        }
        $("#tag").append(opt);
    });

    //查看商机详情
    $(".view").click(function(){
        var children=$(this).parents('tr').children();
        var li;
        //ajax获取商机的字段
        $("#bustitle").text(children.eq(0).text());
        $("#vtitle").text(children.eq(0).text());
        $("#vcontent").text(children.eq(1).text());
        $("#vtag").text(children.eq(3).text());
        $("#vphone").text(children.eq(7).text());
        $("#vcontact").text(children.eq(8).text());
        $("#vtype").text(children.eq(9).text());
        $("#vcreate").text(children.eq(4).text());
        $("#varea").text(children.eq(6).text());
        $("#vendtime").text(new Date(children.eq(5).text()*1000).toLocaleDateString());
        $("#vimg").empty();
        //分隔图片字符串
        var imgs=children.get(2).innerHTML.split("#@#");
        for(var i=0;i<imgs.length;i++){
        		if (imgs[i]) {
        			li='<li class="list-group-item"><a href='+imgs[i]+' target="_blank"><img src='+imgs[i]+' width="100"></a> </li>';
        			$("#vimg").append(li);
        		}
        }
    });

    /**
     * 表单验证逻辑 工程结束时间项
     */
    $("#updateform").validate({
    		//验证规则
		rules:{
			endtime:{
				   dateISO:true,
			   },
		},
    })

    //商机的编辑
    $(".edit").click(function(){
        //获取商机的ID
        var id=$(this).attr("data-id");
        var children=$(this).parents('tr').children();
        //赋予表单提交的地方
        $("#updateform").attr("action",'/business/'+id);
        $("#bid").val(id);
        $("#imgdata").val("");
        $("#title").val(children.eq(0).text());
        $("#content").val(children.eq(1).text());
        $("#tag").find("option[text="+children.eq(3).text()+"]").attr("selected",true);
        $("#contact").val(children.eq(8).text());
        $("#phone").val(children.eq(7).text());
        $("#etype").find("option[text="+children.eq(3).text()+"]").attr("selected",true);
        $("#area").val(children.eq(6).text());
        $("#endtime").val(new Date(children.eq(5).text()*1000).toLocaleDateString());

        //商机图片
        var imgstr = children.get(2).innerHTML;
        var imgs = imgstr.split("#@#");
        $(".notem").remove();
        var gallery;
        for(var i=0;i<imgs.length;i++){
        		//也许有的商机没有图片
        		if (imgs[i]) {
                 $("#imgdata").val(imgstr);
        			gallery='<li class="notem"> <div class="gallery text-center"> <img src="'+imgs[i]+'" class="img"> </div> <input type="file" name="file" class="pic" data-id="'+id+'" pic-id="'+i+'"> </li>';
        			$("#addforgood").before(gallery);
        		}
        }
        //生成删除按钮
        for(var j=0;j<$(".notem").length;j++){
            $(".notem").eq(j).prepend('<button type="button" class="delpic btn btn-xs btn-danger" title="删除">x</button>');
        }
    });
    
  //删除按钮
    $(".del").click(function(){
        if(confirm('确定要删除这条商机吗？')){
            var o=$(this);
            var id=o.attr("data-id");
            $.ajax({
                url: "/business/"+id,
                type: 'DELETE',//部分浏览器支持
                success: function(result) {
                		console.log(result);
                    if(result.indexOf('成功')!=-1){
                    		alert(result);
                    		o.parents('tr').remove();
                    }
                }
            });
        }
    });

    //当gallery模块点击的时候执行事件转移
    $("body").on("click",'.gallery',function(){
        $(this).siblings(".pic").click();
    });

    //当图片改变的时候执行修改
    $("body").on("change",'.pic',function(){
        var id=$(this).attr("data-id");
        //取得图片字符串
        var imgs=$("#imgdata").val();
        if(confirm('你确定要替换这张图片吗？')){
            //获得上传图片的URL
            var objUrl = getObjectURL(this.files[0]) ;
            var filename=$(this).val();
            if (objUrl) {
                //先清除所有的修改标签
                $(".isEdit").removeClass("isEdit");
                //为该元素增加修改标签
                $(this).siblings(".gallery").find(".img").addClass("isEdit");
                //取到上个pic的pic-id
                var picid=$(this).parent().prev().find(".pic").attr("pic-id");
                //判断是否有picid
                if(picid !== undefined){
                    $(this).attr("pic-id",parseInt(picid)+1);
                }else{
                    $(this).attr("pic-id",0);
                }
                //赋值pic-id
                var pic=$(this).attr("pic-id");
                //进行ajax提交
                $("#formToUpdate").ajaxSubmit({
                    type:'post',
                    data: {img:imgs,pic:pic},
                    url:'/editbusimg/'+id,
                    success:function(data){
                        alert(data.message);
                        if(data.isSuccess==true){
                            $(".isEdit").attr("src",objUrl);
                            $('#imgdata').val(data.imgs);
                        }
                    },
                });
            }
        }
    });

    //删除图片
    $("body").on("click",'.delpic',function(){
        //提示确认是否删除
        if(confirm('确定要删除该张图片吗？')){
            //获取上个pic-id
            var picid=$(this).parent().prev().find(".pic").attr("pic-id");
            //判断是否有picid
            if(picid !== undefined){
                $(this).attr("pic-id",parseInt(picid)+1);
            }else{
                $(this).attr("pic-id",0);
            }
            //赋值pic-id
            var pic=$(this).attr("pic-id");
            //取得商机id
            var id=$("#bid").val();
            //取得图片字符串
            var imgs=$("#imgdata").val();
            //ajax进行数据库删除
            $.ajax({
                url: '/delbusinessimg/'+id,
                data:{img:imgs,pic:pic},
                type:'post',
                success:function(result){
                    alert(result);
                }
            });
            $(this).parent().remove();
        }
    });

    //建立一個可存取到該file的url
    function getObjectURL(file) {
        var url = null ;
        if (window.createObjectURL!=undefined) { // basic
            url = window.createObjectURL(file) ;
        } else if (window.URL!=undefined) { // mozilla(firefox)
            url = window.URL.createObjectURL(file) ;
        } else if (window.webkitURL!=undefined) { // webkit or chrome
            url = window.webkitURL.createObjectURL(file) ;
        }
        return url ;
    }

    //添加一个file框
    $(".addpic").click(function(){
        //获得该商机的id
        var id=$("#bid").val();
        if($(this).hasClass("goodpic")){
            //在该元素之前插入内容
            $(this).before($(this).siblings(".template").clone().attr("class","notem"));
            $(".pic").attr("data-id",id);
        }else{
            //在该元素之前插入内容
            $(this).before($(this).siblings(".template").clone().attr("class","notem"));
            $(".pic").attr("data-id",id);
        }
    });

    /**
     * 广告推送与取消推送
     */
    $("button:contains('推送')").click(function(){
        //商机ID
        bid=$(this).attr("data-id");
        //显示提示,避免误操作
        if(confirm($(this).attr('note'))){
            $.ajax({
                url: "/advert/businessadvert",
                type:'POST',
                data:{goods_id:'business',bid:bid,recommend:$(this).attr('reco')},
                success:function( response ){
                    if(response.ServerNo == 0){
                        alert('操作成功');
                        location.reload();
                    }else{
                        alert('操作失败');
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
            data:{adid:1,goods_id:'business',gid:bid},
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
            data:{adid:2,goods_id:'business',gid:bid},
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
            data:{adid:3,goods_id:'business',gid:bid},
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
            data:{adid:4,goods_id:'business',gid:bid},
            success: function (data) {
                alert('商机首页轮播图4'+data.message);
                if(data.isSuccess==true){
                    $(".img24").attr("src", data.url);
                }
            }
        });
    });
//最新招标项目(广告)
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
            data:{adid:36,goods_id:'business',gid:bid},
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
            data:{adid:37,goods_id:'business',gid:bid},
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
            data:{adid:38,goods_id:'business',gid:bid},
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
            data:{adid:39,goods_id:'business',gid:bid},
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
            data:{adid:40,goods_id:'business',gid:bid},
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
            data:{adid:41,goods_id:'business',gid:bid},
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
            data:{adid:42,goods_id:'business',gid:bid},
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
            data:{adid:43,goods_id:'business',gid:bid},
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
            data:{adid:44,goods_id:'business',gid:bid},
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
            data:{adid:45,goods_id:'business',gid:bid},
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
            data:{adid:46,goods_id:'business',gid:bid},
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
            data:{adid:47,goods_id:'business',gid:bid},
            success: function (data) {
                alert('找货轮播图4'+data.message);
                if(data.isSuccess==true){
                    $(".img134").attr("src", data.url);
                }
            }
        });
    });

});
