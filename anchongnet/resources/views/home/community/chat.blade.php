<html>
<head>
    <meta charset="utf-8">
    <title>安虫社区-{{$info -> title}}</title>
    <link rel="stylesheet" type="text/css" href="../home/css/chat-detail.css"/>
    <script src="../home/js/jquery-3.1.0.js"></script>
    <script src="../home/org/qqface/jquery.qqFace.js"></script>
    <link rel="stylesheet" href="home/css/top.css">
    <script src="home/js/top.js"></script>
    <script src="../home/js/chat.js"></script>
</head>
<body>
@include('inc.home.top')
<div class="header">
    <div class="header-container">
        <div class="logo">
            <a href="{{url('/')}}">
                <img src="../home/images/logo.jpg"/>
            </a>
        </div>
        <div class="search">
            <form class="search-form">
                <input type="text" name="search" class="search-text" placeholder="找工程&nbsp;找人才&nbsp;聊生活" />
                <input value="搜索" class="search-btn"/>
            </form>
        </div>
        <div class="cl"></div>
        <div class="site-nav">
            <ul class="navigation">
                <li class="nav-item"><a class="nav-name" href="{{url('/community')}}">所有</a></li>
                <li class="nav-item"><a class="nav-name" href="{{url('/talk')}}">闲聊</a></li>
                <li class="nav-item"><a class="nav-name" href="{{url('question')}}">问问</a></li>
                <li class="nav-item"><a class="nav-name" href="{{url('/activity')}}">活动</a></li>
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
                <div class="share bdsharebuttonbox" data-tag="share_1"><a class="bds_more" data-cmd="more"></a></div>
                <p class="comments-share">
                    <a class="comments" href="#comments"><img src="/home/images/chat/talk.png">{{$num}}</a>
                </p>
            </li>
        </ul>
        <ul class="comments-content">
            <li class="comments-show">
                <p class="all"><img src="../home/images/chat/all.png"></p>
                @if(count($comment) == 0)
                    <p class="blank">暂&nbsp;无&nbsp;评&nbsp;论</p>
                @else
                @foreach($comment as $key => $value)
                    <ul class="comments-item">
                        <li class="comments-icon"><img src="{{$value -> headpic}}"></li>
                        <li class="comments-replay">
                            <p class="username">{{$value -> name}}</p>
                            <p class="comments-time">{{date("Y-m-d",strtotime($value -> created_at))}}</p>
                            <p class="comments-info">{!! $value -> content !!}</p>
                            <a  class="replay">回复</a>
                            <span class="parting"></span>
                            @for($i=0;$i<(count($replay[$value->comid]));$i++)
                                <p class="dialogue"><i class="rpname">{{$replay[$value->comid][$i]->name}}</i>回复<i class="comname">{{$replay[$value->comid][$i] -> comname}}</i>:{!! $replay[$value->comid][$i]-> content !!}</p>
                                <a class="replay">回复</a>
                            @endfor
                        </li>
                    </ul>
                @endforeach
            </li>
            @endif
            <li class="more">
                <img src="../home/images/chat/more.png" alt="点击加载更多">
            </li>
            <li class="replay-area">
                <ul>
                    <li class="replay-icon"><img src="../home/images/chat/p61.jpg"></li>
                    <li class="replay-dist">
                        <div>
                            <div id="show"></div>
                            <form class="publish-comment">
                                {{csrf_field()}}
                                <i>我也有话要说……</i>
                                <textarea  disabled="disabled" id="comments" name="content" class="replay-content">请您登陆后评论</textarea>
                                <a class="send" onclick="Comments()"><img src="../home/images/chat/send.png" ></a>
                                <a class="emotion"><img src="../home/images/chat/emoticon.png"></a>
                                @if(session('user'))
                                    <script>
                                        $(function () {
                                            $('#comments').removeAttr("disabled");
                                            $('#comments').html("");
                                        })
                                    </script>
                                    <input type="hidden" name="name" value="{{$msg->nickname}}">
                                    <input type="hidden" name="headpic" value="{{$msg->headpic}}">
                                    <input type="hidden" name="users_id" value="{{$msg->users_id}}">
                                    <input type="hidden" name="chat_id" value="{{$info->chat_id}}">
                                    <input type="hidden" name="'created_at" value="{{date('Y-m-d H:i:s')}}">
                                @endif
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
<script>
    $(function () {
        window._bd_share_config = {
            common : {
                bdText : $('.content').text(),
                bdDesc : $('.chat-title').text(),
                bdUrl : '',
                bdSign: 'on',
                bdPic:'{{$info->img}}'
            },
            share : [{
                "bdSize" : 16
            }],
        }
        with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?cdnversion='+~(-new Date()/36e5)];
        $(".bds_more").css({
            "height":"18px",
            "line-height":"18px",
            "margin":"0",
            "backgroundImage":"url(http://www.anchong.net/home/images/chat/share.png)"
        });
        $(".emotion").qqFace({
            assign:'comments', //给输入框赋值
            path:'../home/org/qqface/face/'    //表情图片存放的路径
        });
    })
    //替换成表情
    function replace_em(str){
        str = str.replace(/\</g,'&lt;');
        str = str.replace(/\>/g,'&gt;');
        str = str.replace(/\n/g,'<br/>');
        str = str.replace(/\[em_([0-9]*)\]/g,'<img src="../home/org/qqface/face/$1.gif" border="0" />');
        return str;
    }
</script>
</html>
