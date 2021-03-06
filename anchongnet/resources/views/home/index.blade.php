<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="wwwcctv" content="{{ csrf_token() }}">
    <title>安虫首页</title>
    <link rel="stylesheet" type="text/css" href="home/css/index.css">
    <script src="home/js/jquery-3.1.0.js"></script>
    <script src="home/js/indexjs.js"></script>
    <link rel="stylesheet" href="home/css/top.css">
    <link rel="stylesheet" type="text/css" href="home/css/suggestion.css">
    <script src="home/js/top.js"></script>
</head>
<body>
@include('inc.home.top')
<div class="header">
    <div class="header-container">
        <div class="logo">
            <img src="home/images/7.jpg"/>
        </div>
		<form action="/equipment/gs">
        <div class="search">
            <div class="searchbar">
                <input type="text" class="biaodan" name="q" id="gover_search_key">
                <button type="submit" class="btn">搜索</button>
            </div>
            {{--提示框--}}
            <div class="search_suggest"  id="gov_search_suggest"><ul></ul></div>
        </div>
        </form>
        <div class="cl"></div>
        <div class="site-nav">
            <ul class="navigation">
                <li class="home nav-item"><a href="{{url('/')}}">首页</a></li>
                <li class="business nav-item">
                    <a href="{{url('/business')}}">商机</a>
