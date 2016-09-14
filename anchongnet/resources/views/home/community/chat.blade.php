<html>
<head>
    <meta charset="utf-8">
    <title>聊聊详情</title>
    <link rel="stylesheet" type="text/css" href="../home/css/chat-detail.css"/>
</head>
<body>
@include('inc.home.site-top')
<div class="header">
    <div class="header-container">
        <div class="logo">
            <a href="{{url('/')}}">
                <img src="../home/images/logo.jpg"/>
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
                <li class="nav-item"><a class="nav-name" href="">所有</a></li>
                <li class="nav-item"><a class="nav-name" href="">闲聊</a></li>
                <li class="nav-item"><a class="nav-name" href="">问问</a></li>
                <li class="nav-item"><a class="nav-name" href="">活动</a></li>
                <li class="new-chat" ><a href="{{url('/chat')}}"><img src="../home/images/chat/chat.png"></a></li>
                <div class="cl"></div>
            </ul>
        </div>
    </div>
</div>
<div class="site-middle">
    <div class="middle-container">
        <ul class="chat-info">
            <li class="chat-item">
                <div>
                    <img class="portrait" src="{{$info -> headpic}}">
                    <p class="name">{{$info -> name}}</p>
                    <p class="date">
                        <i class="day">{{date("d",strtotime($info -> created_at))}}/</i>
                        <i class="month">{{date("m",strtotime($info -> created_at))}}</i>
                    </p>
                </div>
            </li>
            <li class="chat-content">
                <h3 class="chat-title">{{$info -> title}}</h3>
                <p class="content">
                    {!! $info -> content !!}
                </p>
                <p class="comments-share">
                    <a class="comments" href=""><img src="../home/images/chat/talk.png"></a>
                    <a class="share" href=""><img src="../home/images/chat/share.png"></a>
                </p>
            </li>
        </ul>
        <ul class="comments-content">
            <li class="comments-show">
                <p class="all"><img src="../home/images/chat/all.png"></p>
                @foreach($comment as $key => $value)
                <ul class="comments-item">
                    <li class="comments-icon"><img src="{{$value -> headpic}}"></li>
                    <li class="comments-replay">
                        <p class="username">{{$value -> name}}</p>
                        <p class="comments-time">{{date("Y-m-d",strtotime($value -> created_at))}}</p>
                        <p class="comments-info">{{$value -> content}}<a  class="replay" href="">回复</a></p>
                        <span class="parting"></span>
                        @foreach($replay as $k => $v)
                        <p class="dialogue">
                            <i>{{$v->name}}</i>回复<i>{{$v -> comname}}</i>:{!! $v->content !!}
                            <a class="replay">回复</a>
                        </p>
                        @endforeach
                    </li>
                </ul>
                @endforeach
            </li>
            <li class="more">
                <a href=""><img src="../home/images/chat/more.png" alt="点击加载更多"></a>
            </li>
            <li class="replay-area">
                <ul>
                    <li class="replay-icon"><img src="../home/images/chat/p61.jpg"></li>
                    <li class="replay-dist">
                        <div>
                            <form>
                                <i>我也有话要说……</i>
                                <textarea  class="replay-content"></textarea>
                                <a class="send"><img src="../home/images/chat/send.png" ></a>
                                <a class="emoticon"><img src="../home/images/chat/emoticon.png"></a>
                            </form>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
@include('inc.home.site-foot')
</body>
</html>