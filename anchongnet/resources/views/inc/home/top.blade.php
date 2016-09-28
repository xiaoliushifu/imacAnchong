
@if(isset($msg))
    <div class="nav-top">
        <div class="centerbar">
            <div class="topindex"><a href="{{url('/')}}">安虫首页</a></div>
            <div class="navmain">
                <ul >
                    <li>邮箱：www.@anchong.net</li>
                    @if(isset($page))
                    {!! $page !!}
                    @endif
                    <li>垂询电话:0317-8155026</li>
                    <li><img src="{{$msg->headpic}}" alt=""></li>
                    <li style="padding-left: 10px; position: relative;"><a href="#">{{$msg->nickname}}<b class="caret" id="ss"></b></a></li>
                </ul>
                <ul id="hh" class="topdown" >
                    <li><a href="#">买卖情况</a></li>
                    <li><a href="#">在线物流</a></li>
                    <li><a href="#">售后服务</a></li>
                </ul>

            </div>
        </div>
    </div>
    @else

<div class="site-top">
    <div class="top-container">
        <div class="topindex"><a href="">安虫首页</a></div>
        <ul class="info">
            <li class="mail">邮箱：<a href="mailto:www.anchong.net">www@anchong.net</a></li>
            <li class="tel">垂询电话：0317-8155026</li>
            <li>
                <a href="{{url('/user/login')}}">登陆</a>/<a href="{{url('/user/register')}}">注册</a>
            </li>
        </ul>
    </div>
</div>
@endif
<style>
    .nav-top{
        width: 100%;
        height: 40px;
        background: #F5F5F5;
    }
    .centerbar{
        width: 1200px;
        height: 40px;
        margin:0px auto;
        line-height: 40px;
    }
    .navmain {
        float: right;
    }
    .navmain li {
        display: inline;
        float: left;
        padding-left: 20px;
        font-size: 12px;
        color: #4a4a4a;
    }
    .navmain li a {
        color: #4a4a4a;
        text-decoration: none;
    }
    .navmain img{
        width: 20px;
        height:20px;
        border-radius: 50%;
        margin-top: 10px;
    }
    .topindex{
        width: 100px;
        height: 40px;
        float: left;
    }
    .topindex a{
        font-size: 13px;
        color: #4A4A4A;
        text-decoration: none;;
    }
    .topdown{
        display: none;
        width: 100px;
        height: 120px;
        background:#fff5d4;
        position: absolute;
        top:40px;right: 60px;
        text-align: center;
    }
    .topdown li{
        display:list-item;
        height: 30px;
        line-height: 30px;
        text-align: center;
    }
    .topdown li:hover{
     background: #e8e8e8;
    }
    .topdown li a{
        color: #606060;
        font-size: 14px;
    }
    .caret {
        display: inline-block;
        width: 0;
        height: 0;
        margin-left: 2px;
        vertical-align: middle;
        border-top: 4px dashed;
        border-top: 4px solid \9;
        border-right: 4px solid transparent;
        border-left: 4px solid transparent;
    }
    *{
        padding: 0;
        margin: 0;
        font-family: "微软雅黑","宋体",verdana;
    }
    a{
        text-decoration: none;
    }
    i{
        font-style: normal;
    }
    ul,li{
        list-style: none;
    }
    .site-top{
        width: 100%;
        background-color: #f5f5f5;
    }
    .top-container{
        width: 1220px;
        height: 40px;
        line-height: 40px;
        margin: 0 auto;
    }
    .info{
        margin-right: 10px;
        float: right;
    }
    .info li{
        float: left;
        font-size:12px;
        color: #606060;
        margin-right: 20px;
    }
    .info li a{
        color: #606060;
    }
</style>