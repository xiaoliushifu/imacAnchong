<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>人才列表</title>
    <link rel="stylesheet" href="home/css/rencailist.css">
    <script src="home/js/jquery-3.1.0.min.js"></script>


</head>
<body>
<div class="nav-top">
    <div class="centerbar">

        <div class="navmain">
            <ul >
                <li>邮箱：www.@anchong.net</li>
                <li>垂询电话:0317-8155026</li>
                <li><img src="home/images/zhaohuo/6.jpg" alt=""></li>
                <li style="padding-left: 10px; position: relative;"><a href="#">风信子<b class="caret" id="ss"></b></a></li>
            </ul>
            <ul id="hh" class="topdown" >
                <li><a href="#">买卖情况</a></li>
                <li><a href="#">在线物流</a></li>
                <li><a href="#">售后服务</a></li>
            </ul>

        </div>
    </div>
</div>
<div class="header-center" >
    <div class="header-main">
        <div class="logo">
            <img src="home/images/zhaohuo/7.jpg" alt="">
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
                <li><a href="#">商机<img src="home/images/zhaohuo/9.jpg" alt=""></a></li>
                <li><a href="#">社区<img src="home/images/zhaohuo/9.jpg" alt=""></a></li>
                <li><a href="#">设备选购<img src="home/images/zhaohuo/9.jpg" alt="" style="left: 70px;"></a></li>
                <li><a href="#">资讯</a></li>
            </ul>
        </div>

    </div>

</div>
<div style="clear: both"></div>
<hr class="nav-underline">

<!--中间内容、-->

<div class="main">
    <div class="submain">
        <div class="publish-title">
            <div class="publish-left">
                <a href="{{url('/reorder')}}">人才发布</a><a href="#">人才招聘</a>
            </div>
            <div class="publish-right">
                <a href="{{url('/reorder')}}"><img src="home/images/zhaohuo/36.jpg" alt=""></a>
            </div>
        </div>

        <div class="server">
            <hr>
            <ul class="server-type">
                <li class="type-title"><span>服务类别</span></li>
                <li><a href="#">探测监视</a></li>
                <li><a href="#">防护保障</a></li>
                <li><a href="#">探测报警</a></li>
                <li><a href="#">弱电工程</a></li>
                <li><a href="#">呼救器</a></li>
                <li><a href="#">楼宇对讲</a></li>
                <li><a href="#">快速通道</a></li>
                <li class="downmenue" style="width: 80px;height: 50px;float: right;font-size: 14px;color:#606060;"><span  id="flip" >展开 <b class="caret"></b></span> </li>
            </ul>
            <ul class="server-type" id="yy" style="display: none;">
                <li><a href="#">按时打算</a></li>
                <li><a href="#">探测监视</a></li>
                <li><a href="#">防护保障</a></li>
                <li><a href="#">探测报警</a></li>
                <li><a href="#">弱电工程</a></li>
                <li><a href="#">呼救器</a></li>
                <li><a href="#">楼宇对讲</a></li>
                <li ><a href="#">快速通道</a></li>
                <li><a href="#">楼宇对讲</a></li>
                <li ><a href="#">快速通道</a></li>
            </ul>

            <ul class="server-type">
                <li class="type-title-1"><span>区域</span></li>
                <li><a href="#">北京市</a></li>
                <li><a href="#">上海市</a></li>
                <li><a href="#">武汉市</a></li>
                <li><a href="#">保定市</a></li>
                <li><a href="#">石家庄市</a></li>
                <li><a href="#">衡水市</a></li>
                <li><a href="#">邢台市</a></li>
                <li class="downmenue" style="width: 80px;height: 50px;float: right;font-size: 14px;color:#606060;"><span  id="show" >展开 <b class="caret"></b></span></li>
            </ul>


            <ul class="server-type" id="adress" style="display: none">
                <li><a href="#">北京市</a></li>
                <li><a href="#">上海市</a></li>
                <li><a href="#">武汉市</a></li>
                <li><a href="#">保定市</a></li>
                <li><a href="#">石家庄市</a></li>
                <li><a href="#">衡水市</a></li>
                <li><a href="#">邢台市</a></li>
                <li><a href="#">北京市</a></li>
                <li><a href="#">上海市</a></li>
                <li><a href="#">武汉市</a></li>
            </ul>
        </div>

        <div class="subnav">
            <div class="order">
                <a href="#">排序</a>
                <a href="#">热门排序</a>
            </div>
            <div class="partpage">
                &lt;<a href="{{url('/orderlis'.$data->currentPage()+1)}}">下一页</a>
                <a href="#">上一页</a>&gt;
            </div>
        </div>
        <hr>
  @foreach($data as $r)
        <div class="content">
            <div class="content-left">
                <a href="{{url('/order/'.$r->bid)}}"><img src="{{$r->img}}" alt=""></a>
            </div>
            <div class="content-right">
                <div class="name">
                    <a href="{{url('/order/'.$r->bid)}}"> <p>{{$r->contact}}</p></a>
                </div>
                <div class="content-title">
                    <h4>{{$r->title}}</h4>
                    <p><nobr>{{$r->content}}</nobr></p>
                </div>
            </div>
        </div>
        @endforeach


        <div class="paging" >
           {{$data->links()}}
            <div class="paging-right">
                <span>共有{{$data->lastpage()}}页，去第 <input type="text"></span> <button type="button">确定</button>
            </div>
        </div>



    </div>
</div>






<!--底部-->
@include('inc.home.footer')
<script src="home/js/orderlist.js"></script>
</body>
</html>