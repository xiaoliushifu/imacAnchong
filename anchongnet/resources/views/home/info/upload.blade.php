<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>上传干货</title>
    <link rel="stylesheet" type="text/css" href="{{asset('home/css/upload.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('home/osscallback/style.css')}}"/>
    <script src="/home/js/jquery-3.1.0.js"></script>
    <link rel="stylesheet" href="{{asset('home/css/top.css')}}">
    <script src="/home/js/top.js"></script>
</head>
<body>
@include('inc.home.top')
<div class="header">
    <div class="header-container">
        <div class="logo">
            <a href="{{url('/')}}"><img src="/home/images/logo.jpg"/></a>
        </div>
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
    <div class="middle-cont">
        <div class="middle-top">
            <i class="site-location">您的位置:</i>
            <i class="index">首页</i>
            <span class ="connector">></span>
            <i class="personal">资讯</i>
            <span class ="connector">></span>
            <i class="upload">上传干货</i>
        </div>
        <div class="upload-status">
            <img src="/home/images/info/uploading.png">
        </div>
        <div id="container">
	<a id="selectfiles" href="javascript:void(0);" class='btn'>选择文件</a>
	<a id="postfiles" href="javascript:void(0);" class='btn'>开始上传</a>
	</div>
        <div class="tips">
            <h3>温馨提示</h3>
            <p>1.你可以上传日常积累和撰写的文档资料，或者施工案例，支持多种文档类型：doc，docx，ppt，ppts，xls，xlsx，wps，PDF，txt。</p>
            <p>2.上传侵权内容的文档会被移除。</p>
            <p>3.为营造绿色的网络环境，严禁上传淫秽色情集低俗信息文档，让我们携手共同打造健康技术干货</p>
        </div>
        <div id="ossfile">你的浏览器不支持flash,Silverlight或者HTML5！</div>
    </div>
</div>
@include('inc.home.site-foot')
</body>
<script type="text/javascript" src="/home/osscallback/lib/plupload-2.1.2/js/plupload.full.min.js"></script>
<script type="text/javascript" src="/home/osscallback/upload.js"></script>
</html>