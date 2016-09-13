<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>安虫首页</title>
    <link rel="stylesheet" type="text/css" href="home/css/index.css">
</head>
<body>
<div class="site-top">
    <div class="top-container">
        <ul class="info">
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
            <img src="home/images/7.jpg"/>
        </div>
        <div class="search">
            <form class="search-form" method="post">
                <select class="area">
                    <option value="北京">北京</option>
                </select>
                <span class="upright"></span>
                <input type="text" name="search" class="search-text" placeholder="找工程&nbsp;找人才&nbsp;聊生活" />
                <input type="submit" value="搜索" class="search-btn"/>
            </form>
            <ul class="hot-words">
                <li class="hot-word-title">热门搜索：</li>
                <li class="words-item"><a href="">探测监控</a></li>
                <li class="words-item"><a href="">防护保障</a></li>
                <li class="words-item"><a href="">探测警报</a></li>
                <li class="words-item"><a href="">探测监控</a></li>
                <li class="words-item"><a href="">弱电工程</a></li>
            </ul>
        </div>
        <div class="cl"></div>
        <div class="site-nav">
            <ul class="navigation">
                <li class="home nav-item"><a href="{{url('/')}}">首页</a></li>
                <li class="business nav-item">
                    <a href="{{url('/business')}}">商机</a>
                    <span class="business-triangle"></span>
                    <div class="business-list">
                        <p><a href="{{url('/gc')}}">工程</a></p>
<<<<<<< HEAD
                        <p><a href="{{url('/orderlist')}}">人才</a></p>
                        <p><a href="{{url('/fngoods')}}">找货</a></p>
=======
                        <p><a href="{{url('orderlist')}}">人才</a></p>
                        <p><a href="{{url('/sergoods')}}">找货</a></p>
