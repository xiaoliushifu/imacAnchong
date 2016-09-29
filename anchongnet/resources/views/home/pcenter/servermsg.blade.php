@extends('inc.home.pcenter.pcenter')
@section('info')
    <title>服务消息</title>
    <link rel="stylesheet" type="text/css" href="home/css/servermsg.css">
    @endsection
@section('content')
<div class="main">
    <div class="mainlf">
        <div class="topll">
            <img src="{{$msg->headpic}}" alt="">
            <p>{{$msg->nickname}}</p>
            <p>QQ：{{$msg->qq}}</p>
            <p>邮箱：{{$msg->email}}</p>
        </div>
        <div class="toppp">
            <ul>
                <hr>
                <li><a href="#">服务消息</a></li>
                <hr>
                <li><a href="#">互动消息</a></li>
                <hr>
                <li><a href="#">活动消息</a></li>
                <hr>

            </ul>
        </div>
    </div>
    <div class="mainrg">
        <div class=" daomain">
           <h4>服务消息</h4>
        </div>
        <div class="msgcenter">
            <div class="msgcenterpic"><a href=""><img src="home/images/mine/34.jpg" alt=""></a></div>
            @foreach($serverm as $m)
            <div class="msgcentermain">
                <a href=""><h4>{{$m->title}}</h4></a>
                <p>{{$m->content}}</p>
            </div>
            @endforeach
              <div style="clear: both;"></div>
            <hr>
        </div>





    </div>


    </div>
<div style="clear: both"></div>
@endsection