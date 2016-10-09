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
                        <a href="{{url('/info/create')}}"><img src="home/images/info/upload.png"></a>
                    </li>
                    <span class="parting"></span>
                    <li class="share-item">
                        <a  class="download" href=""><img src="home/images/info/download.png"></a>
                        <a class="preview" href=""><img src="home/images/info/preview.png"></a>
                        《光线振动入侵探测器技术要求》标准下载
                    </li>
                    <li class="share-item">
                        <a class="download" href=""><img src="home/images/info/download.png"></a>
                        <a class="preview" href=""><img src="home/images/info/preview.png"></a>
                        监控摄像机常见知识及特性介绍（附PDF下载）
                    </li>
                    <li class="share-item">
                        <a class="download" href=""><img src="home/images/info/download.png"></a>
                        <a class="preview" href=""><img src="home/images/info/preview.png"></a>
                        降低大规模智能监控系统的建筑成本
                    </li>
                    <li class="share-item">
                        <a class="download" href=""><img src="home/images/info/download.png"></a>
                        <a class="preview" href=""><img src="home/images/info/preview.png"></a>
                        监控摄像机常见知识及特性介绍（附PDF下载）
                    </li>
                    <li class="share-item">
                        <a class="download" href=""><img src="home/images/info/download.png"></a>
                        <a class="preview" href=""><img src="home/images/info/preview.png"></a>
                        IP监控系统协议标准（附PDF下载）
                    </li>
                    <li class="share-item">
                        <a class="download" href=""><img src="home/images/info/download.png"></a>
                        <a class="preview" href=""><img src="home/images/info/preview.png"></a>
                        监控摄像机常见知识及特性介绍（附PDF下载）
                    </li>
                    <li class="share-item">
                        <a class="download" href=""><img src="home/images/info/download.png"></a>
                        <a class="preview" href=""><img src="home/images/info/preview.png"></a>
                        监控摄像机常见知识及特性介绍（附PDF下载）
                    </li>
                    <li class="share-item">
                        <a class="download" href=""><img src="home/images/info/download.png"></a>
                        <a class="preview" href=""><img src="home/images/info/preview.png"></a>
                        降低大规模智能监控系统的建筑成本
                    </li>
                    <li class="share-item">
                        <a class="download" href=""><img src="home/images/info/download.png"></a>
                        <a class="preview" href=""><img src="home/images/info/preview.png"></a>
                        监控摄像机常见知识及特性介绍（附PDF下载）
                    </li>
                    <li class="share-item">
                        <a class="download" href=""><img src="home/images/info/download.png"></a>
                        <a class="preview" href=""><img src="home/images/info/preview.png"></a>
                        IP监控系统协议标准（附PDF下载）
                    </li>
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
                        <input name="page" class="page-num" onchange="changePage(this)" type="text" value="{{$info->currentPage()}}">
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
    {{--获取用户输入的页数，然后更改a标签的链接--}}
    function changePage(obj) {
        var num = $(obj).val();
        if((/^(\+|-)?\d+$/.test(num))&&num>0&&num<={{$info->lastpage()}}){
            $('.page-btn').attr('href','http://www.anchong.net/info?page='+num);
        }else{
            layer.alert('请输入数字大于0并小于等于{{$info->lastpage()}}');
            $('.page-num').val({{$info->currentPage()}});
        }
    }
    $(function () {
        $('.page-num').keypress(function (e) {
            if (e.keyCode == 13) {
                location.href = 'http://www.anchong.net/info?page='+ $(this).val();
            }
        });
    })
</script>
</html>