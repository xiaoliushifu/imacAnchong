<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>安虫资讯-{{$information->title}}</title>
    <link rel="stylesheet" type="text/css" href="{{url('../home/css/information.css')}}"/>
    <script src="/home/js/jquery-3.1.0.js"></script>
    <link rel="stylesheet" href="../home/css/top.css">
    <script src="../home/js/top.js"></script>
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
        <div class="middle-top" style="margin-top: 20px">
            {!! $information->content !!}
        </div>
    </div>
</div>
@include('inc.home.site-foot')
</body>
</html>