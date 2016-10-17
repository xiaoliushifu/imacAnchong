<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>工程详情</title>
    <link rel="stylesheet" type="text/css" href="/home/css/talent-desc.css"/>
    <link rel="stylesheet" href="../home/css/businessjs.css">
    <link rel="stylesheet" href="{{asset('home/css/footer.css')}}">
    <script src="{{asset('home/js/jquery-3.1.0.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('home/css/top.css')}}">
    <script src="{{asset('home/js/top.js')}}"></script>
</head>
<body>
@include('inc.home.top')
<div class="header">
    <div class="header-container">
        <div class="logo">
            <a href="{{url('/')}}">
                <img src="/home/images/gongchengxq/logo.jpg"/>
            </a>
        </div>
        <div class="search">
            <form class="search-form">
                <input type="text" name="search" class="search-text" placeholder="找工程&nbsp;找人才&nbsp;聊生活" />
                <input type="submit" value="搜索" class="search-btn"/>
            </form>
        </div>
        <div class="cl"></div>

    </div>
</div>
<div class="navm">
    <div class="navc">
        <div class="navcontent">
            <ul>
                <li><a href="{{url('/')}}">首页</a></li>
                <li id="change"><a href="{{url('/business')}}">商机</a><img src="../home/images/zhaohuo/9.jpg" alt="" class="buslist">
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

<div class="site-middle">
    <div class="middle-container">
        <div class="publisher">
            <ul>
                <li><img src="{{$data->img}}"/></li>
                <li class="publisher-name">{{$data->contact}}</li>

                <li class="server-type">
                    服务类型：{{$data->tag}}
                </li>
                <li class="server-area">
                    服务区域：{{$data->tags}}
                </li>
                <li class="contact">
                    <span class="contact-tel">联系电话：</span>
                    @if(count($status) == 0)
                    <span class="contact-info">认证后可查看联系方式</span>
                    @else
                        @for($i=0;$i<count($status);$i++)
                            @if($status[$i]->auth_status == "3")
                                <span class="contact-info">{{$data->phone}}</span>
                            @endif
                        @endfor
                    @endif
                </li>
            </ul>
        </div>
        <div class="project-detail">
            <h2 class="project-title">{{$data->title}}</h2>
            <span class="type">{{$data->tag}}</span>
            <span class="area">{{$data->tags}}</span>
            <p class="publish-time">
                发布于
                <span class="">{{$data->created_at}}</span>
            </p>
            <ul class="project-desc">
                {!!$data->content  !!}

                <li><img src="{{$data->img}}"/></li>


                <li class="arctile-foot">欢迎广大有志之士加入我们的项目</li>
            </ul>
        </div>
        <div class="cl"></div>
    </div>
</div>
@include('inc.home.footer')
<script src="/home/js/jquery-3.1.0.min.js"></script>
<script src="/home/js/talent-desc.js" type="text/javascript" charset="utf-8"></script>
<script src="../home/js/businessjs.js"></script>
</body>

</html>
