@extends('inc.home.pcenter.pcenter')
@section('info')
    <title>发包工程</title>
    <link rel="stylesheet" type="text/css" href="home/css/contractwork.css">
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
                <li><a href="javascript::" class="inactive">我的发布<b class="caret"></b></a>
                    <ul class="ttt" style="display: none">
                        <hr>
                        <li><a href="{{url('/conwork')}}" class="inactive active">发包工程</a></li>
                        <li><a href="" class="inactive active">承接工程</a></li>
                        <li><a href="{{url('/reorder')}}" class="inactive active">发布人才</a></li>
                        <li><a href="{{url('/orderlist')}}" class="inactive active">人才自荐</a></li>
                        <li><a href="#" class="inactive active">找货</a></li>

                    </ul>

                </li>
                <hr>
                <li><a href="javascript::" class="inactive">我的收藏<b class="caret"></b></a>
                    <ul class="ttt" style="display: none">
                        <hr>
                        <li><a href="{{url('/colgoods')}}" class="inactive active">商品</a></li>
                        <li class="last"><a href="{{url('/colshop')}}">商铺</a></li>
                        <li class="last"><a href="{{url('/colcommunity')}}">社区</a></li>
                    </ul>
                </li>
                <hr>
                <li><a href="javascript::" class="inactive">我的订单<b class="caret"></b></a>
                    <ul class="ttt" style="display: none">
                        <hr>
                        <li><a href="#" class="inactive active">美协机关</a>

                        </li>
                        <li><a href="#" class="inactive active">中国文联美术艺术中心</a>

                    </ul>

                </li>
                <hr>
                <li><a href="#">我的钱袋</a></li>
                <hr>
                <li><a href="#">虫虫粉丝</a></li>
                <hr>
                <li><a href="#">商铺申请</a></li>
                <hr>
                <li><a href="#">商家认证</a></li>
                <hr>

            </ul>
        </div>
    </div>
    <div class="mainrg">
        <div class=" daomain">
            <ul>
                <li><a href="#" style="color: #1DABD8;font-size: 20px;
                font-weight: bold;">发包工程</a></li>
                <li><a href="#">承接工程</a></li>
                <li><a href="#">发布人才</a></li>
                <li><a href="#">人才自荐</a></li>
                <li><a href="#">找货</a></li>


            </ul>
        </div>
        <div class="centermain">
            <div class="center-left">
                <h3><a href="">湖南常德万达广场建设安防系统招标</a></h3>
                <p>项目概况 项目所属行业房地产</p>
            </div>
            <div class="center-right">
                <img src="home/images/mine/31.jpg" alt="">
            </div>
            <div style="clear: both"></div>
            <hr>
        </div>
        <div class="centermain">
            <div class="center-left">
                <h3><a href="">湖南常德万达广场建设安防系统招标</a></h3>
                <p>项目概况 项目所属行业房地产</p>
            </div>
            <div class="center-right">
                <img src="home/images/mine/31.jpg" alt="">
            </div>
            <div style="clear: both"></div>
            <hr>
        </div>
        <div class="centermain">
            <div class="center-left">
                <h3><a href="">湖南常德万达广场建设安防系统招标</a></h3>
                <p>项目概况 项目所属行业房地产</p>
            </div>
            <div class="center-right">
                <img src="home/images/mine/31.jpg" alt="">
            </div>
            <div style="clear: both"></div>
            <hr>
        </div>
        <div class="centermain">
            <div class="center-left">
                <h3><a href="">湖南常德万达广场建设安防系统招标</a></h3>
                <p>项目概况 项目所属行业房地产</p>
            </div>
            <div class="center-right">
                <img src="home/images/mine/31.jpg" alt="">
            </div>
            <div style="clear: both"></div>
            <hr>
        </div>
        <div class="centermain">
            <div class="center-left">
                <h3><a href="">湖南常德万达广场建设安防系统招标</a></h3>
                <p>项目概况 项目所属行业房地产</p>
            </div>
            <div class="center-right">
                <img src="home/images/mine/31.jpg" alt="">
            </div>
            <div style="clear: both"></div>
            <hr>
        </div>




    </div>


    </div>
<div style="clear: both"></div>
<script type="text/javascript" src="home/js/navleft.js"></script>
@endsection
