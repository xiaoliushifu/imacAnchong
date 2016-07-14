/**
 * Created by lengxue on 2016/6/6.
 */
$(function(){
    //异步编辑发布
    $(".edit").click(function(){
        //获取社区ID
        var id=$(this).attr("data-id");
        //先将编辑的div清空
        $("#imgcontent").empty();
        //赋值社区ID
        $('#chat_id').val(id);
        //定义表单的提交地址
        $("#updateform").attr("action","/release/"+id);
        //ajax获取该社区的内容
        $.get("/release/"+id+"/edit",function(data,status){
            $("#title").val(data.title);
            $('#content').val(data.content);
        })

        //获取社区图片
        $.get("/community/imgshow/"+id,function(data,status){
            //判断是否有图片
            if(data[0]){
                //判断有多少图片
                for(var b=0;b < data.length;b++){
                    comtent='<td><input type="hidden" id="communityimgid'+b+'" value="'+data[b].id+'"><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdates'+b+'" method="post" enctype="multipart/form-data"><div id="method"><input type="hidden" name="_method" value="PUT"></div><div class="gallery text-center"><img src="'+data[b].img+'" style="height:100px;width:100px;" class="imgcontent'+b+'"></div><input type="file" name="file" class="newupdateimgs'+b+'"></form></td>';
                    $("#imgcontent").append(comtent);
                }
            }
        })
    });
    //编辑模块的保存
    $("#save").click(function(){
        $("#updateform").ajaxSubmit({
            //使用了restfulapi
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
    //最多六张图片跟上面获取图片是生成的图片div一一对应
    //更新图片1
    $("body").on('change','.newupdateimgs0',function(){
        //获取图片ID
        var id=$("#communityimgid0").attr("value");
        //进行表单提交
        $("#formToUpdates0").ajaxSubmit({
            type: 'post',
            url: '/releaseimg/'+id,
            data:{id:id},
            //假如成功将当前html的图片改为上传的图片
            success: function (data) {
                alert('第一张图片'+data.message);
                if(data.isSuccess==true){
                    $(".imgcontent0").attr("src", data.url);
                }
            }
        });
    });
    //更新图片2
    $("body").on('change','.newupdateimgs1',function(){
        var id=$("#communityimgid1").attr("value");
        $("#formToUpdates1").ajaxSubmit({
            type: 'post',
            url: '/releaseimg/'+id,
            data:{id:id},
            success: function (data) {
                alert('第二张图片'+data.message);
                if(data.isSuccess==true){
                    $(".imgcontent1").attr("src", data.url);
                }
            }
        });
    });
    //更新图片3
    $("body").on('change','.newupdateimgs2',function(){
        var id=$("#communityimgid2").attr("value");
        $("#formToUpdates2").ajaxSubmit({
            type: 'post',
            url: '/releaseimg/'+id,
            data:{id:id},
            success: function (data) {
                alert('第三张图片'+data.message);
                if(data.isSuccess==true){
                    $(".imgcontent2").attr("src", data.url);
                }
            }
        });
    });
    //更新图片4
    $("body").on('change','.newupdateimgs3',function(){
        var id=$("#communityimgid3").attr("value");
        $("#formToUpdates3").ajaxSubmit({
            type: 'post',
            url: '/releaseimg/'+id,
            data:{id:id},
            success: function (data) {
                alert('第四张图片'+data.message);
                if(data.isSuccess==true){
                    $(".imgcontent3").attr("src", data.url);
                }
            }
        });
    });
    //更新图片5
    $("body").on('change','.newupdateimgs4',function(){
        var id=$("#communityimgid4").attr("value");
        $("#formToUpdates4").ajaxSubmit({
            type: 'post',
            url: '/releaseimg/'+id,
            data:{id:id},
            success: function (data) {
                alert('第五张图片'+data.message);
                if(data.isSuccess==true){
                    $(".imgcontent4").attr("src", data.url);
                }
            }
        });
    });
    //更新图片6
    $("body").on('change','.newupdateimgs5',function(){
        var id=$("#communityimgid5").attr("value");
        $("#formToUpdates5").ajaxSubmit({
            type: 'post',
            url: '/releaseimg/'+id,
            data:{id:id},
            success: function (data) {
                alert('第六张图片'+data.message);
                if(data.isSuccess==true){
                    $(".imgcontent5").attr("src", data.url);
                }
            }
        });
    });
});
