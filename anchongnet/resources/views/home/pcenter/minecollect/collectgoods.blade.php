@extends('inc.home.pcenter.pcenter')
@section('info')
    <title>商品</title>
    <link rel="stylesheet" type="text/css" href="home/css/collectgoods.css">

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
                <li><a href="javascript:" class="inactive">我的发布<b class="caret"></b></a>
                    <ul class="ttt" style="display: none">
                        <hr>
                        <li><a href="{{url('/conwork')}}" class="inactive active">发包工程</a></li>
                        <li><a href="{{url('/conwork')}}" class="inactive active">承接工程</a></li>
                        <li><a href="{{url('/reoder')}}" class="inactive active">发布人才</a></li>
                        <li><a href="{{url('/mypublish')}}" class="inactive active">人才自荐</a></li>
                        <li><a href="{{url('/fngoods')}}" class="inactive active">找货</a></li>

                    </ul>

                </li>
                <hr>
                <li><a href="javascript:" class="inactive">我的收藏<b class="caret"></b></a>
                    <ul class="ttt" style="display: none">
                        <hr>
                        <li><a href="{{url('/colgoods')}}" class="inactive active">商品</a></li>
                        <li class="last"><a href="{{url('/colshop')}}">商铺</a></li>
                        <li class="last"><a href="{{url('/colcommunity')}}">社区</a></li>
                    </ul>
                </li>
                <hr>
                <li><a href="javascript:" class="inactive">我的订单<b class="caret"></b></a>
                    <ul class="ttt" style="display: none">
                        <hr>
                        <li><a href="#" class="inactive active">未完成订单</a>

                        </li>
                        <li><a href="#" class="inactive active">已完成订单</a>

                    </ul>

                </li>
                <hr>
                <li><a href="#">我的钱袋</a></li>
                <hr>
                <li><a href="#">虫虫粉丝</a></li>
                <hr>
                <li><a href="{{url('/applysp')}}">商铺申请</a></li>
                <hr>
                <li><a href="{{url('/honor')}}">会员认证</a></li>
                <hr>

            </ul>
        </div>
    </div>
    <div class="mainrg">
        <div class=" daomain">
            <ul>
                <li><a href="{{url('/colgoods')}}"style="font-weight: bold;color: #1DACD8;">商品</a></li>
                <li><a href="{{url('/colshop')}}">商铺</a></li>
                <li><a href="{{url('/colcommunity')}}">社区</a></li>


            </ul>
        </div>
        <div class="contmain">

            <ul>
                @foreach($colg as $c)

                <li><a href="{{url('equipment/show/'.$c->goods_id.'/'.$c->gid)}}">
                    <img src="{{$c->pic}}" alt="">
                    <p><strong>{{$c->title}}</strong></p>
                </a>
                    <p style="font-size: 20px;color: #f53745;">￥{{$c->price}}</p>

                </li>
                @endforeach
            </ul>
        </div>

    </div>


    </div>
<div style="clear: both"></div>
<script type="text/javascript" src="home/js/navleft.js"></script>
@endsection
