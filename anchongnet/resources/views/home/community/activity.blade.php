<html>
<head>
    <meta charset="utf-8">
    <title>闲聊</title>
    <link rel="stylesheet" type="text/css" href="home/css/chat.css"/>>
    <script src="home/js/jquery-3.1.0.js"></script>
</head>
<body>
@include('inc.home.site-top')
<div class="header">
    <div class="header-container">
        <div class="logo">
            <a href="{{url('/')}}">
                <img src="home/images/chat/logo_01.jpg"/>
                <i>安虫社区</i>
            </a>
        </div>
        <div class="search">
            <form class="search-form" method="post">
                <input type="text" name="search" class="search-text" placeholder="找工程&nbsp;找人才&nbsp;聊生活" />
                <input type="submit" value="搜索" class="search-btn"/>
            </form>
        </div>
        <div class="cl"></div>
        <div class="site-nav">
            <ul class="navigation">
                <li class="nav-item"><a class="nav-name" href="{{url('/community')}}">所有</a></li>
                <li class="nav-item"><a class="nav-name" href="{{url('/talk')}}">闲聊</a></li>
                <li class="nav-item"><a class="nav-name" href="{{url('question')}}">问问</a></li>
                <li class="nav-item"><a class="nav-name" href="{{url('/activity')}}">活动</a></li>
                <li class="new-chat" ><a href="{{url('/chat')}}"><img src="home/images/chat/chat.png"></a></li>
                <div class="cl"></div>
            </ul>
        </div>
    </div>
</div>
<div class="site-middle">
    <div class="middle-container">
        <ul class="chat-info">
            @foreach($activity as $value)
            <li class="chat-item">
                <ul class="chat-show">
                    <li>
                        <img class="portrait" src="{{$value ->  headpic}}">
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
                            <a class="share" href=""><img src="home/images/chat/share.png"></a>
                        </p>
                    </li>
                </ul>
            </li>
            @endforeach
        </ul>
        <div class="pages">
            <ul class="page-select">
               {!! $activity -> links() !!}
            </ul>
            <ul class="page-skip">
                <i>共有{{$activity -> lastpage()}}页，</i>
                <i class="blank">
                    去第
                    <input name="page" class="page-num" onchange="changePage(this)" type="text" value="{{$activity->currentPage()}}">
                    页
                </i>
                <a class="page-btn" href="{{$activity->url($activity->currentPage())}}">确定</a>
            </ul>
            <div class="cl"></div>
        </div>
    </div>
</div>
@include('inc.home.site-foot')
</body>
<script>
    {{--获取用户输入的页数，然后更改a标签的链接--}}
    function changePage(obj) {
        var num = $(obj).val();
        if(!isNaN(num)&&num>0&&num<={{$activity->lastpage()}}){
            $('.page-btn').attr('href','http://www.anchong.net/activity?page='+num);
        }else{
            alert('请输入数字并小于等于"{{$activity->lastpage()}}"');
            $('.page-num').val({{$activity->currentPage()}});
        }
    }
    $(function () {
        $('.page-num').keypress(function (e) {
            if (e.keyCode == 13) {
                location.href = 'http://www.anchong.net/activity?page='+ $(this).val();
            }
        });
    })
</script>
</html>