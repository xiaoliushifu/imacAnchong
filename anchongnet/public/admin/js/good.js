/**
 * Created by lengxue on 2016/4/24.
 */
var Level1=[];//Level1[0]是所有一级分类，Level1[1]是一级分类下的子分类
$(function(){

	/*
	 * 页面初始化时候加载一级分类
	 * */
	 $.get("/getlevel",{pid:0},function(data,status){
	 		Level1[0]=data;
	 		var opt;
	     for(var i=0;i<data.length;i++){
	         opt+="<option  value="+data[i].cat_id+">"+data[i].cat_name+"</option>";
	     }
	     $("#mainselect").append(opt);
	 });

    //通过类ID查看货品的缩影信息
    $(".view").click(function(){
        //
        $("#myModalLabel").text($(this).attr("data-name"));
        $("#goodname").text($(this).attr("data-name"));
        var id=$(this).attr("data-id");
        $.get("/good/"+id,function(data,status){
            $("#market").text(data.market_price);
            $("#cost").text(data.goods_price);
            $("#good").text(data.title);
            $("#vip").text(data.vip_price);
            $("#desc").text(data.goods_desc);//暂无
            $("#viewmodel").text(data.model);
            $("#goodpic").attr("href",data.goods_img);
            $("#goodpic img").attr("src",data.goods_img);
            $("#added").text(data.goods_create_time);
            $("#goodsnumbering").text(data.goods_numbering);
        });
        //根据商品分类id,去cat表中获得分类信息，注意某些商品所属的商品分类不止一种
        var cid=$(this).attr("data-cid");
        $.get("/goodcate/"+cid,function(data,status){
            $("#cat").text(data.cat_name);
        });

        /**
         * 库存数
         */
        $.get("/getStock",{gid:id},function(data,status){
            $("#stock").empty();
            var dl;
            for(var i=0;i<data.length;i++){
                dl="<dl class='dl-horizontal'>  <dd>"+data[i].region_num+"</dd> </dl>";
                $("#stock").append(dl);
            }
        });
    });

	//促销内容
	$(".promotion").click(function(){
		$("#promotion").empty();
		//将货品信息传递过去
		$("#hid_gid").val($(this).attr('data-id'));
		$("#hid_num").val($(this).attr('data-num'));
		$("#pro_gid").text($(this).attr('data-id'));
		$("#pro_name").text($(this).attr('data-title'));
		$("#pro_num").text($(this).attr('data-num'));
		//请求促销时间等数据
		$.get("/promotion/1",function(data,status){
			var dl="";
            for(var i=0;i<data.length;i++){
                dl +='<dl><input type="radio" id="makedownedit" name="promotion_id" value="'+data[i].promotion_id+'">&nbsp;'+data[i].start_time+' ~ '+data[i].end_time+'</dl>';
			}
			$("#promotion").append(dl);
		});
	});

	//促销保存
	$("#promotionsave").click(function(){
		$("#promotionForm").ajaxSubmit({
			success: function (data) {
				if(data.ServerNo == 0){
					alert(data.ResultData.Message);
					location.reload();
				}else{
					alert(data.ResultData.Message);
				}
			}
		});
	});

    //货品列表页 点击编辑按钮
    $(".edit").click(function(){
    		//ajax全局设置同步处理(多分类时尤其明显）
    		$.ajaxSetup({async:false});
        $("#goodscat").empty();
        $("#midselect").empty();
        //有可能有多个分类
        var cid=$(this).attr("data-cid").trim().split(" ");
        var id=$(this).attr("data-id");
        var gid=$(this).attr("data-gid");
        var sid=$("#sid").val();
        var opt;
        var one0=0;
        $("#updateform").attr("action","/good/"+id);
        $("#gid").val(id);
        //多个分类，故需要遍历
        for(var c=0;c<cid.length;c++){
        	$("#goodscat").append('<div class="form-group"><label class="col-sm-2 control-label">商品分类</label><div class="col-sm-10"><div class="row"><div class="col-xs-4"><select class="form-control" id="mainselect'+c+'" name="mainselect'+c+'"></select></div><div class="col-xs-4"><select class="form-control" id="midselect'+c+'" name="midselect'+c+'"></select></div></div></div></div>');
            //一级分类信息是否缓存,也就是八大类
            if(Level1[0] == null) {
	            $.get("/getlevel",{pid:0},function(data,status){
	            		Level1[0]=data;
	            });
            }
            //分类信息的一级分类部分
            opt='';
            for(var i=0;i<Level1[0].length;i++){
                opt +="<option  value="+Level1[0][i].cat_id+">"+Level1[0][i].cat_name+"</option>";
            }
            $("#mainselect"+c).append(opt);

            //一条分类信息的二级分类部分（含父类id)
            opt='';
            $.get("/getSib",{cid:cid[c]},function(data,status){
	            for(var i=0;i<data.length;i++){
	                opt+="<option  value="+data[i].cat_id+">"+data[i].cat_name+"</option>";
	            }
	            $("#midselect"+c).append(opt);
	            //设置选中项
	            $("#midselect"+c+" option[value="+cid[c]+"]").attr("selected",true);
	            $("#mainselect"+c+" option[value="+data[0].parent_id+"]").attr("selected",true);
            });
        }
        //商品名称部分
        $("#name").empty();
        //由第一个分类获取（如果有多个分类的话）
        $.get("/getcommodity",{pid:cid[0],sid:sid},function(data,status,c){
            for(var i=0;i<data.length;i++){
                opt="<option  value="+data[i].goods_id+">"+data[i].title+"</option>";
                $("#name").append(opt);
            }
            $("#name option[value="+gid+"]").attr("selected",true);//商品名选中
            $("#goodsname").val($("#name option[value="+gid+"]").text());//隐藏项目
        });
        	//关键字部分
	    $.get("/getKeywords",{goods_id:gid},function(data,status){
	            $("#keywords").val(data);
	    });
	    //货品的其他信息
        $.get("/good/"+id+"/edit",function(data,status){
            $("#spetag").val(data.goods_name);
            $("#model").val(data.model);
            $("#marketprice").val(data.market_price);
            $("#costprice").val(data.goods_price);
            $("#viprice").val(data.vip_price);
			$("#proprice").val(data.promotion_price);
            $("#description").val(data.goods_desc);
            if(data.added== 2){
                $("#notonsale").attr("checked",true);
            }else if(data.added== 1){
                $("#onsale").attr("checked",true);
            }
            $("#numbering").val(data.goods_numbering);
        });
        //获取货位及库存数
        $.get("/getStock",{gid:id},function(data,status) {
            $("#stocktr").empty();
            var line;
            for(var k=0;k<data.length;k++){
                line='<tr class="line"> <td><input type="text" class="location form-control" value="'+data[k].location+'"></td> <td> <input type="number" min="0" class="regionum form-control" value="'+data[k].region_num+'" /> </td> <td> <button type="button" class="addcuspro btn-sm btn-link" title="添加"> <span class="glyphicon glyphicon-plus"></span> </button> <button type="button" class="savestock btn-sm btn-link" data-id="'+data[k].stock_id+'" title="保存"> <span class="glyphicon glyphicon-save"></span> </button> <button type="button" class="delcuspro btn-sm btn-link" title="删除" data-id="'+data[k].stock_id+'"> <span class="glyphicon glyphicon-minus"></span> </button> </td> </tr>';
                $("#stocktr").append(line);
            }
        });
        //货品的图片信息
        $.get("/getgoodthumb",{gid:id},function(data,status) {
            $(".notem").remove();
            var gallery;
            for(var i=0;i<data.length;i++){
                if(i==0){
                    gallery='<li class="notem"> <div class="gallery text-center"> <img src="'+data[i].thumb_url+'" class="img"> </div> <input type="file" name="file" class="pic" data-id="'+data[i].tid+'" data-gid="'+data[i].gid+'" isfirst="first"> </li>';
                }else{
                    gallery='<li class="notem"> <div class="gallery text-center"> <img src="'+data[i].thumb_url+'" class="img"> </div> <input type="file" name="file" class="pic" data-id="'+data[i].tid+'" data-gid="'+data[i].gid+'"> </li>';
                }
                //加到按钮前
                $("#addforgood").before(gallery);
            }
            for(var i=0;i<$(".gallerys").length;i++){
                $(".gallerys").eq(i).find(".notem").eq(0).addClass("first");
            }
            for(var j=0;j<($(".notem").length);j++){
                if($(".notem").eq(j).hasClass("first")){
                }else{
                    $(".notem").eq(j).prepend('<button type="button" class="delpic btn btn-xs btn-danger" title="删除">x</button>');
                }
            }
        });
    });//过程挺长的

    //添加一条 仓储记录 input框
    $("body").on("click",'.addcuspro',function(){
        var len=$(".line").length;
        var line='<tr class="line"> <td> <input type="text" class="location form-control" /></td><td> <input type="number" min="0" class="regionum form-control" /> </td> <td> <button type="button" class="addcuspro btn-sm btn-link" title="添加"> <span class="glyphicon glyphicon-plus"></span> </button> <button type="button" class="savestock btn-sm btn-link" title="保存"> <span class="glyphicon glyphicon-save"></span> </button> <button type="button" class="delcuspro btn-sm btn-link" title="删除"> <span class="glyphicon glyphicon-minus"></span> </button> </td> </tr>';
        $("#stocktr").append(line);
    });

    //保存一条仓储记录,class=savestock动态生成
    $("body").on("click",'.savestock',function(){
        var regionum=$(this).parentsUntil("#stocktr").find(".regionum").val();
        var location=$(this).parentsUntil("#stocktr").find(".location").val();
        if(regionum==""){
            alert("库存数量不能为空！");
            $(this).parentsUntil("#stocktr").find(".regionum").focus();
        }else{
        		//只有从数据库获得的仓储记录有data-id属性
            var id=$(this).attr("data-id");
            var gid=$("#gid").val();
            $("#save").attr("id","");
            $(this).attr("id","save");
            $("#del").attr("id","");
            $(this).siblings(".delcuspro").attr("id","del");
            //新添加的仓储记录 点击 保存 的情况，需要insert
            if(id==undefined){
                $.ajax({
                    url: "/stock",
                    type:'POST',
                    data:{gid:gid,location:location,regionum:regionum},
                    success:function( response ){
                        alert(response.message);
                        $("#save").attr("data-id",response.id);
                        $("#del").attr("data-id",response.id);
                    }
                });
             //原有仓储记录，update
            }else{
                $.ajax({
                    url: "/stock/"+id,
                    type:'PUT',
                    data:{gid:gid,location:location,regionum:regionum},
                    success:function( response ){
                        alert(response.message);
                    }
                });
            }
        }
    });

    $("body").on("click",'.delcuspro',function(){
        var gid=$("#gid").val();
        var id=$(this).attr("data-id");
        if(confirm("你确定要删除该条库存信息吗？")){
            $(this).parents(".line").addClass("waitfordel");
            //如果数据库中关于该货品的仓储信息，仅有一条时不可删除，而非页面显示仓储条数
            $.get("/getStock",{gid:gid},function(data,status){
                if(data.length==1){
                    alert("不能删除最后一条库存信息！");
                    $(".waitfordel").removeClass("waitfordel");
                }else{
                    $.ajax({
                        url: "/stock/"+id,
                        type:'DELETE',
                        success:function(result){
                            alert(result);
                            $.get('/getotal',{gid:gid},function(data,status){
                            });
                        }
                    });
                    $(".waitfordel").remove();
                }
            });
        }
    });

    //当gallery模块点击的时候执行事件转移
    $("body").on("click",'.gallery',function(){
        $(this).siblings(".pic").click();
    });

    //使得货品编辑时，各个分类信息不可更改。
    $('#goodscat').on('change','select',function(){
    		$(this).val($(this).find('option[selected="selected"]').val());
    		console.log('分类信息不可修改');
    		return false;
    });
    //所属商品不可更改，但仍可通过修改商品，在货品页--编辑-保存即可达到修改所属商品名目的
    $('#name').change(function(){
	    	$(this).val($(this).find('option[selected="selected"]').val());
	    	console.log('货品所属商品不可修改');
	    	return false;
    });
    //编辑货品图片
    $("body").on("change",'.pic',function(){
        var id=$(this).attr("data-id");
        var isfirst=$(this).attr("isfirst");
        var gid=$(this).attr("data-gid");
        if(id==undefined){
            $("#method").empty();
            var objUrl = getObjectURL(this.files[0]) ;
            var filename=$(this).val();
            $(".isAdd").removeClass("isAdd");
            $(this).addClass("isAdd");
            if (objUrl) {
                $(".isEdit").removeClass("isEdit");
                $(this).siblings(".gallery").find(".img").addClass("isEdit");
                if($(this).parents("li").hasClass("first")){
                }else{
                    $(this).siblings(".gallery").before('<button type="button" class="delpic btn btn-xs btn-danger" title="删除">x</button>');
                }
                $("#formToUpdate").ajaxSubmit({
                    type: 'post',
                    url: '/addgoodpic',
                    data:{gid:gid},
                    success: function (data) {
                        alert(data.message);
                        if(data.isSuccess==true){
                            $(".isEdit").attr("src", objUrl);
                            $(".isAdd").attr("data-id",data.tid);
                        }
                    },
                });
            }
        }else{
            var method='<input type="hidden" name="_method" value="PUT">';
            $("#method").append(method);
            if(confirm('你确定要替换这张图片吗？')){
                var objUrl = getObjectURL(this.files[0]) ;
                var filename=$(this).val();
                if (objUrl) {
                    $(".isEdit").removeClass("isEdit");
                    $(this).siblings(".gallery").find(".img").addClass("isEdit");
                    $("#formToUpdate").ajaxSubmit({
                        type:'post',
                        url:'/thumb/'+id,
                        data:{isfirst:isfirst,gid:gid},
                        success:function(data){
                            alert(data.message);
                            if(data.isSuccess==true){
                                $(".isEdit").attr("src",objUrl);
                            }
                        },
                    });
                }
            }
        }
    });

    $("body").on("click",'.delpic',function(){
        if(confirm('确定要删除该张图片吗？')){
            var id=$(this).siblings('.pic').attr("data-id");
            $.ajax({
                url: '/thumb/'+id,
                type:'DELETE',
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

    $(".addpic").click(function(){
        if($(this).hasClass("goodpic")){
            var len=$(this).parentsUntil(".gal").find("li").length;
            if(len<6){
                $(this).before($(this).siblings(".template").clone().attr("class",""));
            }else{
                alert("最多只能添加五张图片！");
            }
        }else{
            $(this).before($(this).siblings(".template").clone().attr("class",""));
        }
    });
//点击广告
    $(".advert").click(function(){
        //传递商品名
        $("#advert-goodsname").text($(this).attr("data-name"));
        //传递货品id
        $("#advert-goodsnum").text($(this).attr("data-num"));
        //传递商品id
        $("#advert-goods_id").val($(this).attr("data-gid"));
        //传递货品id
        $("#advert-gid").val($(this).attr("data-id"));
    });


    	/**
    	 * 货品删除
    	 */
    $(".goods_del").click(function(){
    		var o = $(this);
        var gid=o.attr("data-id");
        var goods_id=o.attr("data-gid");
        if(confirm('确认要删除这条货品吗？')){
            $.ajax({
                url: "/good/404",
                type:'DELETE',
                data:{aid:gid,bid:goods_id},
                success:function(res ){
	                	alert(res);
	                if (res.indexOf('成功') != -1) {
	                		o.parents('tr').remove();
	                }
                }
            });
        }
    });

    //该图片修改模块的表单与图片还有文件inpu的命名根据数据库广告表的id进行设置
    //商城轮播图
    $(".newgoodspic31").change(function(){
        //获取商品ID
        var goods_id=$("#advert-goods_id").attr("value");
        //获取货品ID
        var gid=$("#advert-gid").attr("value");
        //进行ajax表单提交
        $("#formToUpdate31").ajaxSubmit({
            type: 'post',
            url: '/advert/addpic',
            //传递数据adid为该广告在广告表的id
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
    $(".newgoodspic32").change(function(){
        //获取商品ID
        var goods_id=$("#advert-goods_id").attr("value");
        //获取货品ID
        var gid=$("#advert-gid").attr("value");
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
        //获取商品ID
        var goods_id=$("#advert-goods_id").attr("value");
        //获取货品ID
        var gid=$("#advert-gid").attr("value");
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
        //获取商品ID
        var goods_id=$("#advert-goods_id").attr("value");
        //获取货品ID
        var gid=$("#advert-gid").attr("value");
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
//最新上架
    $(".newgoodspic51").change(function(){
        //获取商品ID
        var goods_id=$("#advert-goods_id").attr("value");
        //获取货品ID
        var gid=$("#advert-gid").attr("value");
        $("#formToUpdate51").ajaxSubmit({
            type: 'post',
            url: '/advert/addpic',
            data:{adid:13,goods_id:goods_id,gid:gid},
            success: function (data) {
                alert('最新上架1'+data.message);
                if(data.isSuccess==true){
                    $(".img51").attr("src", data.url);
                }
            }
        });
    });
    $(".newgoodspic52").change(function(){
        //获取商品ID
        var goods_id=$("#advert-goods_id").attr("value");
        //获取货品ID
        var gid=$("#advert-gid").attr("value");
        $("#formToUpdate52").ajaxSubmit({
            type: 'post',
            url: '/advert/addpic',
            data:{adid:14,goods_id:goods_id,gid:gid},
            success: function (data) {
                alert('最新上架2'+data.message);
                if(data.isSuccess==true){
                    $(".img52").attr("src", data.url);
                }
            }
        });
    });
    $(".newgoodspic53").change(function(){
        //获取商品ID
        var goods_id=$("#advert-goods_id").attr("value");
        //获取货品ID
        var gid=$("#advert-gid").attr("value");
        $("#formToUpdate53").ajaxSubmit({
            type: 'post',
            url: '/advert/addpic',
            data:{adid:15,goods_id:goods_id,gid:gid},
            success: function (data) {
                alert('最新上架3'+data.message);
                if(data.isSuccess==true){
                    $(".img53").attr("src", data.url);
                }
            }
        });
    });
    $(".newgoodspic54").change(function(){
        //获取商品ID
        var goods_id=$("#advert-goods_id").attr("value");
        //获取货品ID
        var gid=$("#advert-gid").attr("value");
        $("#formToUpdate54").ajaxSubmit({
            type: 'post',
            url: '/advert/addpic',
            data:{adid:16,goods_id:goods_id,gid:gid},
            success: function (data) {
                alert('最新上架4'+data.message);
                if(data.isSuccess==true){
                    $(".img54").attr("src", data.url);
                }
            }
        });
    });

//第一块热卖单品
    $(".newgoodspic71").change(function(){
        //获取商品ID
        var goods_id=$("#advert-goods_id").attr("value");
        //获取货品ID
        var gid=$("#advert-gid").attr("value");
        $("#formToUpdate71").ajaxSubmit({
            type: 'post',
            url: '/advert/addpic',
            data:{adid:20,goods_id:goods_id,gid:gid},
            success: function (data) {
                alert('第一块热卖单品1'+data.message);
                if(data.isSuccess==true){
                    $(".img71").attr("src", data.url);
                }
            }
        });
    });
    $(".newgoodspic72").change(function(){
        //获取商品ID
        var goods_id=$("#advert-goods_id").attr("value");
        //获取货品ID
        var gid=$("#advert-gid").attr("value");
        $("#formToUpdate72").ajaxSubmit({
            type: 'post',
            url: '/advert/addpic',
            data:{adid:21,goods_id:goods_id,gid:gid},
            success: function (data) {
                alert('第一块热卖单品2'+data.message);
                if(data.isSuccess==true){
                    $(".img72").attr("src", data.url);
                }
            }
        });
    });
    $(".newgoodspic73").change(function(){
        //获取商品ID
        var goods_id=$("#advert-goods_id").attr("value");
        //获取货品ID
        var gid=$("#advert-gid").attr("value");
        $("#formToUpdate73").ajaxSubmit({
            type: 'post',
            url: '/advert/addpic',
            data:{adid:22,goods_id:goods_id,gid:gid},
            success: function (data) {
                alert('第一块热卖单品3'+data.message);
                if(data.isSuccess==true){
                    $(".img73").attr("src", data.url);
                }
            }
        });
    });
    $(".newgoodspic74").change(function(){
        //获取商品ID
        var goods_id=$("#advert-goods_id").attr("value");
        //获取货品ID
        var gid=$("#advert-gid").attr("value");
        $("#formToUpdate74").ajaxSubmit({
            type: 'post',
            url: '/advert/addpic',
            data:{adid:23,goods_id:goods_id,gid:gid},
            success: function (data) {
                alert('第一块热卖单品4'+data.message);
                if(data.isSuccess==true){
                    $(".img74").attr("src", data.url);
                }
            }
        });
    });
    $(".newgoodspic75").change(function(){
        //获取商品ID
        var goods_id=$("#advert-goods_id").attr("value");
        //获取货品ID
        var gid=$("#advert-gid").attr("value");
        $("#formToUpdate75").ajaxSubmit({
            type: 'post',
            url: '/advert/addpic',
            data:{adid:24,goods_id:goods_id,gid:gid},
            success: function (data) {
                alert('第一块热卖单品5'+data.message);
                if(data.isSuccess==true){
                    $(".img75").attr("src", data.url);
                }
            }
        });
    });
    $(".newgoodspic76").change(function(){
        //获取商品ID
        var goods_id=$("#advert-goods_id").attr("value");
        //获取货品ID
        var gid=$("#advert-gid").attr("value");
        $("#formToUpdate76").ajaxSubmit({
            type: 'post',
            url: '/advert/addpic',
            data:{adid:25,goods_id:goods_id,gid:gid},
            success: function (data) {
                alert('第一块热卖单品6'+data.message);
                if(data.isSuccess==true){
                    $(".img76").attr("src", data.url);
                }
            }
        });
    });
//强力推荐
    $(".newgoodspic91").change(function(){
        //获取商品ID
        var goods_id=$("#advert-goods_id").attr("value");
        //获取货品ID
        var gid=$("#advert-gid").attr("value");
        $("#formToUpdate91").ajaxSubmit({
            type: 'post',
            url: '/advert/addpic',
            data:{adid:27,goods_id:goods_id,gid:gid},
            success: function (data) {
                alert('强力推荐1'+data.message);
                if(data.isSuccess==true){
                    $(".img91").attr("src", data.url);
                }
            }
        });
    });
    $(".newgoodspic92").change(function(){
        //获取商品ID
        var goods_id=$("#advert-goods_id").attr("value");
        //获取货品ID
        var gid=$("#advert-gid").attr("value");
        $("#formToUpdate92").ajaxSubmit({
            type: 'post',
            url: '/advert/addpic',
            data:{adid:28,goods_id:goods_id,gid:gid},
            success: function (data) {
                alert('强力推荐2'+data.message);
                if(data.isSuccess==true){
                    $(".img92").attr("src", data.url);
                }
            }
        });
    });
    $(".newgoodspic93").change(function(){
        //获取商品ID
        var goods_id=$("#advert-goods_id").attr("value");
        //获取货品ID
        var gid=$("#advert-gid").attr("value");
        $("#formToUpdate93").ajaxSubmit({
            type: 'post',
            url: '/advert/addpic',
            data:{adid:29,goods_id:goods_id,gid:gid},
            success: function (data) {
                alert('强力推荐3'+data.message);
                if(data.isSuccess==true){
                    $(".img93").attr("src", data.url);
                }
            }
        });
    });
//第二块热卖单品
    $(".newgoodspic101").change(function(){
        //获取商品ID
        var goods_id=$("#advert-goods_id").attr("value");
        //获取货品ID
        var gid=$("#advert-gid").attr("value");
        $("#formToUpdate101").ajaxSubmit({
            type: 'post',
            url: '/advert/addpic',
            data:{adid:30,goods_id:goods_id,gid:gid},
            success: function (data) {
                alert('第二块热卖单品1'+data.message);
                if(data.isSuccess==true){
                    $(".img101").attr("src", data.url);
                }
            }
        });
    });
    $(".newgoodspic102").change(function(){
        //获取商品ID
        var goods_id=$("#advert-goods_id").attr("value");
        //获取货品ID
        var gid=$("#advert-gid").attr("value");
        $("#formToUpdate102").ajaxSubmit({
            type: 'post',
            url: '/advert/addpic',
            data:{adid:31,goods_id:goods_id,gid:gid},
            success: function (data) {
                alert('第二块热卖单品2'+data.message);
                if(data.isSuccess==true){
                    $(".img102").attr("src", data.url);
                }
            }
        });
    });
    $(".newgoodspic103").change(function(){
        //获取商品ID
        var goods_id=$("#advert-goods_id").attr("value");
        //获取货品ID
        var gid=$("#advert-gid").attr("value");
        $("#formToUpdate103").ajaxSubmit({
            type: 'post',
            url: '/advert/addpic',
            data:{adid:32,goods_id:goods_id,gid:gid},
            success: function (data) {
                alert('第二块热卖单品3'+data.message);
                if(data.isSuccess==true){
                    $(".img103").attr("src", data.url);
                }
            }
        });
    });
    $(".newgoodspic104").change(function(){
        //获取商品ID
        var goods_id=$("#advert-goods_id").attr("value");
        //获取货品ID
        var gid=$("#advert-gid").attr("value");
        $("#formToUpdate104").ajaxSubmit({
            type: 'post',
            url: '/advert/addpic',
            data:{adid:33,goods_id:goods_id,gid:gid},
            success: function (data) {
                alert('第二块热卖单品4'+data.message);
                if(data.isSuccess==true){
                    $(".img104").attr("src", data.url);
                }
            }
        });
    });
    $(".newgoodspic105").change(function(){
        //获取商品ID
        var goods_id=$("#advert-goods_id").attr("value");
        //获取货品ID
        var gid=$("#advert-gid").attr("value");
        $("#formToUpdate105").ajaxSubmit({
            type: 'post',
            url: '/advert/addpic',
            data:{adid:34,goods_id:goods_id,gid:gid},
            success: function (data) {
                alert('第二块热卖单品5'+data.message);
                if(data.isSuccess==true){
                    $(".img105").attr("src", data.url);
                }
            }
        });
    });
    $(".newgoodspic106").change(function(){
        //获取商品ID
        var goods_id=$("#advert-goods_id").attr("value");
        //获取货品ID
        var gid=$("#advert-gid").attr("value");
        $("#formToUpdate106").ajaxSubmit({
            type: 'post',
            url: '/advert/addpic',
            data:{adid:35,goods_id:goods_id,gid:gid},
            success: function (data) {
                alert('第二块热卖单品6'+data.message);
                if(data.isSuccess==true){
                    $(".img106").attr("src", data.url);
                }
            }
        });
    });
});
