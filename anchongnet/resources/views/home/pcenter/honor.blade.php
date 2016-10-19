@extends('inc.home.pcenter.pcenter')
@section('info')
    <title>资质认证</title>
    <link rel="stylesheet" type="text/css" href="home/css/honor.css">
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
                <li><a href="{{url('/applysp')}}">商铺申请</a></li>
                <hr>
                <li><a href="{{url('/honor')}}">会员认证</a></li>
                <hr>

            </ul>
        </div>
    </div>
    <div class="mainrg">
        <form action="{{url('honor/store')}}" method="post">
            {{csrf_field()}}
        <div class=" daomain">

           <h4>会员认证</h4>
        </div>
            <div class="detail">
                @if(session('message'))
                    <div style="color: #f53745;font-size: 14px;margin-left: 100px;">{{session('message')}}</div>
                @endif
                    @if(session('error'))
                        <div style="color: #f53745;font-size: 14px;margin-left: 100px;">{{session('error')}}</div>
                    @endif
                    @if(count($errors)>0)
                        <div class="mark" >
                            @if(is_object($errors))
                                @foreach($errors->all() as $error)
                                    <p style="padding-left: 100px;"> {{$error}}</p>
                                @endforeach
                            @else
                                <p>{{$errors}}</p>
                            @endif
                        </div>
                    @endif
                <div class="center-left">

                <li>
                    <span>公司名称：</span><input type="text" name="auth_name"  value="{{Input::old('auth_name')}}" placeholder="请输入公司名称或从业者姓名">
                </li>
                    <li>
                        <span>会员简介：</span><input type="text" name="explanation"  value="{{Input::old('explanation')}}" placeholder="请输入公司或从业者简介">
                    </li>
                    <li>
                    <span>证件名称：</span><input type="text" name="qua_name"  value="{{Input::old('qua_name')}}" placeholder="可填写多个">

                </li>
                   <div class="papers">
                       <span>上传证件：</span><div class="papers-title"><p>上传证件</p></div>
                   </div>
                </div>
             <div class="center-right">
                 <button>添加资质</button>
                 <button>编辑</button>
             </div>
            </div>
        <hr style="margin-left: 10px;">

            <div class="tijiao"><button type="submit">提交</button></div>
        </form>
        </div>

    </div>


    </div>
<div style="clear: both"></div>
@endsection