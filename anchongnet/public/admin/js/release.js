/**
 * Created by lengxue on 2016/6/6.
 */
$(function(){
    //异步编辑发布
    $(".edit").click(function(){
        var id=$(this).attr("data-id");
        $("#updateform").attr("action","/release/"+id);
        $("#cid").val(id);
        $.get("/release/"+id+"/edit",function(data,status){
            $("#title").val(data.title);
            $("#content").text(data.content);
        });

        //获取商机图片
        $.get("/relimg",{cid:id},function(data,status) {
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
                    url: '/addrelimg',
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
                        url:'/releaseimg/'+id,
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
                url: '/releaseimg/'+id,
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

    $("#save").click(function(){
        $("#updateform").ajaxSubmit({
            type: 'put',
            success: function (data) {
                alert(data);
                location.reload();
            },
        });
    });

    //删除发布
    $(".del").click(function(){
        if(confirm("确定要删除吗？")){
            var id=$(this).attr("data-id");
            $.ajax({
                url: '/release/'+id,
                type:'DELETE',
                success:function(result){
                    alert(result);
                    location.reload();
                }
            });
        }
    });
});