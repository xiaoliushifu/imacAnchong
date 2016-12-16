$(function () {
    $(".bds_more").css({
        "height":"18px",
        "line-height":"18px",
        "margin":"0",
        "backgroundImage":"url(http://www.anchong.net/home/images/chat/share.png)"
    });
    /**
     * 编写评论时去加载表情包
     */
//    $(".emotion").qqFace({
//        assign:'comments', //点击某个表情图片时，把它加载到id=comments的文本框
//        path:'/home/org/qqface/face/'    //服务端表情图片存放的路径
//    });
    /**
     * 编写回复时去加载表情包
     */
//    $('.emotions').qqFace({
//        assign:'replay',
//        path:'/home/org/qqface/face/'
//    });
    
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
           beforeSend:function(xhr){
   				if($('#replay').val().length<5){
   					layer.alert('既然写了就多来点吧!', {offset: ['150px', '821px']});
   					return false;
   				}
           },
           success:function (data) {
               //layer.alert(data.msg, {offset: ['150px', '821px']});
               $('p.comid:contains('+$('#comid').val()+')').parents('li.comments-replay').append('<div><p class="dialogue"><i class="rpname">'+$('input[name="name"]').val()+'</i>回复<i class="comname">'+$('input[name="comname"]').val()+'</i>:'+$('#replay').val()+'</p><a class="replay" onclick="Replay(this)" href="#replay">回复</a></div>');
               $('#replay').val('');
           },
           error:function(){
               layer.alert("暂时无法评论，请稍后再试", {offset: ['150px', '821px']});
           }
       })
    });
})
//提交评论
function Comments() {
    $.ajax({
        url:"/community",//提交地址
        type:"POST",//提交方式
        data:$('.publish-comment').serialize(),//提交数据
        beforeSend:function(xhr){
    			if($('#comments').val().length<5){
    				layer.alert('既然写了就多来点吧!', {offset: ['150px', '821px']});
    				return false;
    			}
        },
        success: function(msg) {
            //layer.alert(msg.msg, {offset: ['150px', '821px']});
            $clone = $('#ulmodel').clone(true).show();
            $clone.find('img').attr('src',$('form.publish-comment').find('input[name="headpic"]').val());//headpic
            $clone.find('p.username').text($('form.publish-comment').find('input[name="name"]').val());
            $clone.find('p.comments-time').text($('form.publish-comment').find('input[name="created_at"]').val().split(' ')[0]);
            $clone.find('p.comments-info').text($('#comments').val());
            $clone.find('p.comid').text(msg.status);
            //$clone.find('span.parting').next().remove();
            $('li.comments-show').append($clone);
            $('#comments').val('');
        },
        error:function () {
            layer.alert("发表评论失败，请稍后再试", {offset: ['150px', '821px']});
        }
    });
}

//回复评论准备
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