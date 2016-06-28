/**
 * Created by lengxue on 2016/6/8.
 */
$(function(){
    //页面加载的时候初始化标签选择下拉菜单的选项
    $.get('/getag',function(data,status){
        var opt;
        for(var i=0;i<data.length;i++){
            opt='<option value='+data[i].tag+'>'+data[i].tag+'</option>';
            $("#tag").append(opt);
        }
    });

    //查看商机详情
    $(".view").click(function(){
        var id=$(this).attr("data-id");
        $.get('/business/'+id,function(data,status){
            $("#bustitle").text(data.title);
            $("#vtitle").text(data.title);
            $("#vcontent").text(data.content);
            $("#vtag").text(data.tag);
            $("#vphone").text(data.phone);
            $("#vcontact").text(data.contact);
            $("#vtype").text(data.type);
            $("#vcreate").text(data.created_at);
            $("#vupdate").text(data.updated_at);
            $("#varea").text(data.tags);
            $("#vendtime").text(data.endtime);
        });

        $("#vimg").empty();
        $.get('/busimg',{'bid':id},function(data,status){
            var li;
            for(var i=0;i<data.length;i++){
                li='<li class="list-group-item"><a href='+data[i].img+' target="_blank"><img src='+data[i].img+' width="100"></a> </li>';
                $("#vimg").append(li);
            }
        });
    });

    $(".edit").click(function(){
        var id=$(this).attr("data-id");
        $("#updateform").attr("action",'/business/'+id);
        $("#bid").val(id);
        $.get('/business/'+id,function(data,status){
            $("#title").val(data.title);
            $("#content").val(data.content);
            $("#tag").find("option[value="+data.tag+"]").attr("selected",true);
            $("#contact").val(data.contact);
            $("#phone").val(data.phone);
            $("#etype").find("option[value="+data.type+"]").attr("selected",true);
            $("#area").val(data.tags);
            $("#endtime").val(data.endtime);
        });

        //获取商机图片
        $.get("/busimg",{bid:id},function(data,status) {
            $(".notem").remove();
            var gallery;
            for(var i=0;i<data.length;i++){
                gallery='<li class="notem"> <div class="gallery text-center"> <img src="'+data[i].img+'" class="img"> </div> <input type="file" name="file" class="pic" data-id="'+data[i].id+'"> </li>';
                $("#addforgood").before(gallery);
            }
            for(var j=0;j<($(".notem").length);j++){
                $(".notem").eq(j).prepend('<button type="button" class="delpic btn btn-xs btn-danger" title="删除">x</button>');
            }
        });
    });

    $("body").on("click",'.gallery',function(){
        $(this).siblings(".pic").click();
    });

    $("body").on("change",'.pic',function(){
        var id=$(this).attr("data-id");
        if(id==undefined){
            $("#method").empty();
            var objUrl = getObjectURL(this.files[0]) ;
            var filename=$(this).val();
            $(".isAdd").removeClass("isAdd");
            $(this).addClass("isAdd");
            if (objUrl) {
                $(".isEdit").removeClass("isEdit");
                $(this).siblings(".gallery").find(".img").addClass("isEdit");
                $(this).siblings(".gallery").before('<button type="button" class="delpic btn btn-xs btn-danger" title="删除">x</button>');
                $("#formToUpdate").ajaxSubmit({
                    type: 'post',
                    url: '/addbusimg',
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
                var filename=$(this).val();
                if (objUrl) {
                    $(".isEdit").removeClass("isEdit");
                    $(this).siblings(".gallery").find(".img").addClass("isEdit");
                    $("#formToUpdate").ajaxSubmit({
                        type:'post',
                        url:'/businessimg/'+id,
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
                url: '/businessimg/'+id,
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
            $(this).before($(this).siblings(".template").clone().attr("class",""));
        }else{
            $(this).before($(this).siblings(".template").clone().attr("class",""));
        }
    });

    $(".del").click(function(){
        if(confirm('确定要删除吗？')){
            var id=$(this).attr("data-id");
            $.ajax({
                url: "/business/"+id,
                type: 'DELETE',
                success: function(result) {
                    // Do something with the result
                    alert(result);
                    $.ajax({
                        url: "/delimg",
                        type: 'get',
                        data:{bid:id},
                        success: function(result) {
                        }
                    });
                    setTimeout(function(){location.reload()},500);
                }
            });
        }
    });
    //推广商机
    $(".advert").click(function(){
        //商机ID
        bid=$(this).attr("data-id");
        if(confirm('确定要推到热门招标项目吗？')){
            $.ajax({
                url: "/advert/businessadvert",
                type:'POST',
                data:{bid:bid,recommend:1},
                success:function( response ){
                    if(response.ServerNo == 0){
                        alert('推广成功');
                        location.reload();
                    }else{
                        alert('推广失败');
                    }
                }
            });
    	}
    });
    //推广商机
    $(".advertcancel").click(function(){
        //商机ID
        bid=$(this).attr("data-id");
        if(confirm('确定要取消推广吗？')){
            $.ajax({
                url: "/advert/businessadvert",
                type:'POST',
                data:{bid:bid,recommend:0},
                success:function( response ){
                    if(response.ServerNo == 0){
                        alert('取消成功');
                        location.reload();
                    }else{
                        alert('取消失败');
                    }
                }
            });
        }
    });
});
