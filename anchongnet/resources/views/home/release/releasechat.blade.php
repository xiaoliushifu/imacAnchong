<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>发布社区聊聊</title>
    <link rel="stylesheet" href="../home/css/releasechat.css">
    <script src="../home/js/jquery-3.1.0.min.js"></script>
    <link rel="stylesheet" href="{{asset('home/css/top.css')}}">
    <script src="{{asset('home/js/top.js')}}"></script>
</head>
<body>
@include('inc.home.top')
<div class="header-center">
    <div class="header-main">
        <div class="logo">
            <a href="{{url('/')}}"><img src="../home/images/release/7.jpg" alt=""></a>
        </div>
        <div class="search">
            <div class="searchbar">
                <input type="text" class="biaodan">
                <button type="button" class="btn">搜索</button>
            </div>
        </div>
    </div>
</div>
<div class="nav">
    <div class="navc">
        <div class="navcontent">
            <ul>
                <li><a href="/community">所有</a></li>
                <li><a href="/talk">闲聊</a></li>
                <li><a href="/question">问问</a></li>
                <li><a href="/activity">活动</a></li>
            </ul>
        </div>
    </div>
</div>
<div style="clear: both"></div>
<hr class="nav-underline">
<div class="centermain">
    <div class="submain">
        <form action="/chat" method="post">
        <input type="hidden" name="_token" value={{csrf_token()}}>
        <div class="adress">
            <h4> 标签：</h4>
            <input type="radio" name="tag" value="闲聊" checked style="width:30px"/>闲聊&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag" value="问问" style="width:30px" />问问&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag" value="活动" style="width:30px" />活动
        </div>
        <div class="main">
            <div class="main-left">
                    <table>
                        <tr>
                            <th class="centitle">标题:</th>
                            <td>
                                <input type="text" name="title">
                            </td>
                        </tr>
                        <tr>
                            <th class="cencontent">内容:</th>
                            <td>
                                <textarea  placeholder="输入详细内容" name="content"></textarea>
                            </td>
                        </tr>
                    </table>
            </div>
        </div>
            <div class="upload">
                <div class="upload-title"><h3>上传照片</h3></div><p>选择装修过程中的照片，每张低于5M,支持JPG/JPEG/PNG格式，最多6张</p>
                <div style="clear: both"></div>
                <hr>
            </div>
        <div class="upload-pic">
            <ul>
                <li><img src="../home/images/release/shch.png" alt=""></li>
                <li><img src="" alt=""></li>
                <li><img src="" alt=""></li>
                <li><img src="" alt=""></li>
            </ul>
        </div>
		<div class="publish"><input type="submit" value="发布" /></div>
        </form>
    </div>
</div>
@include('inc.home.footer')
</body>
</html>