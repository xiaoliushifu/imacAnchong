@extends('inc.home.pcenter.pcenter')
@section('info')
    <title>商铺</title>
    <link rel="stylesheet" type="text/css" href="home/css/collectshop.css">

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
                <li><a href="{{url('/colgoods')}}">商品</a></li>
                <li><a href="{{url('/colshop')}}" style="font-weight: bold;color:#1DACD8;">商铺</a></li>
                <li><a href="{{url('/colcommunity')}}">社区</a></li>


            </ul>
        </div>
    @foreach($shop as $s)
       <div class="conmm">
       <div class="conpp"> <a href="{{url('equipment/thirdshop/'.$s->sid)}}"><img src="{{$s->img}}" alt=""></a>
       </div>
       <div class="conww"><a href="{{url('equipment/thirdshop/'.$s->sid)}}"><p>{{$s->name}}</p></a></div>
</div>
    @endforeach

</div>
</div>
<div style="clear: both"></div>
<script type="text/javascript" src="home/js/navleft.js"></script>
@endsection
