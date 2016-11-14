<!DOCTYPE html>
<html lang="en">
<head>
    @yield('info')
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="{{asset('home/css/bootstrap.css')}}">
    <script type="text/javascript" src="{{asset('home/js/jquery-3.1.0.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('home/js/bootstrap.js')}}"></script>
</head>
<body>
<div class="topt">
    <div class="topt-1">
        <div class="topt-2"><p><a href="{{url('/')}}" style="color:#606060;">安虫首页</a></p></div>
        <div class="topt-3">
            <ul class="nav navbar-nav">

                <li>邮箱：www.@anchong.net</li>
                <li>垂询电话:0317-8155026</li>
               <li> <a href="{{url('/cart/'.$msg->users_id)}}">购物车<span class="glyphicon glyphicon-shopping-cart"></span></a></li>
                <li><img src={{$msg->headpic}} alt=""></li>
                <li style="padding-left: 10px;"><a href="#" class="dropdown-toggle " data-toggle="dropdown">{{$msg->nickname}}<b class="caret"></b></a>
                    <ul class="dropdown-menu depth_0 downlist">
                        <li><a href="{{url('pcenter')}}">个人首页</a></li>
                        <li><a href="{{url('servermsg')}}">个人消息</a></li>
                        <li><a href="{{url('/basics')}}">个人资料</a></li>
                        <li><a href="{{url('/quit')}}">退出登录</a></li>
                    </ul>


                </li>
            </ul>
        </div>
    </div>
</div>
<div class="topone">
    <div class="topone-1"  style="position: relative;">
        <div class="topone-2">
            <img src="{{asset('home/images/mine/60.jpg')}}" alt="">
        </div>
        <div class="topone-3">
            <ul>
                <li  class="ppp"><a href="{{url('/pcenter')}}" >首页</a><img src="{{asset('home/images/mine/up.png')}}" alt=""> </li>
                <li  class="ppp"><a href="{{url('/basics')}}" >个人资料</a><img src="{{asset('home/images/mine/up.png')}}" alt=""> </li>
                <li  class="ppp"><a href="{{url('/servermsg')}}" >消息</a><img src="{{asset('home/images/mine/up.png')}}" alt=""> </li>
            </ul>
           @yield('publish')
        </div>

    </div>
</div>


@yield('content')




<div class="foottop">
    <div class="foottop-1">
        <div class="foottoplf">
            <div class="yqlg"><h4>友情链接</h4>
                <hr>
            </div>
            <ul>
                <li>
                    <p><a href="#">中国安防行业网</a></p>
                    <p><a href="#">华强安防网</a></p>
                    <p><a href="#">中国安防展览网</a></p>
                    <p><a href="#">安防英才网</a></p>
                </li>
                <li>
                    <p><a href="#">智能交通网</a></p>
                    <p><a href="#">中国智能化</a></p>
                    <p><a href="#">中关村在线</a></p>
                    <p><a href="#">教育装备采购网</a></p>
                </li>
                <li>
                    <p><a href="#">中国贸易网</a></p>
                    <p><a href="#">华强电子网</a></p>
                    <p><a href="#">研究报告中国测控网</a></p>
                    <p><a href="#">五金机电网</a></p>
                </li>
                <li>
                    <p><a href="#">中国安防展览网</a></p>
                    <p><a href="#">民营企业网</a></p>
                    <p><a href="#">中国航空新闻网</a></p>
                    <p><a href="#">北极星电力网</a></p>
                </li>
            </ul>

        </div>
        <div class="foottoprg">
            <div class="erwm" >
                <h4>下载安虫app客户端</h4>
                <img src="{{asset('home/images/mine/1.jpg')}}">
            </div>
            <div class="mmm">
                <h4>安虫微信订阅号</h4>
                <img src="{{asset('home/images/mine/2.jpg')}}">
            </div>

        </div>
    </div>
</div>
<hr class="fff">

<div class="footdown">
    <div class="footdown-1">


        <div class="ddd">
            <p><a href="#">关于安虫</a><span>|</span>
                <a href="#">联系我们</a><span>|</span>
                <a href="#">帮助中心</a><span>|</span>
                <a href="#">服务网点</a><span>|</span>
                <a href="#">法律声明</a><span>|</span>
                客服热线：400-888-888

            </p>
            <p>Copyright©&nbsp;北京安虫版权所有&nbsp;anchong.net</p>
            <p>京ICP备111111号&nbsp;<span>|</span>&nbsp;出版物经营许可证</p>

        </div>

    </div>
</div>

</body>
</html>
