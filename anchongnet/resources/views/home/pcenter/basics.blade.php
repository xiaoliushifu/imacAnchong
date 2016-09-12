@extends('inc.home.pcenter.pcenter')
@section('info')
    <title>基本资料</title>
    <link rel="stylesheet" type="text/css" href="home/css/basics.css">

@section('content')
<div class="main">
    <div class="mainlf">
        <div class="topll">
            <img src="home/images/mine/61.jpg" alt="">
            <p>风信子</p>
            <p>QQ：888888888888</p>
            <p>邮箱：88888888888@qq.com</p>
        </div>
        <div class="toppp">
            <ul>
                <hr>
                <li><a href="{{url('/adress')}}">地址管理</a></li>
                <hr>
                <li><a href="{{url('applysp')}}">商铺申请</a></li>
                <hr>
                <li><a href="{{url('honor')}}">商家认证</a></li>
                <hr>

            </ul>
        </div>
    </div>
    <div class="mainrg">
        <form action="" method="">
        <div class=" daomain">
           <h4><a href="{{url('/basics')}}">基本资料</a></h4> <p><a href="{{url('/uphead')}}">头像上传</a></p>
        </div>
            <div class="detail">
                <div class="papers">
                    <span>上传头像：</span><div class="papers-title"><img src="home/images/mine/35.jpg" alt=""></div>
                </div>
                <li>
                    <span>昵称：</span><input type="text"  placeholder="叶子" value="" >
                </li>
                    <li>
                        <span>用户姓名：</span><input type="text" placeholder="xxx真实名字" >
                    </li>
                <div class="gender">
                    <span>性别：</span>
                    <span> <img src="home/images/mine/check.png" alt="">男</span>
                    <span><img src="home/images/mine/checked.png" alt="">女</span>
                </div>
                    <li>
                    <span>QQ：</span><input type="text" placeholder="3562656">
                </li>
                <li>
                    <span>邮箱：</span><input type="text" placeholder="3562656@qq.com">
                </li>
                <div class="tip"><p>*昵称填写须知：与安虫业务或者卖家品牌冲突的昵称，安虫将有可能收回</p></div>
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