<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>个人中心</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="home/css/boot.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="home/css/pcenter.css">
</head>
<body>
<div class="hedtou">
    <div class="container ttop">
        <nav class="navbar navbar-default rossa " role="navigation" >
            <div class="navbar-header">
                <button type="button" class="navbar-toggle " data-toggle="collapse"
                        data-target="#example-navbar-collapse" style="margin: 0px;">
                    <span class="sr-only">切换导航</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

            </div>
            <div class="collapse navbar-collapse row" id="example-navbar-collapse">
                <div class="col-md-2 shouy"><a href="#">安虫首页</a></div>
                <div class="col-md-10">
                <ul class="nav navbar-nav navbar-right daohang" style="padding-top: 3px;">

                    <li>邮箱：www@anchong.net</li>
                    <li>购物车 <span class="glyphicon glyphicon-shopping-cart"></span></li>
                    <li class="active">咨询电话：010-888888</li>
                    <li><img class="img-circle" src="{{$msg->headpic}}"></li>
                    <li class="dropdown" style="margin-left: 10px;">
                        <a href="#" class="dropdown-toggle yhm" data-toggle="dropdown">
                           {{$msg->nickname}}<b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu text-center">
                            <li><a href="#"  class="text-center">个人资料</a></li>
                            <li><a href="#"  class="text-center">购物车</a></li>
                            <li><a href="{{url('/quit')}}"  class="text-center">退出</a></li>
                        </ul>
                    </li>

                </ul>
                </div>
            </div>
        </nav>
    </div>

</div>
<!-- 个人中心四个大字 -->
<div class="topone">
    <div class="topone-1">
        <div class="topone-2">
            <img src="home/images/pcenter/p60.jpg" alt="">
        </div>
        <div class="topone-3">
            <ul>
                <li  class="ppp"><a href="{{url('pcenter')}}" >首页</a><img src="home/images/pcenter/pup.png" alt=""> </li>
                <li  class="ppp"><a href="{{url('/basics')}}" >个人资料</a><img src="home/images/pcenter/pup.png" alt=""> </li>
                <li  class="ppp"><a href="{{url('/servermsg')}}" >消息</a><img src="home/images/pcenter/pup.png" alt=""> </li>
                <li  class="ppp"><a href="#" >其他更多吧</a><img src="home/images/pcenter/pup.png" alt=""> </li>
            </ul>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-lg-3">
            <div class="col-lg-12 topll">
            	<!-- 美女一个 -->
                <img src="home/images/pcenter/p61.jpg" alt="">
                <p>风信子</p>
                <p>QQ：888888888888</p>
                <p>邮箱：88888888888@qq.com</p>
            </div>
            <!-- 左侧导航区 -->
            <div class="col-lg-12 toppp">
                <ul class="list-unstyled text-center">
                    <li><a href="javascript:" class="inactive">我的发布<b class="caret"></b></a>
                        <ul class="list-unstyled ttt" style="display: none">
                        		<hr>
                            <li><a href="{{url('/conwork')}}" class="item">发包工程</a></li>
                            <li><a href="{{url('/gc')}}" class="item">承接工程</a></li>
                            <li><a href="{{url('reorder')}}" class="item">发布人才</a></li>
                            <li><a href="{{url('')}}" class="item">人才自荐</a></li>
                            <li><a href="#" class="inactive active item">找货</a></li>
                        </ul>
                    </li>
                    <hr>
                    <li><a href="javascript:" class="inactive">我的收藏<b class="caret"></b></a>
                      <ul class="list-unstyled ttt" style="display: none">
                          <hr>
                          <li><a href="{{url('/colgoods')}}" class="item">商品</a></li>
                          <li><a href="{{url('/colshop')}}" class="item">商铺</a></li>
                          <li><a href="{{url('/colcommunity')}}" class="item">社区</a></li>
                      </ul>
                    </li>
                    <hr>
                    <li><a href="javascript:" class="inactive">我的订单<b class="caret"></b></a>
                        <ul class="list-unstyled ttt" style="display: none">
                            <hr>
                            <li><a href="#" class="inactive active">美协机关</a>

                            </li>
                            <li><a href="#" class="inactive active">中国文联美术艺术中心</a>

                        </ul>

                    </li>
                    <hr>
                    <li><a href="#">我的钱袋</a></li>
                    <hr>
                    <li><a href="#">虫虫粉丝</a></li>
                    <hr>
                    <li><a href="{{url('/applysp')}}">商铺申请</a></li>
                    <hr>
                    <li><a href="{{url('/honor')}}">商家认证</a></li>
                    <hr>
                </ul>
            </div>
        </div>
        <!-- 主要内容区 -->
        <div class="col-lg-9 daxie">
            <div class="col-lg-12 daomain">
                <ul class="list-unstyled list-inline">
                    <li><a href="{{url('/conwork')}}">发包工程</a></li>
                    <li><a href="{{url('/gc')}}">承接工程</a></li>
                    <li><a href="{{url('/reorder')}}">发布人才</a></li>
                </ul>
            </div>
            <!-- 内容 -->
            <div class="col-lg-12 contmain">
                <ul class="list-inline list-unstyled">
                    <li>
                        	<a href="#">
                            		<img src="home/images/pcenter/p62.jpg" alt="">
                            		<p><strong>普通ddd拓扑达&nbsp;&nbsp;普通双磁力锁停车管理系统</strong></p>
                        	</a>
                        <p style="font-size: 20px;color: #f53745;">￥130.00</p>
					</li>
                    <li>
                        	<a href="#">
                            		<img src="home/images/pcenter/p62.jpg" alt="">
                            		<p><strong>普通ddd拓扑达&nbsp;&nbsp;普通双磁力锁停车管理系统</strong></p>
                        	</a>
                        <p style="font-size: 20px;color: #f53745;">￥130.00</p>
					</li>
                    <li>
                        	<a href="#">
                            		<img src="home/images/pcenter/p62.jpg" alt="">
                            		<p><strong>普通ddd拓扑达&nbsp;&nbsp;普通双磁力锁停车管理系统</strong></p>
                        	</a>
                        <p style="font-size: 20px;color: #f53745;">￥130.00</p>
					</li>
                    <li>
                        	<a href="#">
                            		<img src="home/images/pcenter/p62.jpg" alt="">
                            		<p><strong>普通ddd拓扑达&nbsp;&nbsp;普通双磁力锁停车管理系统</strong></p>
                        	</a>
                        <p style="font-size: 20px;color: #f53745;">￥130.00</p>
					</li>
                </ul>
            </div>
        </div>
    </div>
</div>
{{--通用底部--}}
@include('inc.home.foot')
<script src="home/js/jquery-3.1.0.min.js"></script>
<script src="home/js/bootstrap.min.js"></script>
<script src="home/js/pcenter.js"></script>
</body>
</html>