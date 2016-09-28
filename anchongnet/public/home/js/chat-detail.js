/**
 * Created by Administrator on 2016/9/26.
 */
$(function () {
    window._bd_share_config = {
        common : {
            bdText : $('.content').text(),
            bdDesc : '{{$info -> title}}',
            bdUrl : ''
        },
        share : [{
            "bdSize" : 16
        }],
    }
    with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?cdnversion='+~(-new Date()/36e5)];
    $(".bds_more").css({
        "height":"18px",
        "line-height":"18px",
        "margin":"0",
        "backgroundImage":"url(http://www.anchong.net/home/images/chat/share.png)"
    });
    $(".emotion").qqFace({
        assign:'comments', //给输入框赋值
        path:'../home/org/qqface/face/'    //表情图片存放的路径
    })
    $(".send").click(function(){
        var str = $("#comments").val();
        $("comments-item").html(replace_em(str));
    });
})
//替换成表情
function replace_em(str){
    str = str.replace(/</g,'<；');
    str = str.replace(/>/g,'>；');
    str = str.replace(/ /g,'<；br/>；');
    str = str.replace(/[em_([0-9]*)]/g,'<img src="../home/org/qqface/face/$1.gif" border="0" />');
    return str;
}
