<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>资讯</title>
    <link rel="stylesheet" type="text/css" href="home/css/information.css"/>
    <script src="home/js/jquery-3.1.0.js"></script>
    <script src="home/org/layer/layer.js"></script>
    <link rel="stylesheet" href="home/css/top.css">
    <script src="home/js/top.js"></script>
</head>
<body>
@include('inc.home.top')
<div class="header">
    <div class="header-container">
        <div class="logo">
            <a href="{{url('/')}}"><img src="{{url('/home/images/logo.jpg')}}"/></a>
        </div>
        <div class="search">
            <form class="search-form">
                <input type="text" name="search" class="search-text"/>
                <input value="搜索" class="search-btn"/>
            </form>
        </div>
        <div class="cl"></div>
        <div class="site-nav">
            <ul class="navigation">
                <li class="home nav-item"><a href="{{url('/')}}">首页</a></li>
                <li class="business nav-item">
                    <a href="{{url('/business')}}">商机</a>
                    <span class="business-triangle"></span>
                    <div class="business-list">
                        <p><a href="">工程</a></p>
                        <p><a href="">人才</a></p>
                        <p><a href="">找货</a></p>
                    </div>
                </li>
                <li class="community nav-item"><a href="{{url('/community')}}">社区</a></li>
                <li class="equipment nav-item"><a href="{{url('/equipment')}}">设备选购</a></li>
                <li class="news nav-item"><a href="{{url('/info')}}">资讯</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="site-middle">
    <div class="middle-content">
        <ul class="middle-top">
            <li class="carousel">
                <div class="banner">
                    <img src="home/images/info/01.png">
                </div>
            </li>
            <li class="share">
                <ul>
                    <li class="share-title">
                        <h2>干货分享</h2>
                        <i>More</i>
                        <a id="upload"><img src="home/images/info/upload.png"></a>
                        @if(!Auth::check())
                        		<script>
                                $(function () {
                                    $('#upload').click(function () {
                                        layer.msg('请您登陆后再上传文档',{icon:6});
                                    })
                                })
                            </script>
                        {{--未认证--}}
                        @elseif($infoauth==1)
                            <script>
                                $(function () {
                                    $('#upload').click(function () {
                                        layer.msg('请您认证后再上传文档',{icon:6});
                                    })
                                })
                            </script>
                        @else
                            <script>
                                $(function () {
                                    $('#upload').attr("href","{{url('/info/create')}}")
                                })
                            </script>
                        @endif
                    </li>
                    <span class="parting"></span>
                    @foreach($upfiles as $k=>$v) 
                    <li class="share-item">
                        <a  class="download"  href="{{$v->filename}}"><img src="home/images/info/download.png"></a>
                        <a class="preview"  href="{{$v->filename}}" target="blank"><img src="home/images/info/preview.png"></a>
                        {{substr($v->filename,strrpos($v->filename,'/')+1)}}
                    </li>
                    @endforeach
                </ul>
            </li>
        </ul>
        <div class="information-content">
            <h2>资讯</h2>
            <span class="parting-line"></span>
            <ul>
                <li>
                    <ul class="info-nav">
                        <li class="rank">
                            <a class="order">排序</a>
                            <a class="hot-order"> 热门排序</a>
                        </li>
                        <li class="paging">
                            <a class="pageup" href="{{$info->previousPageUrl()}}"><img src="home/images/pageup.png"></a>
                            <a class="pagedown" href="{{$info->nextPageUrl()}}"><img src="home/images/pagedown.png"></a>
                        </li>
                    </ul>
                </li>
                @foreach($info as $v)
                <li class="info-item">
                    <ul>
                        <a href="{{url('/info/'.$v->infor_id)}}">
                        <li class="info-desc">
                            <h3>{{$v-> title}}</h3>
                            <p><?php
                                    $str = strip_tags($v->content);
                                    $str1 = mb_substr($str,mb_strlen($v->title)+20,100,'utf-8');
                                    echo $str1;
                                ?></p>
                        </li>
                        <li>
                            <img src="{{$v-> img}}">
                        </li>
                        </a>
                        <span class="info-parting"></span>
                    </ul>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="pages">
            {!! $info->links() !!}
            <ul class="page-skip">
                <i>共有{{$info->lastpage()}}页，</i>
                    <i class="blank">
                    去第
                        <input name="page" class="page-num" onchange="changePage(this)" type="number" value="{{$info->currentPage()}}">
                    页
                    </i>
                <a class="page-btn" href="{{$info->url($info->currentPage())}}">确定</a>
            </ul>
            <div class="cl"></div>
    </div>
    </div>
</div>
@include('inc.home.site-foot')
</body>
<script>
{{--获取用户输入的页数，然后更改‘确定’按钮的a标签的链接--}}
function changePage(obj) {
    var num = $(obj).val();
    {{--验证输入合法性--}}
    if ((/^(\+|-)?\d+$/.test(num)) && num>0 && num<={{$info->lastpage()}}) {
        $('.page-btn').attr('href',location.origin+'/info?page='+num);
    }else{
        layer.alert('请输入数字大于0并小于等于{{$info->lastpage()}}');
        $('.page-num').val({{$info->currentPage()}});
    }
}
    
$(function () {
	{{--回车键--}}
    $('.page-skip').on('keypress','.page-num',function (e) {
        if (e.keyCode == 13) {
            location.href = location.origin+'/info?page='+ $(this).val();
        }
    });
    {{--干货绑定下载 暂时注释
    $('.share-item').on('click','.download',function(){
    	  	var form=$("<form style='display:none'></form>");//定义一个form表单
    	  	form.attr("action","/getpic");
    	  	var input1=$("<input>");
    	  	input1.attr("name","filename"),input1.attr("value",$(this).parent().text().trim());
    	  	$("body").append(form);//将表单放置在web中
    	  	form.append(input1);//将input放到表单中
    	  	form.submit();//用代码形式把表单提交（非传统的在页面点击type="submit"按钮的方式） 
    	  	form.remove();
    	  	return false;
    }); --}}
});
</script>
</html>