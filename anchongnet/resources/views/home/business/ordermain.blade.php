<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>人才详情</title>
    <link rel="stylesheet" href="../home/css/rencaixq.css">
    <script src="../home/js/jquery-3.0.0.min.js"></script>

</head>
<body>
<div class="nav-top">
    <div class="centerbar">

        <div class="navmain">
            <ul>
                <li>邮箱：www.@anchong.net</li>
                <li>垂询电话:0317-8155026</li>
                <li><img src="../home/images/zhaohuo/6.jpg" alt=""></li>
                <li style="padding-left: 10px;"><a href="#">风信子<b class="caret"></b></a></li>
            </ul>
        </div>
    </div>
</div>
<div class="header-center">
    <div class="header-main">
        <div class="logo">
            <img src="../home/images/zhaohuo/7.jpg" alt="">
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
                <li><a href="#">首页</a></li>
                <li><a href="#">商机<img src="../home/images/zhaohuo/9.jpg" alt=""></a></li>
                <li><a href="#">社区<img src="../home/images/zhaohuo/9.jpg" alt=""></a></li>
                <li><a href="#">设备选购<img src="../home/images/zhaohuo/9.jpg" alt="" style="left: 70px;"></a></li>
                <li><a href="#">资讯</a></li>
            </ul>
        </div>

    </div>

</div>
<div style="clear: both"></div>
<hr class="nav-underline">

<div class="main">
    <div class="submain">

            <div class="main-left">
                <img src="{{$data->img}}" alt="">
                <h4>{{$data->contact}}</h4>
                <p>服务类别：{{$data->title}}</p>
                <p>服务区域：{{$data->tag}}</p>
                <p>联系方式：<a href="#">认证后可查看联系方式</a></p>
            </div>
            <div class="main-right">
                <h4>个人介绍</h4>
                <div class="main-right-content">
                    <p>
                   {!! $data->content !!}
                    </p>
                </div>
            </div>

    </div>
</div>




<div class="foottop">
    <div class="foottop-1">
        <div class="foottoplf">
            <div class="link"><h4>友情链接</h4>
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
            <div class="rqcode-app" >
                <h4>下载安虫app客户端</h4>
                <img src="../home/images/zhaohuo/1.jpg">
            </div>
            <div class="rqcode-wx">
                <h4>安虫微信订阅号</h4>
                <img src="../home/images/zhaohuo/2.jpg">
            </div>

        </div>
    </div>
</div>
<hr class="downline">

<div class="footdown">
    <div class="footdown-1">


        <div class="about">
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