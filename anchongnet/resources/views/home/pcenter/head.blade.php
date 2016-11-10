@extends('inc.home.pcenter.pcenter')
@section('info')
    <title>头像上传</title>
    <link rel="stylesheet" type="text/css" href="home/css/head.css">
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
        <form action="" method="">
        <div class=" daomain">
            <h4><a href="{{url('/pcenter/basics')}}">基本资料</a></h4> <p><a href="{{url('/uphead')}}">头像上传</a></p>
        </div>
            <div class="detail">
               <div class="detail-left">
                   <div class="uploading">
                       <button type="button">本地上传</button>
                       <button type="button">拍照上传</button>
                       <p>仅支持jpg、png、gif格式的图片文件，且小于5M</p>
                   </div>
                   <div class="head">
                       <img src="home/images/mine/61.jpg" alt="">
                   </div>
               </div>
                <div class="detail-right">
                    <div class="headpic">
                        <h6>预览</h6>
                        <p>你上传的头像自动生成3种尺寸，</p>
                        <p>请注意小尺寸头像是否清晰</p>
                    </div>
                    <ul class="piclist">
                        <li class="big"><img src="home/images/mine/61.jpg" alt=""><p>160*160px</p></li>
                        <li class="mind"><img src="home/images/mine/61.jpg" alt=""><p>60*60px</p></li>
                        <li class="last"><img src="home/images/mine/61.jpg" alt=""><p>30*30px</p></li>
                    </ul>
                </div>
            </div>



            <div style="clear: both;"></div>
        <hr style="margin-left: 10px; margin-top: 60px;">

            <div class="tijiao"><button type="submit">保存</button></div>
        </form>
        </div>

    </div>


    </div>
<div style="clear: both"></div>
@endsection
