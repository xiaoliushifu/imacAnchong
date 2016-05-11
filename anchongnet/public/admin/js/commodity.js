/**
 * Created by lengxue on 2016/4/26.
 */
$(function(){
    //加载一级分类
    var opt;
    var one0=0;
    $.get("/getlevel",{pid:one0},function(data,status){
        for(var i=0;i<data.length;i++){
            opt="<option  value="+data[i].cat_id+">"+data[i].cat_name+"</option>";
            $("#mainselect").append(opt);
        }
    });

    //查看下属货品
    $(".view").click(function(){
        var gid=$(this).attr("data-id");
        var tr;
        $.get("/getsiblingsgood",{good:gid},function(data,status){
            for(var i=0;i<data.length;i++){
                tr='<tr><td align="center">'+data[i].goods_name+'</td><td align="center">'+data[i].goods_numbering+'</td><td align="center"><img src='+data[i].goods_img+' width="50"></td></tr>';
                $("#viewtable").append(tr);
            }
        })
    });

    $(".edit").click(function(){
        $("#midselect").empty();
        $("#stock").empty();
        var cid=$(this).attr("data-tid");
        var id=$(this).attr("data-id");
        var opt;
        var firstPid;
        $("#gid").val($(this).attr("data-id"));
        $.get("/getsiblingscat",{cid:cid},function(data,status){
            for(var i=0;i<data.length;i++){
                opt="<option  value="+data[i].cat_id+">"+data[i].cat_name+"</option>";
                $("#midselect").append(opt);
            }
            firstPid=data[0].parent_id;
            $("#midselect option[value="+cid+"]").attr("selected",true);
            $("#mainselect option[value="+firstPid+"]").attr("selected",true);
        });

        var id=$(this).attr("data-id");
        $("#updataForm").attr("action","/commodity/"+id);
        $.get("/commodity/"+id+"/edit",function(data,status){
            $("#title").val(data.title);
            $("#description").val(data.desc);
        });

        /*----获取商品属性信息----*/
        var line;
        $.get('/getsiblingsattr',{gid:id},function(data,status){
            for(var i=0;i<data.length;i++){
                line='<tr class="line"> <td> <input type="text" class="attrname form-control" value="'+data[i].name+'" /> </td> <td><textarea rows="5" class="attrvalue form-control">'+data[i].value+'</textarea> </td> <td> <button type="button" class="addcuspro btn-sm btn-link" title="添加"> <span class="glyphicon glyphicon-plus"></span> </button> <button type="button" class="savestock btn-sm btn-link" data-id="'+data[i].atid+'" title="保存"> <span class="glyphicon glyphicon-save"></span> </button> <button type="button" class="delcuspro btn-sm btn-link" title="删除" data-id="'+data[i].atid+'"> <span class="glyphicon glyphicon-minus"></span> </button> </td> </tr>';
                $("#stock").append(line);
            }
        });

        $("body").on("click",'.addcuspro',function(){
            var len=$(".line").length;
            var line='<tr class="line"> <td> <input type="text" class="attrname form-control" /> </td> <td><textarea rows="5" class="attrvalue form-control" required></textarea> </td> <td> <button type="button" class="addcuspro btn-sm btn-link" title="添加"> <span class="glyphicon glyphicon-plus"></span> </button> <button type="button" class="savestock btn-sm btn-link" title="保存"> <span class="glyphicon glyphicon-save"></span> </button> <button type="button" class="delcuspro btn-sm btn-link" title="删除"> <span class="glyphicon glyphicon-minus"></span> </button> </td> </tr>';
            $("#stock").append(line);
        });

        $("body").on("click",'.savestock',function(){
            var aname=$(this).parentsUntil("#stock").find(".attrname").val();
            var avalue=$(this).parentsUntil("#stock").find(".attrvalue").val();
            if(aname==""){
                alert("属性名不能为空！");
                $(this).parentsUntil("#stock").find(".attrname").focus();
            }else if(avalue==""){
                alert("属性值不能为空！");
                $(this).parentsUntil("#stock").find(".attrvalue").focus();
            }else{
                var id=$(this).attr("data-id");
                var gid=$("#gid").val();
                $("#save").attr("id","");
                $(this).attr("id","save");
                $("#del").attr("id","");
                $(this).siblings(".delcuspro").attr("id","del");
                if(id==undefined){
                    $.ajax({
                        url: "/attr",
                        type:'POST',
                        data:{gid:gid,name:aname,value:avalue},
                        success:function( response ){
                            alert(response.message);
                            $("#save").attr("data-id",response.id);
                            $("#del").attr("data-id",response.id);
                        }
                    });
                }else{
                    $.ajax({
                        url: "/attr/"+id,
                        type:'PUT',
                        data:{gid:gid,name:aname,value:avalue},
                        success:function( response ){
                            alert(response.message);
                        }
                    });
                }
            }
        });

        $("body").on("click",'.delcuspro',function(){
            if(confirm("你确定要删除该条属性信息吗？")){
                var id=$(this).attr("data-id");
                $(this).parents(".line").addClass("waitfordel");
                $.ajax({
                    url: "/attr/"+id,
                    type:'DELETE',
                    success:function(result){
                        alert(result);
                        $(".waitfordel").remove();
                    }
                });
            }
        });

        /*----获取商品图片----*/
        $.get("/getgoodimg",{gid:id},function(data,status) {
            $(".notem").remove();
            var gallery;
            for(var i=0;i<data.length;i++){
                switch(parseInt(data[i].type)){
                    case 1:
                        gallery='<li class="notem"> <div class="gallery text-center"> <img src="'+data[i].url+'" class="img"> </div> <input type="file" name="file" class="pic" data-id="'+data[i].iid+'" data-type="'+data[i].type+'"> </li>';
                        $("#addfordetail").before(gallery);
                        break;
                    case 2:
                        gallery='<li class="notem"> <div class="gallery text-center"> <img src="'+data[i].url+'" class="img"> </div> <input type="file" name="file" class="pic" data-id="'+data[i].iid+'" data-type="'+data[i].type+'"> </li>';
                        $("#addforparam").before(gallery);
                        break;
                    case 3:
                        gallery='<li class="notem"> <div class="gallery text-center"> <img src="'+data[i].url+'" class="img"> </div> <input type="file" name="file" class="pic" data-id="'+data[i].iid+'" data-type="'+data[i].type+'"> </li>';
                        $("#addfordata").before(gallery);
                        break;
                    default:
                }
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

    var nullopt="<option value=''>无数据，请重选上级分类</option>";
    $("body").on("change",'#mainselect',function(){
        var val=$(this).val();
        $("#midselect").empty();
        $("#backselect").empty();
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

    /*----删除图片----*/
    $("body").on("click",'.delpic',function(){
        if(confirm('确定要删除该张图片吗？')){
            var id=$(this).siblings('.pic').attr("data-id");
            $.ajax({
                url: '/img/'+id,
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
        $(this).before($(this).siblings(".template").clone().attr("class",""));
    });

    /*----事件转移----*/
    $("body").on("click",'.gallery',function(){
        $(this).siblings(".pic").click();
    });

    /*----添加或替换图片的操作----*/
    $("body").on("change",'.pic',function(){
        var id=$(this).attr("data-id");
        var gid=$("#gid").val();
        var imgtype=$(this).attr("data-type");
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
                    url: '/img',
                    data:{gid:gid,imgtype:imgtype},
                    success: function (data) {
                        alert(data.message);
                        if(data.isSuccess==true){
                            $(".isEdit").attr("src", objUrl);
                            $(".isAdd").attr("data-id",data.id);
                        }
                    },
                });
            }
        }else{
            var method='<input type="hidden" name="_method" value="PUT">';
            $("#method").append(method);
            if(confirm('你确定要替换这张图片吗？')){
                var objUrl = getObjectURL(this.files[0]) ;
                if (objUrl) {
                    $(".isEdit").removeClass("isEdit");
                    $(this).siblings(".gallery").find(".img").addClass("isEdit");
                    $("#formToUpdate").ajaxSubmit({
                        type:'post',
                        url:'/img/'+id,
                        data:{imgtype:imgtype},
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
});
