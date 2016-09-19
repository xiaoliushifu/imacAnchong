<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>资讯</title>
    <link rel="stylesheet" type="text/css" href="home/css/information.css"/>
</head>
<body>
<div class="site-top">
    <div class="top-container">
        <ul class="info">
            <li class="mail">邮箱：<a href="mailto:www.anchong.net">www@anchong.net</a></li>
            <li class="tel">垂询电话：0317-8155026</li>
            <li>
                <a href="{{url('/user/login')}}">登陆</a>/<a href="{{url('/user/register')}}">注册</a>
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
                <li class="equipment nav-item"><a href="{{url('/equipment')}}">设备选购</a></li>
                <li class="news nav-item"><a href="{{url('/info')}}">资讯</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="site-middle">
    <div class="middle-content">
        <ul class="middle-top">
            <li class="carousel">
                <div class="banner">
                    <img src="home/images/info/01.png">
                </div>
            </li>
            <li class="share">
                <ul>
                    <li class="share-title">
                        <h2>干货分享</h2>
                        <i>More</i>
                        <a href="{{url('/info/create')}}"><img src="home/images/info/upload.png"></a>
                    </li>
                    <span class="parting"></span>
                    <li class="share-item">
                        <a  class="download" href=""><img src="home/images/info/download.png"></a>
                        <a class="preview" href=""><img src="home/images/info/preview.png"></a>
                        《光线振动入侵探测器技术要求》标准下载
                    </li>
                    <li class="share-item">
                        <a class="download" href=""><img src="home/images/info/download.png"></a>
                        <a class="preview" href=""><img src="home/images/info/preview.png"></a>
                        监控摄像机常见知识及特性介绍（附PDF下载）
                    </li>
                    <li class="share-item">
                        <a class="download" href=""><img src="home/images/info/download.png"></a>
                        <a class="preview" href=""><img src="home/images/info/preview.png"></a>
                        降低大规模智能监控系统的建筑成本
                    </li>
                    <li class="share-item">
                        <a class="download" href=""><img src="home/images/info/download.png"></a>
                        <a class="preview" href=""><img src="home/images/info/preview.png"></a>
                        监控摄像机常见知识及特性介绍（附PDF下载）
                    </li>
                    <li class="share-item">
                        <a class="download" href=""><img src="home/images/info/download.png"></a>
                        <a class="preview" href=""><img src="home/images/info/preview.png"></a>
                        IP监控系统协议标准（附PDF下载）
                    </li>
                    <li class="share-item">
                        <a class="download" href=""><img src="home/images/info/download.png"></a>
                        <a class="preview" href=""><img src="home/images/info/preview.png"></a>
                        监控摄像机常见知识及特性介绍（附PDF下载）
                    </li>
                    <li class="share-item">
                        <a class="download" href=""><img src="home/images/info/download.png"></a>
                        <a class="preview" href=""><img src="home/images/info/preview.png"></a>
                        监控摄像机常见知识及特性介绍（附PDF下载）
                    </li>
                    <li class="share-item">
                        <a class="download" href=""><img src="home/images/info/download.png"></a>
                        <a class="preview" href=""><img src="home/images/info/preview.png"></a>
                        降低大规模智能监控系统的建筑成本
                    </li>
                    <li class="share-item">
                        <a class="download" href=""><img src="home/images/info/download.png"></a>
                        <a class="preview" href=""><img src="home/images/info/preview.png"></a>
                        监控摄像机常见知识及特性介绍（附PDF下载）
                    </li>
                    <li class="share-item">
                        <a class="download" href=""><img src="home/images/info/download.png"></a>
                        <a class="preview" href=""><img src="home/images/info/preview.png"></a>
                        IP监控系统协议标准（附PDF下载）
                    </li>
                </ul>
            </li>
        </ul>
        <div class="information-content">
            <h2>资讯</h2>
            <span class="parting-line"></span>
            <ul>
                <li>
                    <ul class="info-nav">
                        <li class="rank">
                            <a class="order">排序</a>
                            <a class="hot-order"> 热门排序</a>
                        </li>
                        <li class="paging">
                            <a class="pageup"><img src="home/images/pageup.png"></a>
                            <a class="pagedown"><img src="home/images/pagedown.png"></a>
                        </li>
                    </ul>
                </li>
                @foreach($info as $v)
                <li class="info-item">
                    <ul>
                        <a href="{{url('/info/'.$v->infor_id)}}">
                        <li class="info-desc">
                            <h3>{{$v-> title}}</h3>
                            <p><?php
                                    $str = strip_tags($v->content);
                                    $str1 = mb_substr($str,20,100,'utf-8');
                                    echo $str1;
                                ?></p>
                        </li>
                        <li>
                            <img src="{{$v-> img}}">
                        </li>
                        </a>
                        <span class="info-parting"></span>
                    </ul>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="pages">
            {!! $info->links() !!}
            <ul class="page-skip">
                <i>共有{{$info->lastpage()}}页，</i>
                <i class="blank">
                    去第
                    <input class="page-num" type="text">
                    页
                </i>
                <input class="page-btn" type="button" value="确定">
            </ul>
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
                        <img src="home/images/1.jpg"/>
                    </li>
                    <li>
                        <h4>安虫微信订阅号</h4>
                        <img src="home/images/2.jpg"/>
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