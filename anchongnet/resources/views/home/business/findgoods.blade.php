<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>找货</title>
    <link rel="stylesheet" href="home/css/zhaohuo.css">
    <link rel="stylesheet" href="home/css/businessjs.css">
    <link rel="stylesheet" href="home/css/top.css">
</head>
<body>
@include('inc.home.top')
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
                <li><a href="{{url('/business')}}">商机</a><img src="home/images/zhaohuo/9.jpg" alt="" class="buslist">
                    <div class="cart">
                        <p><a href="{{url('/project')}}">工程</a></p>
                        <p><a href="{{url('/sergoods')}}">找货</a></p>
                        <p><a href="{{url('/talent')}}">人才</a></p>
                    </div>
                </li>

                <li><a href="{{url('/community')}}">社区</a>

                </li>

                <li><a href="{{url('/equipment')}}">设备选购</a>

                </li>

                <li><a href="{{url('/info')}}">资讯</a></li>
            </ul>
        </div>
        <div class="publish">
            <a href="
            @if(isset($msg))
            {{url('/sergoods/create')}}
                    @else
            {{url('/user/login')}}
                    @endif
                    "><img src="home/images/zhaohuo/8.jpg" alt=""></a>
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
        @foreach($fglist as $z)
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
    {{$fglist->links()}}
    <div class="paging-right">
        <form action="{{url('gopage/fgpage')}}" method="post">
            {{csrf_field()}}
        <span>共有{{$fglist->lastPage()}}页，去第 <input type="text" name="page"></span> <button type="submit">确定</button>
        </form>
    </div>
</div>




    </div>
</div>

@include('inc.home.footer')
<script src="/home/js/jquery-3.1.0.min.js"></script>
<script src="home/js/businessjs.js"></script>
<script src="home/js/top.js"></script>

</body>
</html>