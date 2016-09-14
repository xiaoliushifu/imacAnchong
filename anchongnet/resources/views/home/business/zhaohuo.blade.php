<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>找货</title>
    <link rel="stylesheet" href="home/css/zhaohuo.css">
    <script src="/home/js/jquery-3.1.0.min.js"></script>
    <script src="home/js/businessjs.js"></script>
    <link rel="stylesheet" href="home/css/businessjs.css">

</head>
<body>
<div class="nav-top">
    <div class="centerbar">

        <div class="navmain">
            <ul>
                <li>邮箱：www.@anchong.net</li>
                <li>垂询电话:0317-8155026</li>
                <li><img src="home/images/zhaohuo/6.jpg" alt=""></li>
                <li style="padding-left: 10px;"><a href="#">风信子<b class="caret"></b></a></li>
            </ul>
        </div>
    </div>
</div>
<div class="header-center">
    <div class="header-main">
        <div class="logo">
            <a href="{{url('/')}}"><img src="home/images/zhaohuo/7.jpg" alt=""></a>
        </div>
        <div class="search">
            <div class="searchbar">
                <input type="text" class="biaodan">
                <button type="button" class="btn">搜索</button>

            </div>
            <div class="searchbar-list">
                <span>热门搜索:</span><a href="#">探测监控</a><a href="#">防护保障</a><a href="#">探测监控</a><a href="#">探测报警</a><a href="#">弱电工程</a>

            </div>
        </div>

    </div>
</div>
<div class="nav">
    <div class="navc">
        <div class="navcontent">
            <ul>
                <li><a href="{{url('/')}}">首页</a></li>
                <li><a href="{{url('/business')}}">商机</a><img src="home/images/zhaohuo/9.jpg" alt="" class="buslist"></li>
                <div class="cart">
                    <p><a href="{{url('/gc')}}">工程</a></p>
                    <p><a href="{{url('/sergoods')}}">找货</a></p>
                    <p><a href="{{url('/talentlist')}}">人才</a></p>
                </div>
                <li><a href="{{url('/community')}}">社区</a><img src="home/images/zhaohuo/9.jpg" alt="" class="buslist1"></li>
                <div class="cart1">
                    <p><a href="{{url('/gc')}}">工程</a></p>
                    <p><a href="{{url('/sergoods')}}">找货</a></p>
                    <p><a href="{{url('/talentlist')}}">人才</a></p>
                </div>
                <li><a href="{{url('/ancself')}}">设备选购</a><img src="home/images/zhaohuo/9.jpg" alt="" style="right: 15px;" class="buslist2"></li>
                <div class="cart2">
                    <p><a href="{{url('/ancself')}}">安虫自营</a></p>
                    <p><a href="{{url('/thirdshop')}}">第三方商城</a></p>
                    <p><a href="{{url('/goodslist')}}">商品列表</a></p>

                </div>
                <li><a href="{{url('/info')}}">资讯</a></li>
            </ul>
        </div>
        <div class="publish">
            <a href="{{url('/fngoods')}}"><img src="home/images/zhaohuo/8.jpg" alt=""></a>
        </div>
    </div>

</div>
<div style="clear: both"></div>
<hr class="nav-underline">

<div class="content">
    <div class="content-center">
        <div class="subnav">
            <div class="order">
                <a href="#">排序</a>
                <a href="#">热门排序</a>
            </div>
            <div class="partpage">
                &lt;<a href="#">下一页</a>
                <a href="#">上一页</a>&gt;
            </div>
        </div>
        <hr>
        @foreach($data as $z)
<div class="main">
    <div class="main-title">
        <h4><a href="#">{{$z->title}}</a></h4>
        <p>{{$z->content}}</p>
    </div>
    <div class="main-content"><img src="{{$z->img}}" alt=""></div>
</div>
        <hr>
@endforeach


<div class="paging" >
    {{$data->links()}}
    <div class="paging-right">
        <span>共有{{$data->lastPage()}}页，去第 <input type="text"></span> <button type="button">确定</button>
    </div>
</div>




    </div>
</div>

@include('inc.home.footer')





</body>
</html>