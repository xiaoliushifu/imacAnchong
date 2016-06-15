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
                dl="<dl class='dl-horizontal'> <dt>"+data[i].region+"</dt> <dd>"+data[i].region_num+"</dd> </dl>";
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
        $("#midselect").empty();
        var cid=$(this).attr("data-cid").trim().split(" ");
        var id=$(this).attr("data-id");
        var gid=$(this).attr("data-gid");
        var sid=$("#sid").val();
        var opt;
        var opts;
        var firstPid;

        $("#updateform").attr("action","/good/"+id);
        $("#gid").val(id);
        for(var c=0;c<cid.length;c++){
            alert(String.fromCharCode(cid[c]));
            $.get("/getsiblingscat",{cid:cid[c]},function(data,status){
                for(var i=0;i<data.length;i++){
                    opt="<option  value="+data[i].cat_id+">"+data[i].cat_name+"</option>";
                    opts='<label class="col-sm-2 control-label">商品分类</label><div class="col-sm-10"><div class="row"><div class="col-xs-4"><select class="form-control" id="mainselect" name="mainselect" required></select></div><div class="col-xs-4"><select class="form-control" id="midselect" name="midselect" required></select><input type="hidden" name="midhidden" id="midhidden" value=""></div></div></div>';
                    $("#goodscat").append(opts);
                    $("#midselect").append(opt);
                }
                $("#midselect option[value="+cid[c]+"]").attr("selected",true);
                $("#midhidden").val(cid[c]);
                firstPid=data[0].parent_id;
                $("#mainselect option[value="+firstPid+"]").attr("selected",true);
            });
        }

        $("#name").empty();
        $.get("/getsibilingscommodity",{pid:cid[1],sid:sid},function(data,status){
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
                line='<tr class="line"> <td> <input type="text" class="region form-control" value="'+data[k].region+'" /> </td> <td><input type="text" class="location form-control" value="'+data[k].location+'"></td> <td><input type="text" class="shelf form-control" value="'+data[k].shelf+'"> </td> <td> <input type="number" min="0" class="regionum form-control" value="'+data[k].region_num+'" /> </td> <td> <button type="button" class="addcuspro btn-sm btn-link" title="添加"> <span class="glyphicon glyphicon-plus"></span> </button> <button type="button" class="savestock btn-sm btn-link" data-id="'+data[k].stock_id+'" title="保存"> <span class="glyphicon glyphicon-save"></span> </button> <button type="button" class="delcuspro btn-sm btn-link" title="删除" data-id="'+data[k].stock_id+'"> <span class="glyphicon glyphicon-minus"></span> </button> </td> </tr>';
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
        var line='<tr class="line"> <td> <input type="text" class="region form-control" /> </td> <td> <input type="text" class="location form-control" /></td><td><input type="text" class="shelf form-control"></td> <td> <input type="number" min="0" class="regionum form-control" /> </td> <td> <button type="button" class="addcuspro btn-sm btn-link" title="添加"> <span class="glyphicon glyphicon-plus"></span> </button> <button type="button" class="savestock btn-sm btn-link" title="保存"> <span class="glyphicon glyphicon-save"></span> </button> <button type="button" class="delcuspro btn-sm btn-link" title="删除"> <span class="glyphicon glyphicon-minus"></span> </button> </td> </tr>';
        $("#stocktr").append(line);
    });

    $("body").on("click",'.savestock',function(){
        var region=$(this).parentsUntil("#stocktr").find(".region").val();
        var regionum=$(this).parentsUntil("#stocktr").find(".regionum").val();
        var location=$(this).parentsUntil("#stocktr").find(".location").val();
        var shelf=$(this).parentsUntil("#stocktr").find(".shelf").val();
        if(region==""){
            alert("库存区域不能为空！");
            $(this).parentsUntil("#stocktr").find(".region").focus();
        }else if(regionum==""){
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
                    data:{gid:gid,region:region,location:location,shelf:shelf,regionum:regionum},
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
                    data:{gid:gid,region:region,location:location,shelf:shelf,regionum:regionum},
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
});
