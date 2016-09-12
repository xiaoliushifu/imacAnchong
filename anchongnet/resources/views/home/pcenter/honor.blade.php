@extends('inc.home.pcenter.pcenter')
@section('info')
    <title>资质认证</title>
    <link rel="stylesheet" type="text/css" href="home/css/honor.css">
    @endsection
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
                <li><a href="{{url('/applysp')}}">商铺申请</a></li>
                <hr>
                <li><a href="{{url('/honor')}}">商家认证</a></li>
                <hr>

            </ul>
        </div>
    </div>
    <div class="mainrg">
        <form action="" method="">
        <div class=" daomain">
           <h4>商家认证</h4>
        </div>
            <div class="detail">
                <div class="center-left">

                <li>
                    <span>公司名称：</span><input type="text" value="风信子" onfocus="javascript:if(this.value=='风信子')this.value='';">
                </li>
                    <li>
                        <span>会员简介：</span><input type="text" value="13888888888" onfocus="javascript:if(this.value=='13888888888')this.value='';">
                    </li>
                    <li>
                    <span>证件名称：</span><input type="text" value="北京市昌平区沙河镇"onfocus="javascript:if(this.value=='北京市昌平区沙河镇')this.value='';">

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