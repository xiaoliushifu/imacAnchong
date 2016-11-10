@extends('inc.home.pcenter.pcenter')
@section('info')
    <title>基本资料</title>
    <link rel="stylesheet" type="text/css" href="/home/css/basics.css">
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
                <li><a href="{{url('/adress')}}">地址管理</a></li>
                <hr>
                <li><a href="{{url('applysp')}}">商铺申请</a></li>
                <hr>
                <li><a href="{{url('honor')}}">会员认证</a></li>
                <hr>
            </ul>
        </div>
    </div>
    <div class="mainrg">
        <form action="/pcenter/upbasic" method="post">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="daomain">
           <h4><a href="{{url('/pcenter/basics')}}">基本资料</a></h4> <p><a href="{{url('/uphead')}}">头像上传</a></p>
        </div>
            <div class="detail">
                <div class="papers">
                    <span>上传头像：</span><div class="papers-title" id="headpic"><img src="/home/images/mine/35.jpg" alt=""></div>
                </div>
                <li>
                    <span>昵称：</span><input type="text" name="nickname" placeholder="叶子" >
                </li>
                <li>
                    <span>用户姓名：</span><input type="text" name="contact" placeholder="xxx真实名字" >
                </li>
                <li>
                    <span>QQ：</span><input type="text" name="qq" placeholder="3562656">
                </li>
                <li>
                    <span>邮箱：</span><input type="text" name="email" placeholder="3562656@qq.com">
                </li>
                <!--  <div class="gender">
                		<span>性别：</span>
                    <input type="radio"  style="width:50px;height:16px"  checked name="sex"  value="1"/>男
                    <input type="radio"  style="width:50px;height:16px"  name="sex" value="2" />女
                </div>-->
                <div class="tip"><p>*昵称填写须知：与安虫业务或者卖家品牌冲突的昵称，安虫将有可能收回</p></div>
            </div>
            <div style="clear: both;"></div>
        <hr style="margin-left: 10px; margin-top: 60px;">
            <div class="tijiao"><button type="submit">更新</button></div>
        </form>
        </div>
    </div>
<script src="/home/js/diyUpload.js"></script>
<script src="/home/js/basic.js"></script>
<div style="clear: both"></div>
@endsection