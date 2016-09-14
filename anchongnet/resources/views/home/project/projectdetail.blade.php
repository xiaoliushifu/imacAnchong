<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>工程详情</title>
    <link rel="stylesheet" type="text/css" href="/home/css/talent-desc.css"/>
    <script src="/home/js/jquery-3.1.0.min.js"></script>
    <script src="/home/js/talent-desc.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>
<div class="site-top">
    <div class="top-container">
        <ul class="info">
            <li class="mail">邮箱：<a href="mailto:www@anchong.net">www@anchong.net</a></li>
            <li class="tel">垂询电话：0317-8155026</li>
            <li>
                <img class="little-tx" src="/home/images/gongchengxq/tx.jpg"/>
						<span class="userinfo">
							风信子
							<span class="info-triangle"></span>
							<div class="cart">
                                <p><a href="">购物车</a></p>
                                <p><a href="">收藏夹</a></p>
                            </div>
						</span>
            </li>
        </ul>
    </div>
</div>
<div class="header">
    <div class="header-container">
        <div class="logo">
            <a href="{{url('/')}}">
                <img src="/home/images/gongchengxq/logo.jpg"/>
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
                <li class="home"><a href="{{url('/')}}">首页</a></li>
                <li class="business">
                    <a href="{{url('/business')}}">商机</a>
                    <span class="business-triangle"></span>
                    <div class="business-list">
                        <p><a href="{{url('/project')}}">工程</a></p>
                        <p><a href="">人才</a></p>
                        <p><a href="">找货</a></p>
                    </div>
                </li>
                <li class="community">社区</li>
                <li class="equipment"><a href="{{url('/equipment')}}">设备选购</a></li>
                <li class="news"><a href="{{url('/info')}}">资讯</a></li>
                <div class="cl"></div>
            </ul>
        </div>
    </div>
</div>
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
                    <span class="contact-info">认证后可查看联系方式</span>
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
<div class="site-footer">
    <div class="footer-top">
        <div class="footer-top-container">
            <div class="link">
                <h4>友情链接</h4>
                <hr class="line" />
                <div class="link-list">
                    <p><a href="">中国安防行业网</a></p>
                    <p><a href="">华强安防网</a></p>
                    <p><a href="">中国安防展览网</a></p>
                    <p><a href="">安防英才网</a></p>
                </div>
                <div class="link-list1">
                    <p><a href="">智能交通网</a></p>
                    <p><a href="">中国智能化</a></p>
                    <p><a href="">中关村在线</a></p>
                    <p><a href="">教育装备采购网</a></p>
                </div>
                <div class="link-list1">
                    <p><a href="">中国贸易网</a></p>
                    <p><a href="">华强电子网</a></p>
                    <p><a href="">研究报告中国测控网</a></p>
                    <p><a href="">五金机电网</a></p>
                </div>
                <div class="link-list1">
                    <p><a href="">中国安防展览网</a></p>
                    <p><a href="">民营企业网</a></p>
                    <p><a href="">中国航空新闻网</a></p>
                    <p><a href="">北极星电力</a></p>
                </div>
            </div>
            <div class="qr-code">
                <ul>
                    <li>
                        <h4>下载安虫APP客户端</h4>
                        <img src="/home/images/gongchengxq/app.jpg"/>
                    </li>
                    <li>
                        <h4>安虫微信订阅号</h4>
                        <img src="/home/images/gongchengxq/dyh.jpg"/>
                    </li>
                    <div class="cl"></div>
                </ul>
            </div>
            <div class="cl"></div>
        </div>
    </div>
    <div class="site-bottom">
        <div class="btottom">
            <div class="bottom-container">
                <p class="p1">
                    <a href="">关于安虫</a>
                    <span class="">|</span>
                    <a href="">联系我们</a>
                    <span class="">|</span>
                    <a href="">帮助中心</a>
                    <span class="">|</span>
                    <a href="">服务网点</a>
                    <span class="">|</span>
                    <a href="">法律声明</a>
                    <span class="">|</span>
                    客服热像400-888-888
                </p>
                <p class="p2">Copyright©北京安虫版权所有 anchong.net</p>
                <p class="p3">
                    <a href="">京ICP备111111号</a>
                    <span class="">|</span>
                    <a href="">出版物经营许可证</a>
                </p>
            </div>
        </div>
    </div>
</div>
</body>
{{--<script>--}}
    {{--$(function(){--}}
        {{--var li = "";--}}
        {{--var data = ['','ceshi1','ceshi2','ceshi3']--}}
        {{--for(i=0;i<data.length;i++){--}}
            {{--li +="<li>"+data[i]+"</li>";--}}
        {{--}--}}
        {{--$(".navigation>li").click(function(){--}}
            {{--$(this).html(li);--}}
        {{--})--}}
    {{--})--}}
{{--</script>--}}
</html>
