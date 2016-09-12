<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>商机首页</title>
    <link rel="stylesheet" href="home/css/shangjisy.css">
    <script src="home/js/jquery-3.0.0.min.js"></script>
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
                <li><img src="home/images/shangji/6.jpg" alt=""></li>
                <li style="padding-left: 10px;"><a href="#">风信子<b class="caret"></b></a></li>
            </ul>
        </div>
    </div>
</div>
<div class="header-center">
    <div class="header-main">
        <div class="logo">
            <a href="{{'/'}}">
            <img src="home/images/shangji/7.jpg" alt="">
            </a>
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
                <li><a href="{{url('/business')}}">商机</a><img src="home/images/shangji/9.jpg" alt=" " class="buslist" ></li>
                <div class="cart">
                    <p><a href="{{url('/gc')}}">工程</a></p>
                    <p><a href="{{url('/sergoods')}}">找货</a></p>
                    <p><a href="{{url('/orderlist')}}">人才</a></p>
                </div>
                <script>

                </script>
                <style>

                </style>
                <li><a href="{{url('/community')}}">社区</a><img src="home/images/shangji/9.jpg" alt="" class="buslist1"></li>
                <div class="cart1">
                    <script>

                    </script>
                    <style>

                    </style>
                    <p><a href="{{url('/gc')}}">工程</a></p>
                    <p><a href="{{url('/sergoods')}}">找货</a></p>
                    <p><a href="{{url('/orderlist')}}">人才</a></p>
                </div>
                <li><a href="{{url('/ancself')}}">设备选购</a><img src="home/images/shangji/9.jpg" alt="" style="right: 15px;"  class="buslist2"></li>
                <div class="cart2">
                    <p><a href="{{url('/ancself')}}">安虫自营</a></p>
                    <p><a href="{{url('/sergoods')}}">第三方商城</a></p>

                </div>
                <script>

                </script>
                <style>

                </style>
                <li><a href="{{url('/info')}}">资讯</a></li>
            </ul>
        </div>
        <div class="publish">
            <a href="#"><img src="home/images/shangji/8.jpg" alt=""></a>
        </div>
    </div>

</div>
<div style="clear: both"></div>
<hr class="nav-underline">
<div class="adcontent">
    <ul class="banner">
        <li><a href="#"><img src="home/images/shangji/11.jpg"></a></li>
        <li><a href="#"><img src="home/images/shangji/12.jpg"></a></li>
        <li><a href="#"><img src="home/images/shangji/13.jpg"></a></li>

    </ul>
    <script type="text/javascript">



    </script>

</div>
<div class="content">
    <div class="subcontent">
        <div class="content-top-title">
            <div class="left-title">
               <p>最新招标</p>
            </div>
            <div class="pro-publish">
                <a href="{{url('/releaseeg')}}"><img src="home/images/shangji/14.jpg" alt=""></a>
            </div>
        </div>

        <div class="topmain">
            <div class="topmain-left">
                <img src="home/images/shangji/15.jpg" alt="">
            </div>
            <div class="topmain-center">
                <img src="home/images/shangji/16.jpg" alt="">
            </div>
            <div class="topmain-right">
                <div class="mainlf-title">
                    <span>工程信息</span><a href="#">换一批>></a>
                </div>
                <ul>
                    @foreach($bus as $b)
                    <li>
                        <h4><a href="{{url('pro/'.$b->bid)}}">{{$b->title}}</a></h4>
                        <p><nobr>{{$b->content}}</nobr></p>
                    </li>
                    <hr>
                    @endforeach

                </ul>
            </div>
        </div>
         <div class="content-center-title">
             <p>热门招标项目</p>
         </div>
        <div class="centermain">
            <div class="centermain-left">
                <a href="{{url('pro/'.$hot[0]->bid)}}"><img src="{{$hot[0]->img}}" alt=""></a>
                <div class="centermain-left-title"><p>{{$hot[0]->title}}</p></div>
            </div>

            <div class="centermain-center">
                <div class="center-top">
                    <a href="{{url('pro/'.$hot[1]->bid)}}"><img src="{{$hot[1]->img}}" alt=""></a>
                    <div class="center-top-title"><p>{{$hot[1]->title}}</p></div>
                </div>

                <div class="center-down">
                    <a href="{{url('pro/'.$hot[2]->bid)}}"> <img src="{{$hot[2]->img}}" alt=""></a>

                    <a href="{{url('pro/'.$hot[3]->bid)}}"><img src="{{$hot[3]->img}}" alt=""></a>
                    <div class="center-down-1"><p>{{$hot[2]->title}}</p></div>
                    <div class="center-down-2"><p>{{$hot[3]->title}}</p></div>
                </div>
            </div>
            <div class="centermain-right">
                <a href="{{url('pro/'.$hot[4]->bid)}}"><img src="{{$hot[4]->img}}" alt=""></a>
                <div class="centermain-right-title"><p>{{$hot[4]->title}}</p></div>
            </div>

        </div>
        <div class="content-center-title">
            <p>安虫名人榜</p>
        </div>
        <div class="ranking">
            <ul>
                @foreach($user as $r)
                <li class="">
                    <a href="#">
                    <img src="{{$r->headpic}}" alt="">
                    <p>{{$r->nickname}}</p></a>
                </li>
                @endforeach

            </ul>
        </div>

        <div class="content-top-title">
            <div class="left-title">
                <p>人才信息</p>
            </div>
            <div class="pro-publish">
                <a href="{{url('/reorder')}}"><img src="home/images/shangji/fbrc.png" alt=""></a>
            </div>
        </div>

        <div class="topmain">
            <div class="topmain-left">
                <img src="home/images/shangji/27.jpg" alt="">
            </div>
            <div class="topmain-center">
                <img src="home/images/shangji/28.jpg" alt="">
            </div>
            <div class="topmain-right">
                <div class="mainlf-title">
                    <span>人才招聘</span><a href="#">换一批>></a>
                </div>
                <ul>
                    <li>
                        <h4><a href="#">服务类别：监控探测 <span></span>服务区域：深圳市</a></h4>

                    </li>
                    <hr>
                    <li>
                        <h4><a href="#">服务类别：监控探测 <span></span>服务区域：深圳市</a></h4>
                    </li>
                    <hr>
                    <li>
                        <h4><a href="#">服务类别：监控探测 <span></span>服务区域：深圳市</a></h4>
                    </li>
                    <hr>
                    <li>
                        <h4><a href="#">服务类别：监控探测 <span></span>服务区域：深圳市</a></h4>
                    </li>
                    <hr>
                    <li>
                        <h4><a href="#">服务类别：监控探测 <span></span>服务区域：深圳市</a></h4>
                    </li>
                    <hr>
                </ul>
            </div>
        </div>

    </div>
</div>

@include('inc.home.footer')


</body>
</html>