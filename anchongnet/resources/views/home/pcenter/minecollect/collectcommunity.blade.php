@extends('inc.home.pcenter.pcenter')
@section('info')
    <title>社区</title>
    <link rel="stylesheet" type="text/css" href="home/css/collectcommunity.css">

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
                <li><a href="{{url('/colshop')}}">商铺</a></li>
                <li><a href="{{url('/colcommunity')}}" style="font-weight: bold;color: #1DACD8;">社区</a></li>
            </ul>
        </div>
        <ul class="chat-info">
            @foreach($community as $value)
                <li class="chat-item">
                    <ul class="chat-show">
                        <li class="userinfo">
                            <p><img class="portrait" src="{{$value ->  headpic}}"></p>
                            <p class="name">{{$value -> name}}</p>
                            <p class="date">
                                <i class="day">{{date("d",strtotime($value -> created_at))}}/</i>
                                <i class="month">{{date("m",strtotime($value -> created_at))}}</i>
                            </p>
                        </li>
                        <li class="chat-content">
                            <a href="{{url('/community/'.$value -> chat_id)}}">
                                <h3 class="chat-title">{{$value -> title}}</h3>
                                <p class="content">{{$value -> content}}</p>
                            </a>
                            <p class="comments-share">
                                <a class="comments" href="{{url('/community/'.$value -> chat_id).'/#comments'}}"><img src="home/images/chat/talk.png">{{$num[$value-> chat_id]}}</a>
                            </p>
                            <div style="clear: both"></div>
                        </li>
                    </ul>
                </li>
            @endforeach
        </ul>
        <div class="pages">
            <ul class="page-select">
                {!! $community -> links() !!}
            </ul>
            <ul class="page-skip">
                <i>共有{{$community -> lastpage()}}页，</i>
                <i class="blank">
                    去第
                    <input name="page" class="page-num" onchange="changePage(this)" type="text" value="{{$community->currentPage()}}">
                    页
                </i>
                <a class="page-btn" href="{{$community->url($community->currentPage())}}">确定</a>
            </ul>
            <div class="cl"></div>
        </div>
    </div>
<div style="clear: both"></div>
<script type="text/javascript" src="home/js/navleft.js"></script>
<script>
    function changePage(obj) {
        var num = $(obj).val();
        if((/^(\+|-)?\d+$/.test(num))&&num>0&&num<={{$community->lastpage()}}){
            $('.page-btn').attr('href','http://www.anchong.net/colcommunity?page='+num);
        }else{
            alert('请输入数字大于0并小于等于{{$community->lastpage()}}');
            $('.page-num').val({{$community->currentPage()}});
        }
    }
    $(function () {
        $('.page-num').keypress(function (e) {
            if ((/^(\+|-)?\d+$/.test(num))&&num>0&&num<={{$community->lastpage()}}&&e.keyCode == 13) {
                location.href = 'http://www.anchong.net/colcommunity?page='+ $(this).val();
            }
        });
    })
</script>
@endsection
