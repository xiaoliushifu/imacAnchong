<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>商机首页</title>
    <link rel="stylesheet" href="home/css/shangjisy.css">
    <link rel="stylesheet" href="home/css/businessjs.css">
    <link rel="stylesheet" href="home/css/top.css">
</head>
<body>
@include('inc.home.top')
<div class="header-center">
    <div class="header-main">
        <div class="logo">
            <a href="{{url('/')}}"><img src="home/images/shangji/7.jpg" alt=""></a>
        </div>
<!--         <div class="search"> -->
<!--           <div class="searchbar"> -->
<!--               <input type="text" class="biaodan"> -->
<!--               <button type="button" class="btn">搜索</button> -->
<!--           </div> -->
<!--             <div class="searchbar-list"> -->
<!--                 <span>热门搜索:</span><a href="#">探测监控</a><a href="#">防护保障</a><a href="#">探测监控</a><a href="#">探测报警</a><a href="#">弱电工程</a> -->
<!--             </div> -->
<!--         </div> -->
    </div>
</div>
<div class="nav">
    <div class="navc">
        <div class="navcontent">
            <ul>
                <li><a href="{{url('/')}}">首页</a></li>
                <li id="change1"><a href="{{url('/project')}}">工程</a></li>
                <li id="change1"><a href="{{url('/sergoods')}}">找货</a></li>
                <li id="change1"><a href="{{url('/talent')}}">人才</a></li>
                <li id="change1"><a href="{{url('/community')}}">社区</a></li>
                <li><a href="{{url('/info')}}">资讯</a></li>
            </ul>
        </div>
        <div class="publish">
            <a href="#"><img src="home/images/shangji/8.jpg" alt=""></a>
        </div>
    </div>
</div>
<div style="clear: both;"></div>
<hr class="nav-underline">
<div class="adcontent">
    <ul class="banner">
        <li><a href="#"><img src="home/images/shangji/11.jpg"></a></li>
        <li><a href="#"><img src="home/images/shangji/12.jpg"></a></li>
        <li><a href="#"><img src="home/images/shangji/13.jpg"></a></li>
    </ul>
</div>
<div class="content">
    <div class="subcontent">
        <div class="content-top-title">
            <div class="left-title">
               <p>最新招标</p>
            </div>
            <div class="pro-publish">
            		{{--发布工程--}}
                <a href="{{url('/project/create')}}"><img src="home/images/shangji/14.jpg" alt=""></a>
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
                    @foreach($businvit as $b)
                    <li>
                        <h4><a href="{{url('project/'.$b->bid)}}">{{$b->title}}</a></h4>
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
                <a href="{{url('project/'.$bushot[0]->bid)}}"><img src="{{$bushot[0]->img}}" alt=""></a>
                <div class="centermain-left-title"><p>{{$bushot[0]->title}}</p></div>
            </div>

            <div class="centermain-center">
                <div class="center-top">
                    <a href="{{url('project/'.$bushot[1]->bid)}}"><img src="{{$bushot[1]->img}}" alt=""></a>
                    <div class="center-top-title"><p>{{$bushot[1]->title}}</p></div>
                </div>

                <div class="center-down">
                    <a href="{{url('project/'.$bushot[2]->bid)}}"> <img src="{{$bushot[2]->img}}" alt=""></a>

                    <a href="{{url('project/'.$bushot[3]->bid)}}"><img src="{{$bushot[3]->img}}" alt=""></a>
                    <div class="center-down-1"><p>{{$bushot[2]->title}}</p></div>
                    <div class="center-down-2"><p>{{$bushot[3]->title}}</p></div>
                </div>
            </div>
            <div class="centermain-right">
                <a href="{{url('project/'.$bushot[4]->bid)}}"><img src="{{$bushot[4]->img}}" alt=""></a>
                <div class="centermain-right-title"><p>{{$bushot[4]->title}}</p></div>
            </div>

        </div>
        <div class="content-center-title">
            <p>安虫名人榜</p>
        </div>
        <div class="ranking">
            <ul>
                @foreach($bususer as $r)
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
                <a href="{{url('/project/create')}}"><img src="home/images/shangji/fbrc.png" alt=""></a>
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
                    @foreach($bustalent as $t)
                    <li>
                        <h4><a href="{{url('project/'.$t->bid)}}">服务类别：{{$t->tag}} <span></span>服务区域：{{$t->tags}}</a></h4>
                    </li>
                    <hr>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

@include('inc.home.footer')
<script src="home/js/jquery-3.1.0.min.js"></script>
<script src="home/js/businessjs.js"></script>
<script src="home/js/top.js"></script>
</body>
</html>