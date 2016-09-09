<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>资讯</title>
    <link rel="stylesheet" type="text/css" href="{{url('../home/css/information.css')}}"/>
</head>
<body>
<div class="site-top">
    <div class="top-container">
        <ul class="info">
            <li class="mail">邮箱：<a href="mailto:www.anchong.net">www@anchong.net</a></li>
            <li class="tel">垂询电话：0317-8155026</li>
            <li>
                <img class="little-tx" src="{{url('/home/images/business/tx.jpg')}}"/>
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
            <a href="{{url('/')}}"><img src="{{url('/home/images/logo.jpg')}}"/></a>
        </div>
        <div class="search">
            <form class="search-form" method="post">
                <input type="text" name="search" class="search-text"/>
                <input type="submit" value="搜索" class="search-btn"/>
            </form>
        </div>
        <div class="cl"></div>
        <div class="site-nav">
            <ul class="navigation">
                <li class="home nav-item"><a href="{{url('/')}}">首页</a></li>
                <li class="business nav-item">
                    <a href="{{url('/business')}}">商机</a>
                    <span class="business-triangle"></span>
                    <div class="business-list">
                        <p><a href="">工程</a></p>
                        <p><a href="">人才</a></p>
                        <p><a href="">找货</a></p>
                    </div>
                </li>
                <li class="community nav-item"><a href="{{url('/community')}}">社区</a></li>
                <li class="equipment nav-item"><a href="{{url('')}}">设备选购</a></li>
                <li class="news nav-item"><a href="{{url('/info')}}">资讯</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="site-middle">
    <div class="middle-content">
        <div class="middle-top" style="margin-top: 20px">
            <h3 style="text-align: center">{{$info->title}}</h3>
            <p style="margin-top: 10px">{!! $info->content !!}</p>
        </div>
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
                        <img src="{{url('/home/images/1.jpg')}}"/>
                    </li>
                    <li>
                        <h4>安虫微信订阅号</h4>
                        <img src="{{url('/home/images/2.jpg')}}"/>
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
</html>