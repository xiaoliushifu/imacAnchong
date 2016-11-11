@if(Auth::check())
    <div class="nav-top">
        <div class="centerbar">
            <div class="topindex"><a href="{{url('/')}}">安虫首页</a></div>
            <div class="navmain">
                <ul >
                    <li>邮箱：www@anchong.net</li>
                    @if(isset($page))
                    {!! $page !!}
                    @endif
                    <li>垂询电话:0317-8155026</li>
                    <li><img src="{{$msg->headpic}}" alt=""></li>
                    <li style="padding-left: 10px; position: relative;"><a href="#">{{$msg->nickname}}<b class="caret" id="ss"></b></a>
                        <ul id="hh" class="topdown" >
                            <li><a href="{{url('pcenter')}}">个人中心</a></li>
                            <li><a href="{{url('/pcenter/basics')}}">修改资料</a></li>
                            <li><a href="{{url('/quit')}}">退出登录</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    @else
<<<<<<< HEAD
=======
<?php var_dump($msg); ?>
>>>>>>> a391325163857820c606a8e3d4a3804122f27925
<div class="site-top">
    <div class="top-container">
        <div class="topindex"><a href="{{url('/')}}">安虫首页</a></div>
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