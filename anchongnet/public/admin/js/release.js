/**
 * Created by lengxue on 2016/6/6.
 */
$(function(){
    //异步编辑发布
    $(".edit").click(function(){
    		var tmp ='';
        //获取社区ID
        var id=$(this).attr("data-id");
        var children=$(this).parents('tr').children();
        //先将编辑的div清空
        $("#imgcontent").empty();
        //赋值社区ID
        $('#chat_id').val(id);
        //组装表单的提交地址
        $("#updateform").attr("action","/release/"+id);
        $("#title").val(children.eq(0).text());
        $('#content').val(children.eq(1).text());
        var imgstr = children.eq(4).text();
        var imgs = imgstr.split('#@#');
        //获取社区图片
        if(imgs[0]){
            $('#imgdata').val(imgstr);
            //判断有多少图片
            for(var b = 0; b < imgs.length; b++){
            		if (imgs[b]) {
            			tmp='<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdates'+b+'" method="post" enctype="multipart/form-data"><div id="method"><input type="hidden" name="_method" value="PUT"></div><div class="gallery text-center"><img src="'+imgs[b]+'" style="height:100px;width:100px;" class="imgcontent'+b+'"></div><input type="file" name="file" class="newupdateimgs'+b+'"></form></td>';
            			$("#imgcontent").append(tmp);
            		}
            }
        }
    });
    
    //删除发布
    $(".del").click(function(){
        if(confirm("确定要删除此聊聊吗？")){
            var o=$(this);
            var id=o.attr("data-id");
            $.ajax({
                url: '/release/'+id,
                type:'DELETE',
                success:function(result){
                		console.log(result);
                    if (result.indexOf('成功') != -1){
                    		alert(result);
                    		o.parents('tr').remove();
                    }
                }
            });
        }
    });
    //最多六张图片跟上面获取图片是生成的图片div一一对应
    //更新图片1
    $("body").on('change','.newupdateimgs0',function(){
        //获取图片数据
        var img=$("#imgdata").attr("value");
        //获取图片ID
        var id=$("#chat_id").attr("value");
        //进行表单提交
        $("#formToUpdates0").ajaxSubmit({
            type: 'post',
            url: '/releaseimg/0',
            data:{chat_id:id,img:img},
            //假如成功将当前html的图片改为上传的图片
            success: function (data) {
                alert('第一张图片'+data.message);
                if(data.isSuccess==true){
                    $(".imgcontent0").attr("src", data.url);
                    $('#imgdata').val(data.imgs);
                }
            }
        });
    });
    //更新图片2
    $("body").on('change','.newupdateimgs1',function(){
        //获取图片数据
        var img=$("#imgdata").attr("value");
        //获取图片ID
        var id=$("#chat_id").attr("value");
        $("#formToUpdates1").ajaxSubmit({
            type: 'post',
            url: '/releaseimg/1',
            data:{chat_id:id,img:img},
            success: function (data) {
                alert('第二张图片'+data.message);
                if(data.isSuccess==true){
                    $(".imgcontent1").attr("src", data.url);
                    $('#imgdata').val(data.imgs);
                }
            }
        });
    });
    //更新图片3
    $("body").on('change','.newupdateimgs2',function(){
        //获取图片数据
        var img=$("#imgdata").attr("value");
        //获取图片ID
        var id=$("#chat_id").attr("value");
        $("#formToUpdates2").ajaxSubmit({
            type: 'post',
            url: '/releaseimg/2',
            data:{chat_id:id,img:img},
            success: function (data) {
                alert('第三张图片'+data.message);
                if(data.isSuccess==true){
                    $(".imgcontent2").attr("src", data.url);
                    $('#imgdata').val(data.imgs);
                }
            }
        });
    });
    //更新图片4
    $("body").on('change','.newupdateimgs3',function(){
        //获取图片数据
        var img=$("#imgdata").attr("value");
        //获取图片ID
        var id=$("#chat_id").attr("value");
        $("#formToUpdates3").ajaxSubmit({
            type: 'post',
            url: '/releaseimg/3',
            data:{chat_id:id,img:img},
            success: function (data) {
                alert('第四张图片'+data.message);
                if(data.isSuccess==true){
                    $(".imgcontent3").attr("src", data.url);
                    $('#imgdata').val(data.imgs);
                }
            }
        });
    });
    //更新图片5
    $("body").on('change','.newupdateimgs4',function(){
        //获取图片数据
        var img=$("#imgdata").attr("value");
        //获取图片ID
        var id=$("#chat_id").attr("value");
        $("#formToUpdates4").ajaxSubmit({
            type: 'post',
            url: '/releaseimg/4',
            data:{chat_id:id,img:img},
            success: function (data) {
                alert('第五张图片'+data.message);
                if(data.isSuccess==true){
                    $(".imgcontent4").attr("src", data.url);
                    $('#imgdata').val(data.imgs);
                }
            }
        });
    });
    //更新图片6
    $("body").on('change','.newupdateimgs5',function(){
        //获取图片数据
        var img=$("#imgdata").attr("value");
        //获取图片ID
        var id=$("#chat_id").attr("value");
        $("#formToUpdates5").ajaxSubmit({
            type: 'post',
            url: '/releaseimg/5',
            data:{chat_id:id,img:img},
            success: function (data) {
                alert('第六张图片'+data.message);
                if(data.isSuccess==true){
                    $(".imgcontent5").attr("src", data.url);
                    $('#imgdata').val(data.imgs);
                }
            }
        });
    });
});