<!--                     <span class="business-triangle"></span> -->
<!--                     <div class="business-list"> -->
<!--                         <p><a href="{{url('/project')}}">工程</a></p> -->
<!--                         <p><a href="{{url('/talent')}}">人才</a></p> -->
<!--                         <p><a href="{{url('/sergoods')}}">找货</a></p> -->
<!--                     </div> -->
                </li>
                <li class="community nav-item"><a href="{{url('/community')}}">社区</a></li>
                <li class="equipment nav-item"><a href="{{url('/equipment ')}}">设备选购</a></li>
                <li class="news nav-item"><a href="{{url('/info')}}">资讯</a></li>
                <li class="news nav-item"><a href="http://app.anchong.net">安虫App下载</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="site-middle">
    <div class="middle-cont">
        <ul class="middle-top">
            <li class="banner">
                <div>
                    <img src="home/images/shouye3.jpg">
                </div>
            </li>
            <li class="tips">
                <div class="notice">
                    <p class="notice-title"><a><img src="home/images/notice.png"></a></p>
                    <div class="notice-info">
                        <marquee behavior="scroll" direction="up" loop="-1" scrolldelay="1"  height="240" width="240" contenteditable="true" onstart="this.firstChild.innerHTML+=this.firstChild.innerHTML;" scrollamount="2" onmouseover="this.stop();" onmouseout="this.start();">
                            @foreach($notice as $value)
	                           <p>
	                               {{$value->content}}
	                           </p>
                            @endforeach
                            &nbsp;
                        </marquee>
                    </div>
                </div>
                <div class="information">
                    <p class="title"><a href=""><img src="home/images/info.png"></a></p>
                    <div class="hot-info">
                        <p><img src="home/images/hot.png"><a href="{{url('/info/'.$iinfo[0]->infor_id)}}">{{$iinfo[0]->title}}</a></p>
                        <p><img src="home/images/hot.png"><a href="{{url('/info/'.$iinfo[1]->infor_id)}}">{{$iinfo[1]->title}}</a></p>
                    </div>
                </div>
            </li>
        </ul>
        <div class="flow">
            <h1>工程流程</h1>
            <ul class="chart">
                <li><a href="/business"><img src="home/images/66.jpg"></a></li>
                <li><a href="/activity"><img src="home/images/67.jpg"></a></li>
                <li><a href="/serproject/lepro"><img src="home/images/68.jpg"></a></li>
                <li><a href="/project"><img src="home/images/69.jpg"></a></li>
                <li><a href="/equipment"><img src="home/images/70.jpg"></a></li>
                <li><a href="/equipment"><img src="home/images/71.jpg"></a></li>
            </ul>
        </div>
        <div class="recommended">
            <h1>推荐工程</h1>
            <ul class="recommended-list">
                <li class="recommended-left recommend-1">
                    <a href="{{url('project/'.$ihot[0]->bid)}}">
                        <img src="{{$ihot[0]->img}}">
                        <p>{{$ihot[0]->title}}</p>
                    </a>
                </li>
                <li class="recommended-cnter">
                    <ul>
                        <li class="recommend-2">
                            <a href="{{url('project/'.$ihot[1]->bid)}}">
                                <img src="{{$ihot[1]->img}}">
                                <p>{{$ihot[1]->title}}</p>
                            </a>
                        </li>
                        <li class="recommend-3">
                            <a href="{{url('project/'.$ihot[2]->bid)}}">
                                <img src="{{$ihot[2]->img}}">
                                <p>{{$ihot[2]->title}}</p>
                            </a>
                        </li>
                        <li class="recommend-4">
                            <a href="{{url('project/'.$ihot[4]->bid)}}">
                                <img src="{{$ihot[3]->img}}">
                                <p>{{$ihot[3]->title}}</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="recommend-5 recommended-right">
                    <a href="{{url('project/'.$ihot[4]->bid)}}">
                        <img src="{{$ihot[4]->img}}">
                        <p>{{$ihot[4]->title}}</p>
                    </a>
                </li>
            </ul>
            <ul class="bottom">
                @foreach($iuserinfo as $value)
                    <li class="bottom-item">
                        <a>
                            <img src="{{$value -> headpic}}">
                            <p>{{$value -> nickname}}</p>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="server">
            <h1>为您服务</h1>
            <ul>
                <li class="server-item"><a href="{{url('/project')}}"><img src="home/images/85.jpg"></a></li>
                <li class="server-item"><a href="{{url('/project')}}"><img src="home/images/86.jpg"></a></li>
                <li class="server-item"><a href="{{url('/talent')}}"><img src="home/images/87.jpg"></a></li>
                <li class="server-item1"><a href="{{url('/equipment')}}"><img src="home/images/88.jpg"></a></li>
            </ul>
        </div>
        <div class="hot">
            <h1>热门社区</h1>
            <ul class="hot-top">
                <li class="ad">
                    <a href="{{url('/community')}}">
                        <img src="home/images/89.jpg">
                    </a>
                </li>
                <li class="bbs">
                    <ul>
                        @foreach($icommunity as $value)
                        <li>
                            <h3><a href="{{url('/community/'.$value -> chat_id)}}">{{$value -> title}}</a></h3>
                            <p>{!! $value -> content !!}</p>
                        </li>
                        @endforeach
                    </ul>
                </li>
                <li class="talent-cont">
                    <p class="talent-nav">
                    <h3>人才招聘</h3>
                    <h3>人才自荐</h3>
                    </p>
                    <p class="talent-item">
                        <span class="region">区域</span>
                        <span class="talent">人才</span>
                    </p>
                    @foreach($italent as $value)
                    <p class="talent-item">
                        <a href="{{url('/talent')}}" class="district">{{$value -> tags}}</a>
                        <a href="{{url('/talent/'.$value->bid)}}" class="talent-name">{{$value -> contact}}</a>
                    </p>
                    @endforeach
                </li>
            </ul>
            <ul class="bottom">
                @foreach($iuserinfo as $value)
                <li class="bottom-item">
                    <a>
                        <img src="{{$value -> headpic}}">
                        <p>{{$value -> nickname}}</p>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="goods">
            <h1>安防百货</h1>
            <div class="goods-nav">
                <ul class="good-nav">
                    <li><a href="/equipment/gs?q=门禁控制器">门禁控制器</a></li>
                    <li><a href="/equipment/list/2">视频监控</a></li>
                    <li><a href="/equipment/list/3">探测报警</a></li>
                    <li><a href="/equipment/list/4">巡更巡警</a></li>
                    <li><a href="/equipment/gs?q=门禁锁">门禁锁</a></li>
                    <li><a href="/equipment/list/7">智能消费</a></li>
                    <li><a href="/equipment/gs?q=快速通道">快速通道</a></li>
                    <li><a href="/equipment">更多</a></li>
                </ul>
            </div>            </div>
            <ul class="goods-cont">
                <li class="goods-left">
                    <ul>
                        <li class="classify">
                            <h3>八大类<i class="icon"></i></h3>
                            <ul>
                                @foreach($inav as $a)
                                    <li><a href="{{url('equipment/list/'.$a->cat_id)}}">{{$a->cat_name}}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="top-search">
                            <h3>热搜榜<i class="icon1"></i></h3>
                            <ul>
                                <li><a href="/equipment/gs?q=门禁">门禁</a></li>
                                <li><a href="/equipment/gs?q=摩仕龙">摩仕龙</a></li>
                                <li><a href="/equipment/gs?q=摄像头">摄像头</a></li>
                                <li><a href="/equipment/gs?q=停车管理">停车管理</a></li>
                                <li><a href="/equipment/gs?q=监控器">监控器</a></li>
                                <li><a href="/equipment/gs?q=安防配套">安防配套</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="goods-center">
                    <div><a href="/equipment/show/1411/3033"><img src="home/images/91.jpg"></a></div>
                </li>
                <li class="goods-right">
                    <ul>
                        <li>
                            <img src="home/images/92.jpg">
                            <p>
                                <a class="goods-classify" href="">[Oulin/欧林]</a>
                                <a class="goods-title" href="">欧林水槽双槽&nbsp;&nbsp;不锈钢厨</a>
                            </p>
                            <p class="goods-price">
                                价格：￥180
                            </p>
                        </li>
                        <li>
                            <img src="home/images/93.jpg">
                            <p>
                                <a class="goods-classify" href="">[Oulin/欧林]</a>
                                <a class="goods-title" href="">欧林水槽双槽&nbsp;&nbsp;不锈钢厨</a>
                            </p>
                            <p class="goods-price">
                                价格：￥180
                            </p>
                        </li>
                        <li>
                            <img src="home/images/94.jpg">
                            <p>
                                <a class="goods-classify" href="">[Oulin/欧林]</a>
                                <a class="goods-title" href="">欧林水槽双槽&nbsp;&nbsp;不锈钢厨</a>
                            </p>
                            <p class="goods-price">
                                价格：￥180
                            </p>
                        </li>
                        <li>
                            <img src="home/images/95.jpg">
                            <p>
                                <a class="goods-classify" href="">[Oulin/欧林]</a>
                                <a class="goods-title" href="">欧林水槽双槽&nbsp;&nbsp;不锈钢厨</a>
                            </p>
                            <p class="goods-price">
                                价格：￥180
                            </p>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="goods-bottom">
                <li><a href=""><img src="home/images/96.jpg"></a></li>
                <li><a href=""><img src="home/images/97.jpg"></a></li>
                <li><a href=""><img src="home/images/98.jpg"></a></li>
                <li><a href=""><img src="home/images/99.jpg"></a></li>
                <li><a href=""><img src="home/images/100.jpg"></a></li>
                <li><a href=""><img src="home/images/101.jpg"></a></li>
            </ul>
        </div>
        <div class="exhibition">
            <h1>展会活动</h1>
            <ul>
                @foreach($inactivity as $value)
                <li><a href="{{url('/community/'.$value -> chat_id)}}"><img src="{{$value -> img}}" alt="{{$value -> title}}"></a></li>
                @endforeach
            </ul>
        </div>
        <div class="cooperative">
            <h1>合作企业</h1>
            <ul>
                <li><a href=""><img src="home/images/106.jpg"></a></li>
                <li><a href=""><img src="home/images/107.jpg"></a></li>
                <li><a href=""><img src="home/images/108.jpg"></a></li>
                <li><a href=""><img src="home/images/109.jpg"></a></li>
                <li><a href=""><img src="home/images/110.jpg"></a></li>
                <li><a href=""><img src="home/images/111.jpg"></a></li>
                <li><a href=""><img src="home/images/112.jpg"></a></li>
                <li><a href=""><img src="home/images/113.jpg"></a></li>
            </ul>
        </div>
    </div>
</div>
@include('inc.home.site-foot')
</body>
{{--搜索--}}
<script src="home/js/search.js"></script>
</html>
