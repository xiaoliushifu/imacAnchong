/**
 * Created by lengxue on 2016/4/24.
 */
$(function(){
    //通过类ID查看货品的缩影信息
    $(".view").click(function(){
        //
        $("#myModalLabel").text($(this).attr("data-name"));
        $("#goodname").text($(this).attr("data-name"));
        var id=$(this).attr("data-id");
        $.get("/good/"+id,function(data,status){
            $("#market").text(data.market_price);
            $("#cost").text(data.goods_price);
            $("#vip").text(data.vip_price);
            $("#desc").text(data.goods_desc);
            $("#goodpic").attr("href",data.goods_img);
            $("#goodpic img").attr("src",data.goods_img);
            $("#added").text(data.goods_create_time);
            $("#goodsnumbering").text(data.goods_numbering);
        });
        var cid=$(this).attr("data-cid");
        $.get("/goodcate/"+cid,function(data,status){
            $("#cat").text(data.cat_name);
        });
        $.get("/getStock",{gid:id},function(data,status){
            $("#stock").empty();
            var dl;
            for(var i=0;i<data.length;i++){
                dl="<dl class='dl-horizontal'>  <dd>"+data[i].region_num+"</dd> </dl>";
                $("#stock").append(dl);
            }
        });
        var gid=$(this).attr("data-gid");
        $.get("/commodity/"+gid,function(data,status){
            $("#good").text(data.title);
        });
    });

    /*
    * 页面初始化时候将分类加载进来
    * */
    //加载一级分类
    var opt;
    var one0=0;
    $.get("/getlevel",{pid:one0},function(data,status){
        for(var i=0;i<data.length;i++){
            opt="<option  value="+data[i].cat_id+">"+data[i].cat_name+"</option>";
            $("#mainselect").append(opt);
        }
    });

    $(".edit").click(function(){
        $("#goodscat").empty();
        $("#midselect").empty();
        var cid=$(this).attr("data-cid").trim().split(" ");
        var id=$(this).attr("data-id");
        var gid=$(this).attr("data-gid");
        var sid=$("#sid").val();
        var opt;
        var opts;
        var firstPid;
        var opt;
        var one0=0;
        $("#updateform").attr("action","/good/"+id);
        $("#gid").val(id);
        for(var c=0;c<cid.length;c++){

            opts='<div class="form-group"><label class="col-sm-2 control-label">商品分类</label><div class="col-sm-10"><div class="row"><div class="col-xs-4"><select class="form-control" id="mainselect'+c+'" name="mainselect'+c+'"></select></div><div class="col-xs-4"><select class="form-control" id="midselect'+c+'" name="midselect'+c+'"></select></div></div></div></div>';

            $("#goodscat").append(opts);
            $.get("/newgetlevel",{pid:one0,id:c},function(data,status){
                for(var i=0;i<data.datas.length;i++){
                    opt="<option  value="+data.datas[i].cat_id+">"+data.datas[i].cat_name+"</option>";
                    $("#mainselect"+data.cnum).append(opt);
                }
            });
            $.get("/newgetsiblingscat",{cid:cid[c],id:c},function(data,status){
                for(var i=0;i<data.datas.length;i++){
                    opt="<option  value="+data.datas[i].cat_id+">"+data.datas[i].cat_name+"</option>";
                    $("#midselect"+data.cnum).append(opt);
                }
                $("#midselect"+data.cnum+" option[value="+data.cid+"]").attr("selected",true);
                $("#mainselect"+data.cnum+" option[value="+data.parent_id+"]").attr("selected",true);
            });
        }



        $("#name").empty();
        $.get("/getsibilingscommodity",{pid:cid[1],sid:sid},function(data,status,c){
            for(var i=0;i<data.length;i++){
                opt="<option  value="+data[i].goods_id+">"+data[i].title+"</option>";
                $("#name").append(opt);
            }
            $("#name option[value="+gid+"]").attr("selected",true);
        });

        $.get("/good/"+id+"/edit",function(data,status){
            $("#spetag").val(data.goods_name);
            $("#marketprice").val(data.market_price);
            $("#costprice").val(data.goods_price);
            $("#viprice").val(data.vip_price);
            $("#description").val(data.goods_desc);
            if(data.goods_create_time=="0000-00-00 00:00:00"){
                $("#notonsale").attr("checked",true);
            }else{
                $("#onsale").attr("checked",true);
            }
            $("#numbering").val(data.goods_numbering);
        });

        $.get("/getStock",{gid:id},function(data,status) {
            $("#stocktr").empty();
            var line;
            for(var k=0;k<data.length;k++){
                line='<tr class="line"> <td><input type="text" class="location form-control" value="'+data[k].location+'"></td> <td> <input type="number" min="0" class="regionum form-control" value="'+data[k].region_num+'" /> </td> <td> <button type="button" class="addcuspro btn-sm btn-link" title="添加"> <span class="glyphicon glyphicon-plus"></span> </button> <button type="button" class="savestock btn-sm btn-link" data-id="'+data[k].stock_id+'" title="保存"> <span class="glyphicon glyphicon-save"></span> </button> <button type="button" class="delcuspro btn-sm btn-link" title="删除" data-id="'+data[k].stock_id+'"> <span class="glyphicon glyphicon-minus"></span> </button> </td> </tr>';
                $("#stocktr").append(line);
            }
        });

        $.get("/getgoodthumb",{gid:id},function(data,status) {
            $(".notem").remove();
            var gallery;
            for(var i=0;i<data.length;i++){
                if(i==0){
                    gallery='<li class="notem"> <div class="gallery text-center"> <img src="'+data[i].thumb_url+'" class="img"> </div> <input type="file" name="file" class="pic" data-id="'+data[i].tid+'" data-gid="'+data[i].gid+'" isfirst="first"> </li>';
                }else{
                    gallery='<li class="notem"> <div class="gallery text-center"> <img src="'+data[i].thumb_url+'" class="img"> </div> <input type="file" name="file" class="pic" data-id="'+data[i].tid+'" data-gid="'+data[i].gid+'"> </li>';
                }
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
    });

    $("body").on("click",'.addcuspro',function(){
        var len=$(".line").length;
        var line='<tr class="line"> <td> <input type="text" class="location form-control" /></td><td> <input type="number" min="0" class="regionum form-control" /> </td> <td> <button type="button" class="addcuspro btn-sm btn-link" title="添加"> <span class="glyphicon glyphicon-plus"></span> </button> <button type="button" class="savestock btn-sm btn-link" title="保存"> <span class="glyphicon glyphicon-save"></span> </button> <button type="button" class="delcuspro btn-sm btn-link" title="删除"> <span class="glyphicon glyphicon-minus"></span> </button> </td> </tr>';
        $("#stocktr").append(line);
    });

    $("body").on("click",'.savestock',function(){
        var regionum=$(this).parentsUntil("#stocktr").find(".regionum").val();
        var location=$(this).parentsUntil("#stocktr").find(".location").val();
        if(regionum==""){
            alert("库存数量不能为空！");
            $(this).parentsUntil("#stocktr").find(".regionum").focus();
        }else{
            var id=$(this).attr("data-id");
            var gid=$("#gid").val();
            $("#save").attr("id","");
            $(this).attr("id","save");
            $("#del").attr("id","");
            $(this).siblings(".delcuspro").attr("id","del");
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

    var nullopt="<option value=''>无数据，请重选上级分类</option>";
    var defaultopt="<option value=''>请选择</option>";
    $("body").on("change",'#mainselect',function(){
        var val=$(this).val();
        $("#midselect").empty();
        $("#midselect").append(defaultopt);
        $("#name").empty();
        $("#name").append(defaultopt);
        $.get("/getlevel",{pid:parseInt(val)},function(data,status){
            if(data.length==0){
                $("#midselect").append(nullopt);
            }else{
                for(var i=0;i<data.length;i++){
                    opt="<option  value="+data[i].cat_id+">"+data[i].cat_name+"</option>";
                    $("#midselect").append(opt);
                }
            }
        });
    });

    $("#midselect").change(function(){
        var val=$(this).val();
        var sid=$("#sid").val();
        $("#name").empty();
        $("#name").append(defaultopt);
        $.get("/getsibilingscommodity",{pid:parseInt(val),sid:sid},function(data,status){
            if(data.length==0){
                $("#name").empty();
                $("#name").append(nullopt);
            }else{
                for(var i=0;i<data.length;i++){
                    opt="<option  value="+data[i].goods_id+">"+data[i].title+"</option>";
                    $("#name").append(opt);
                }
            }
        });
    });

    $("body").on("click",'.gallery',function(){
        $(this).siblings(".pic").click();
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
        $("#advert-goodsname").text($(this).attr("data-name"));
        $("#advert-goodsnum").text($(this).attr("data-num"));
        $("#advert-goods_id").val($(this).attr("data-gid"));
        $("#advert-gid").val($(this).attr("data-id"));
    });
//点击删除
    $(".goods_del").click(function(){
        //货品ID
        gid=$(this).attr("data-id");
        //商品ID
        goods_id=$(this).attr("data-gid");
        if(confirm('确认要删除吗？')){
            $.ajax({
                url: "/goods/goodsdel",
                type:'POST',
                data:{action:2,gid:gid,goods_id:goods_id},
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

//商城轮播图
    $(".newgoodspic31").change(function(){
        var goods_id=$("#advert-goods_id").attr("value");
        var gid=$("#advert-gid").attr("value");
        $("#formToUpdate31").ajaxSubmit({
            type: 'post',
            url: '/advert/addpic',
            data:{adid:5,goods_id:goods_id,gid:gid},
            success: function (data) {
                alert('商城轮播图1'+data.message);
                if(data.isSuccess==true){
                    $(".img31").attr("src", data.url);
                }
            }
        });
    });
    $(".newgoodspic32").change(function(){
        var goods_id=$("#advert-goods_id").attr("value");
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
        var goods_id=$("#advert-goods_id").attr("value");
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
        var goods_id=$("#advert-goods_id").attr("value");
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
        var goods_id=$("#advert-goods_id").attr("value");
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
        var goods_id=$("#advert-goods_id").attr("value");
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
        var goods_id=$("#advert-goods_id").attr("value");
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
        var goods_id=$("#advert-goods_id").attr("value");
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
        var goods_id=$("#advert-goods_id").attr("value");
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
        var goods_id=$("#advert-goods_id").attr("value");
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
        var goods_id=$("#advert-goods_id").attr("value");
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
        var goods_id=$("#advert-goods_id").attr("value");
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
        var goods_id=$("#advert-goods_id").attr("value");
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
        var goods_id=$("#advert-goods_id").attr("value");
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
        var goods_id=$("#advert-goods_id").attr("value");
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
        var goods_id=$("#advert-goods_id").attr("value");
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
        var goods_id=$("#advert-goods_id").attr("value");
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
        var goods_id=$("#advert-goods_id").attr("value");
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
        var goods_id=$("#advert-goods_id").attr("value");
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
        var goods_id=$("#advert-goods_id").attr("value");
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
        var goods_id=$("#advert-goods_id").attr("value");
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
        var goods_id=$("#advert-goods_id").attr("value");
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
        var goods_id=$("#advert-goods_id").attr("value");
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