>>>>>>> 1d36002ef5ee52e91ef5a9bc3725df772d72248f
                    </div>
                </li>
                <li class="community nav-item"><a href="{{url('/community')}}">社区</a></li>
                <li class="equipment nav-item"><a href="{{url('/ancself')}}">设备选购</a></li>
                <li class="news nav-item"><a href="{{url('/info')}}">资讯</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="site-middle">
    <div class="middle-cont">
        <ul class="middle-top">
            <li class="banner">
                <div>
                    <img src="home/images/shouyel.png">
                </div>
            </li>
            <li class="tips">
                <div class="notice">
                    <p class="notice-title"><a><img src="home/images/notice.png"></a></p>
                    <div class="notice-info">
                        <p>感谢小伙伴一直以来的支持和喜爱。安虫app于7.25已正式上线，涵盖商城、商机、社区、我的四大模块。安虫，致力为安防行业提供便捷、高效、优质的全面服务。欢迎业内人士交流沟通</p>
                    </div>
                </div>
                <div class="information">
                    <p class="title"><a href=""><img src="home/images/info.png"></a></p>
                    <div class="hot-info">
                        <p><img src="home/images/hot.png"><a href="{{url('/info/'.$info[0]->infor_id)}}">{{$info[0]->title}}</a></p>
                        <p><img src="home/images/hot.png"><a href="{{url('/info/'.$info[1]->infor_id)}}">{{$info[1]->title}}</a></p>
                    </div>
                </div>
            </li>
        </ul>
        <div class="flow">
            <h1>工程流程</h1>
            <ul class="chart">
                <li><a><img src="home/images/66.jpg"></a></li>
                <li><a><img src="home/images/67.jpg"></a></li>
                <li><a><img src="home/images/68.jpg"></a></li>
                <li><a><img src="home/images/69.jpg"></a></li>
                <li><a><img src="home/images/70.jpg"></a></li>
                <li><a><img src="home/images/71.jpg"></a></li>
            </ul>
        </div>
        <div class="recommended">
            <h1>推荐工程</h1>
            <ul class="recommended-list">
                <li class="recommended-left recommend-1">
                    <a href="{{url('pro/'.$hot[0]->bid)}}">
                        <img src="{{$hot[0]->img}}">
                        <p>{{$hot[0]->title}}</p>
                    </a>
                </li>
                <li class="recommended-cnter">
                    <ul>
                        <li class="recommend-2">
                            <a href="{{url('pro/'.$hot[1]->bid)}}">
                                <img src="{{$hot[1]->img}}">
                                <p>{{$hot[1]->title}}</p>
                            </a>
                        </li>
                        <li class="recommend-3">
                            <a href="{{url('pro/'.$hot[2]->bid)}}">
                                <img src="{{$hot[2]->img}}">
                                <p>{{$hot[2]->title}}</p>
                            </a>
                        </li>
                        <li class="recommend-4">
                            <a href="{{url('pro/'.$hot[4]->bid)}}">
                                <img src="{{$hot[3]->img}}">
                                <p>{{$hot[3]->title}}</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="recommend-5 recommended-right">
                    <a href="{{url('pro/'.$hot[4]->bid)}}">
                        <img src="{{$hot[4]->img}}">
                        <p>{{$hot[4]->title}}</p>
                    </a>
                </li>
            </ul>
            <ul class="bottom">
                @foreach($userinfo as $value)
                    <li class="bottom-item">
                        <a>
                            <img src="{{$value -> headpic}}">
                            <p>{{$value -> nickname}}</p>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="server">
            <h1>为您服务</h1>
            <ul>
                <li class="server-item"><a href="{{url('/gc')}}"><img src="home/images/85.jpg"></a></li>
                <li class="server-item"><a href="{{url('/gc')}}"><img src="home/images/86.jpg"></a></li>
                <li class="server-item"><a href="{{url('/talentlist')}}"><img src="home/images/87.jpg"></a></li>
                <li class="server-item1"><a href="{{url('/ancself')}}"><img src="home/images/88.jpg"></a></li>
            </ul>
        </div>
        <div class="hot">
            <h1>热门社区</h1>
            <ul class="hot-top">
                <li class="ad">
                    <a>
                        <img src="home/images/89.jpg">
                    </a>
                </li>
                <li class="bbs">
                    <ul>
                        <li>
                            <h3><a>夏日抹抹茶</a></h3>
                            <p>炎炎夏日，假面舞会，撩你❤798约起来！</p>
                        </li>
                        <li>
                            <h3><a>永远年轻，永远热泪盈眶</a></h3>
                            <p>炎炎夏日，假面舞会，撩你❤798约起来！</p>
                        </li>
                        <li>
                            <h3><a>想行动，永远都不会玩</a></h3>
                            <p>炎炎夏日，假面舞会，撩你❤798约起来！</p>
                        </li>
                    </ul>
                </li>
                <li class="talent-cont">
                    <p class="talent-nav">
                    <h3>人才招聘</h3>
                    <h3>人才自荐</h3>
                    </p>
                    <p class="talent-item">
                        <span class="region">区域</span>
                        <span class="talent">人才</span>
                    </p>
                    @foreach($talent as $value)
                    <p class="talent-item">
                        <a href="{{url('/talentlist')}}" class="district">{{$value -> tags}}</a>
                        <a href="{{url('/talent/'.$value->bid)}}" class="talent-name">{{$value -> contact}}</a>
                    </p>
                    @endforeach
                </li>
            </ul>
            <ul class="bottom">
                @foreach($userinfo as $value)
                <li class="bottom-item">
                    <a>
                        <img src="{{$value -> headpic}}">
                        <p>{{$value -> nickname}}</p>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="goods">
            <h1>安防百货</h1>
            <div class="goods-nav">
                <ul class="good-nav">
                    <li><a href="">门禁控制器</a></li>
                    <li><a href="">视频监控</a></li>
                    <li><a href="">探测报警</a></li>
                    <li><a href="">巡更巡警</a></li>
                    <li><a href="">门禁锁</a></li>
                    <li><a href="">智能消费</a></li>
                    <li><a href="">快速通道</a></li>
                    <li><a href="">更多</a></li>
                </ul>
            </div>
            <ul class="goods-cont">
                <li class="goods-left">
                    <ul>
                        <li class="classify">
                            <h3>八大类<i class="icon"></i></h3>
                            <ul>
                                <li><a href="">智能门禁</a></li>
                                <li><a href="">停车管理</a></li>
                                <li><a href="">探测报警</a></li>
                                <li><a href="">巡更巡警</a></li>
                                <li><a href="">安防配套</a></li>
                                <li><a href="">楼宇对讲</a></li>
                            </ul>
                        </li>
                        <li class="top-search">
                            <h3>热搜榜<i class="icon1"></i></h3>
                            <ul>
                                <li><a href="">门禁</a></li>
                                <li><a href="">魔士龙</a></li>
                                <li><a href="">魔士龙</a></li>
                                <li><a href="">摄像头</a></li>
                                <li><a href="">停车管理</a></li>
                                <li><a href="">停车管理</a></li>
                                <li><a href="">监控器</a></li>
                                <li><a href="">安防配套</a></li>
                                <li><a href="">安防配套</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="goods-center">
                    <div><img src="home/images/91.jpg"></div>
                </li>
                <li class="goods-right">
                    <ul>
                        <li>
                            <img src="home/images/92.jpg">
                            <p>
                                <a class="goods-classify" href="">[Oulin/欧林]</a>
                                <a class="goods-title" href="">欧林水槽双槽&nbsp;&nbsp;不锈钢厨</a>
                            </p>
                            <p class="goods-price">
                                价格：￥180
                            </p>
                        </li>
                        <li>
                            <img src="home/images/93.jpg">
                            <p>
                                <a class="goods-classify" href="">[Oulin/欧林]</a>
                                <a class="goods-title" href="">欧林水槽双槽&nbsp;&nbsp;不锈钢厨</a>
                            </p>
                            <p class="goods-price">
                                价格：￥180
                            </p>
                        </li>
                        <li>
                            <img src="home/images/94.jpg">
                            <p>
                                <a class="goods-classify" href="">[Oulin/欧林]</a>
                                <a class="goods-title" href="">欧林水槽双槽&nbsp;&nbsp;不锈钢厨</a>
                            </p>
                            <p class="goods-price">
                                价格：￥180
                            </p>
                        </li>
                        <li>
                            <img src="home/images/95.jpg">
                            <p>
                                <a class="goods-classify" href="">[Oulin/欧林]</a>
                                <a class="goods-title" href="">欧林水槽双槽&nbsp;&nbsp;不锈钢厨</a>
                            </p>
                            <p class="goods-price">
                                价格：￥180
                            </p>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="goods-bottom">
                <li><a href=""><img src="home/images/96.jpg"></a></li>
                <li><a href=""><img src="home/images/97.jpg"></a></li>
                <li><a href=""><img src="home/images/98.jpg"></a></li>
                <li><a href=""><img src="home/images/99.jpg"></a></li>
                <li><a href=""><img src="home/images/100.jpg"></a></li>
                <li><a href=""><img src="home/images/101.jpg"></a></li>
            </ul>
        </div>
        <div class="exhibition">
            <h1>展会活动</h1>
            <ul>
                <li><a href=""><img src="home/images/102.jpg"></a></li>
                <li><a href=""><img src="home/images/103.jpg"></a></li>
                <li><a href=""><img src="home/images/104.jpg"></a></li>
                <li><a href=""><img src="home/images/105.jpg"></a></li>
            </ul>
        </div>
        <div class="cooperative">
            <h1>合作企业</h1>
            <ul>
                <li><a href=""><img src="home/images/106.jpg"></a></li>
                <li><a href=""><img src="home/images/107.jpg"></a></li>
                <li><a href=""><img src="home/images/108.jpg"></a></li>
                <li><a href=""><img src="home/images/109.jpg"></a></li>
                <li><a href=""><img src="home/images/110.jpg"></a></li>
                <li><a href=""><img src="home/images/111.jpg"></a></li>
                <li><a href=""><img src="home/images/112.jpg"></a></li>
                <li><a href=""><img src="home/images/113.jpg"></a></li>
            </ul>
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
