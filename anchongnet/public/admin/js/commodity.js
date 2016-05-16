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
            $(".mainselect").append(opt);
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

    $(".edit").click(function() {
        $("#midselect").empty();
        $("#stock").empty();
        var id = $(this).attr("data-id");

        var opt;
        var firstPid;
        $("#gid").val($(this).attr("data-id"));

        $("#updataForm").attr("action", "/commodity/" + id);
        $.get("/commodity/" + id + "/edit", function (data, status) {
            var arr=$.trim(data.type).split(" ");
            $("#catarea").empty();
            for(var i=0;i<arr.length;i++){
                var cat=$(".catemplate").clone().removeClass("hidden").removeClass("catemplate");
                $("#catarea").append(cat);
                $("#flag").val(arr[i]);
                $.ajax({
                    type : "GET",
                    url : '/getsiblingscat?s='+new Date().getTime(),
                    data:{cid:arr[i]},
                    async:false,
                    cache :false,
                    success : function(data){
                        for (var j = 0; j < data.length; j++) {
                            opt = "<option  value=" + data[j].cat_id + ">" + data[j].cat_name + "</option>";
                            $(".midselect").eq(i+1).append(opt);
                        };
                        firstPid = data[0].parent_id;
                        var val=$("#flag").val();
                        $(".midselect").eq(i+1).find("option[value="+val+"]").attr("selected",true);
                        $(".mainselect").eq(i+1).find("option[value="+firstPid+"]").attr("selected",true);
                    }
                });
            };

            $("#title").val(data.title);
            $("#description").val(data.desc);
            $("#remark").text(data.remark);
            $("#keyword").val(data.keyword);
            $("#img").attr("src",data.images);
            UE.getEditor('container').setContent(data.param);
            UE.getEditor('container1').setContent(data.package);
        });

        /*----添加分类----*/
        $("body").on("click",".add button",function(){
            var tem=$(".catemplate").clone().removeClass("hidden").removeClass("catemplate");
            $("#catarea").append(tem);
        });

        /*----删除分类----*/
        $("body").on("click",".minus button",function(){
            var len=$("#catarea").find(".form-group").length;
            if(len==1){
                alert("不能删除仅有的分类信息！");
            }else{
                $(this).parentsUntil("#catarea").remove();
            }
        });

        /*----获取商品属性信息----*/
        var line;
        $.get('/getsiblingsattr', {gid: id}, function (data, status) {
            for (var i = 0; i < data.length; i++) {
                line = '<tr class="line"> <td> <input type="text" class="attrname form-control" value="' + data[i].name + '" /> </td> <td><textarea rows="5" class="attrvalue form-control">' + data[i].value + '</textarea> </td> <td> <button type="button" class="addcuspro btn-sm btn-link" title="添加"> <span class="glyphicon glyphicon-plus"></span> </button> <button type="button" class="savestock btn-sm btn-link" data-id="' + data[i].atid + '" title="保存"> <span class="glyphicon glyphicon-save"></span> </button> <button type="button" class="delcuspro btn-sm btn-link" title="删除" data-id="' + data[i].atid + '"> <span class="glyphicon glyphicon-minus"></span> </button> </td> </tr>';
                $("#stock").append(line);
            }
        });

        $("body").on("click", '.addcuspro', function () {
            var len = $(".line").length;
            var line = '<tr class="line"> <td> <input type="text" class="attrname form-control" /> </td> <td><textarea rows="5" class="attrvalue form-control" required></textarea> </td> <td> <button type="button" class="addcuspro btn-sm btn-link" title="添加"> <span class="glyphicon glyphicon-plus"></span> </button> <button type="button" class="savestock btn-sm btn-link" title="保存"> <span class="glyphicon glyphicon-save"></span> </button> <button type="button" class="delcuspro btn-sm btn-link" title="删除"> <span class="glyphicon glyphicon-minus"></span> </button> </td> </tr>';
            $("#stock").append(line);
        });

        $("body").on("click", '.savestock', function () {
            var aname = $(this).parentsUntil("#stock").find(".attrname").val();
            var avalue = $(this).parentsUntil("#stock").find(".attrvalue").val();
            if (aname == "") {
                alert("属性名不能为空！");
                $(this).parentsUntil("#stock").find(".attrname").focus();
            } else if (avalue == "") {
                alert("属性值不能为空！");
                $(this).parentsUntil("#stock").find(".attrvalue").focus();
            } else {
                var id = $(this).attr("data-id");
                var gid = $("#gid").val();
                $("#save").attr("id", "");
                $(this).attr("id", "save");
                $("#del").attr("id", "");
                $(this).siblings(".delcuspro").attr("id", "del");
                if (id == undefined) {
                    $.ajax({
                        url: "/attr",
                        type: 'POST',
                        data: {gid: gid, name: aname, value: avalue},
                        success: function (response) {
                            alert(response.message);
                            $("#save").attr("data-id", response.id);
                            $("#del").attr("data-id", response.id);
                        }
                    });
                } else {
                    $.ajax({
                        url: "/attr/" + id,
                        type: 'PUT',
                        data: {gid: gid, name: aname, value: avalue},
                        success: function (response) {
                            alert(response.message);
                        }
                    });
                }
            }
        });

        $("body").on("click", '.delcuspro', function () {
            if (confirm("你确定要删除该条属性信息吗？")) {
                var id = $(this).attr("data-id");
                $(this).parents(".line").addClass("waitfordel");
                $.ajax({
                    url: "/attr/" + id,
                    type: 'DELETE',
                    success: function (result) {
                        alert(result);
                        $(".waitfordel").remove();
                    }
                });
            }
        });
    });

    var nullopt="<option value=''>无数据，请重选上级分类</option>";
    var defaultopt="<option value=''>请选择</option>";
    $("body").on("change",".mainselect",function(){
        var val=$(this).val();
        $(".waitforopt").removeClass("waitforopt");
        $(this).parent().siblings("div").find(".midselect").empty().addClass("waitforopt");
        $(this).parent().siblings("div").find(".midselect").append(defaultopt);
        if(val==""){
        }else{
            $.get("/getlevel",{pid:parseInt(val)},function(data,status){
                if(data.length==0){
                    $(".waitforopt").find(".midselect").empty();
                    $(".waitforopt").append(nullopt);
                }else{
                    for(var i=0;i<data.length;i++){
                        opt="<option  value="+data[i].cat_id+">"+data[i].cat_name+"</option>";
                        $(".waitforopt").append(opt);
                    }
                }
            });
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

    /*----事件转移----*/
    $("body").on("click",'.gallery',function(){
        $(this).siblings(".pic").click();
    });

    /*----替换详情图片的操作----*/
    $("body").on("change",'.pic',function(){
        var gid=$("#gid").val();
        if(confirm('你确定要替换这张图片吗？')){
            var objUrl = getObjectURL(this.files[0]) ;
            if (objUrl) {
                $(".isEdit").removeClass("isEdit");
                $(this).siblings(".gallery").find(".img").addClass("isEdit");
                $("#formToUpdate").ajaxSubmit({
                    type:'post',
                    url:'/updataimg',
                    data:{gid:gid},
                    success:function(data){
                        alert(data.message);
                        if(data.isSuccess==true){
                            $(".isEdit").attr("src",objUrl);
                        }
                    },
                });
            }
        }
    });
});
