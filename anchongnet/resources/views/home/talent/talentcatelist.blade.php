<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>人才列表</title>
    <link rel="stylesheet" href="{{asset('home/css/rencailist.css')}}">
    <link rel="stylesheet" href="{{asset('home/css/businessjs.css')}}">
    <link rel="stylesheet" href="{{asset('home/css/top.css')}}">
    <link rel="stylesheet" href="{{asset('home/css/footer.css')}}">
</head>
<body>
@include('inc.home.top')
<div class="header-center" >
    <div class="header-main">
        <div class="logo">
            <a href="{{url('/')}}"><img src="{{asset('home/images/zhaohuo/7.jpg')}}" alt=""></a>
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
                <li id="change"><a href="{{url('/business')}}">商机</a><img src="{{asset('home/images/zhaohuo/9.jpg')}}" alt="" class="buslist">
                    <div class="cart">
                        <p><a href="{{url('/project')}}">工程</a></p>
                        <p><a href="{{url('/sergoods')}}">找货</a></p>
                        <p><a href="{{url('/talent')}}">人才</a></p>
                    </div>
                </li>

                <li id="change1"><a href="{{url('/community')}}">社区</a>

                </li>

                <li id="change2"><a href="{{url('/equipment')}}">设备选购</a>

                </li>

                <li><a href="{{url('/info')}}">资讯</a></li>
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
                <a href="{{url('/talent')}}"><img src="{{asset('home/images/business/发布人才.png')}}" alt=""></a><a href="{{url('server/talentjoin')}}"><img
                            src="{{asset('home/images/business/人才招聘1.png')}}" alt=""></a>
            </div>
            <div class="publish-right">
                <a href="
                 @if(isset($msg))
                {{url('/talent/create')}}
                @else
                {{url('/user/login')}}
                @endif
                        "><img src="{{asset('home/images/zhaohuo/36.jpg')}}" alt=""></a>
            </div>
        </div>

        <div class="server">
            <hr>
            <ul class="server-type">
                <li class="type-title"><span>服务类别</span></li>
                @foreach($sercate as $s)
                    <li><a href="{{url('server/sertalent/'.$s->id)}}"
                           @if($s->id==$id)
                        style="background: #1DABD8;
                        border-radius: 5px;
                        color: #F5F5F5;"
                            @endif>{{$s->tag}}</a></li>
                @endforeach
                <li class="downmenue" style="width: 80px;height: 50px;float: right;font-size: 14px;color:#606060;"><span  id="flip" >展开 <b class="caret"></b></span> </li>
            </ul>
            <ul class="server-type" id="yy" style="display: none;">

            </ul>

            <ul class="server-type">
                <li class="type-title-1"><span>区域</span></li>
                @foreach($adrcate as $a)
                    <li><a href="{{url('server/sertalent/'.$a->id)}}"
                           @if($a->id==$id)
                           style="background: #1DABD8;
                        border-radius: 5px;
                        color: #F5F5F5;"
                                @endif
                        >{{$a->tag}}</a></li>
                @endforeach
                <li class="downmenue" style="width: 80px;height: 50px;float: right;font-size: 14px;color:#606060;"><span  id="show" >展开 <b class="caret"></b></span></li>
            </ul>


            <ul class="server-type" id="adress" style="display: none">
                @foreach($addcate as $d)
                    <li><a href="{{url('server/sertalent/'.$d->id)}}"
                           @if($d->id==$id)
                           style="background: #1DABD8;
                        border-radius: 5px;
                        color: #F5F5F5;"
                                @endif

                        >{{$d->tag}}</a></li>
                @endforeach

            </ul>
            <hr style="border:  1px #9b9b9b solid; ">
        </div>

        <div class="subnav">
            <div class="order">
                <a href="#">排序</a>
                <a href="#">热门排序</a>
            </div>
            <div class="partpage">
                &lt;<a href="{{$serbus->nextPageUrl()}}">下一页</a>
                <a href="{{$serbus->previousPageUrl()}}">上一页</a>&gt;
            </div>
        </div>
        <hr>
  @foreach($serbus as $r)
        <div class="content">
            <div class="content-left">
                <a href="{{url('/talent/'.$r->bid)}}"><img src="{{$r->img}}" alt=""></a>
            </div>
            <div class="content-right">
                <div class="name">
                    <a href="{{url('/talent/'.$r->bid)}}"> <p>{{$r->contact}}</p></a>
                </div>
                <div class="content-title">
                    <h4>{{$r->title}}</h4>
                    <p><nobr>{{$r->content}}</nobr></p>
                </div>
            </div>
        </div>
        @endforeach

        @if($serbus->lastpage()>1)
        <div class="paging" >
           {{$serbus->links()}}
            <div class="paging-right">
                <form action="{{url('gopage/tlpage')}}" method="post">
                {{csrf_field()}}
                <span>共有{{$serbus->lastpage()}}页，去第 <input type="text" name="page"></span> <button type="submit">确定</button>
                </form>
            </div>
        </div>
         @endif


    </div>
</div>






<!--底部-->
@include('inc.home.footer')
<script src="{{asset('home/js/jquery-3.1.0.min.js')}}"></script>
<script src="{{asset('home/js/businessjs.js')}}"></script>
<script src="{{asset('home/js/top.js')}}"></script>
<script src="{{asset('home/js/orderlist.js')}}"></script>
@foreach($addcate as $d)
@if($d->id==$id)
<script>
    $(document).ready(function(){
        $("#adress").show();
    });
</script>
    @endif
    @endforeach
</body>
</html>