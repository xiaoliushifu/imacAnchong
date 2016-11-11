@extends('inc.home.pcenter.pcenter')
@section('info')
    <title>发包工程</title>
    <link rel="stylesheet" type="text/css" href="home/css/contractwork.css">
    @endsection
@section('publish')
    <div class="publish" style="position: absolute;top: 5px;right: 0px;">
        <a href="{{url('project/create')}}"><img src="home/images/pcenter/publish.jpg" alt=""></a>
    </div>
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
                        <li><a href="{{url('/continuepro')}}" class="inactive active">承接工程</a></li>
                        <li><a href="{{url('/pubtalent')}}" class="inactive active">发布人才</a></li>
                        <li><a href="{{url('/mypublish')}}" class="inactive active">人才自荐</a></li>
                        <li><a href="{{url('fngoods')}}" class="inactive active">找货</a></li>

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
                <li><a href="{{url('conwork')}}" style="color: #1DABD8;font-size: 20px;
                font-weight: bold;">发包工程</a></li>
                <li><a href="{{url('/continuepro')}}">承接工程</a></li>
                <li><a href="{{url('/pubtalent')}}">发布人才</a></li>
                <li><a href="{{url('/mypublish')}}">人才自荐</a></li>
                <li><a href="{{url('fngoods')}}">找货</a></li>

            </ul>
        </div>
        @foreach($pubwork as $p)
        <div class="centermain">
            <div class="center-left">
                <h3><a href="{{url('project/'.$p->bid)}}">{{$p->title}}</a></h3>
                <nobr><p>{{$p->content}}</p></nobr>
            </div>
            <div class="center-right">
                <a href="{{url('project/'.$p->bid)}}"><img src="{{$p->img}}" alt=""></a>
            </div>
            <div style="clear: both"></div>
            <hr>
        </div>
        @endforeach


        <div class="text-center" style="margin-top: 30px;">  {{$pubwork->links()}}</div>



    </div>


    </div>
<div style="clear: both"></div>


<script type="text/javascript" src="home/js/navleft.js"></script>
@endsection
