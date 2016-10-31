$(function () {
    $(".bds_more").css({
        "height":"18px",
        "line-height":"18px",
        "margin":"0",
        "backgroundImage":"url(http://www.anchong.net/home/images/chat/share.png)"
    });
    $(".emotion").qqFace({
        assign:'comments', //给输入框赋值
        path:'../home/org/qqface/face/'    //表情图片存放的路径
    });
    $('.emotions').qqFace({
        assign:'replay',
        path:'../home/org/qqface/face/'
    });
    $(".comments").click(function(){
        if( $(".publish-comment").css("display") == "none"){
            $(".publish-comment").css("display","block");
            $(".publish-replay").css("display","none");
        }
    });
    //提交回复评论数据
    $(".send-replay").click(function(){
       $.ajax({
           url:"/replay",
           type:"POST",
           data:$(".publish-replay").serialize(),
           success:function (data) {
               layer.alert(data.msg, {offset: ['150px', '821px']});
               setTimeout("location.href=location.href",3000);
           },
           error:function(){
               layer.alert("暂时无法评论，请稍后再试", {offset: ['150px', '821px']});
           }
       })
    });
})
//评论主题
function Comments() {
    $.ajax({
        url:"/community",//提交地址
        type:"POST",//提交方式
        data:$('.publish-comment').serialize(),//提交数据
        success: function(msg) {
            layer.alert(msg.msg, {offset: ['150px', '821px']});
            setTimeout("location.href=location.href",3000);
        },
        error:function () {
            layer.alert("发表评论失败，请稍后再试", {offset: ['150px', '821px']});
        }
    })
}
//回复评论操作
function Replay(obj) {
    var element = $(obj).parent("div").children().first();
    var comid    = $(obj).parent().parent("li").find(".comid").text();//获取对应的comid
    $("#comid").attr("value",comid);//给form表单中的comid赋值
    var name    = element.attr("class");//获取评论哪个用户名
    var comname = "";
    if( name == "username"){
        comname = element.text();
        $("#append").text("回复"+comname);//append 显示:回复comane
        $("#comname").attr("value",comname);//赋值comname
        $(".publish-replay").css('display','block');//评论主题关闭
        $(".publish-comment").css('display',"none");//评论回复开启
    }else{
        comname = element.children().first().text();
        $("#append").text("回复"+comname);
        $("#comname").attr("value",comname);
        $(".publish-replay").css('display','block');
        $(".publish-comment").css('display',"none");
    }
}