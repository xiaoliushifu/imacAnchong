<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>商机详情</title>
		<link rel="stylesheet" type="text/css" href="home/css/porject-desc.css"/>
		<script src="{{asset('home/js/jquery-3.0.0.js')}}"></script>
		<script src="{{asset('home/js/talent.js')}}" type="text/javascript" charset="utf-8"></script>
	</head>
	<body>
		<div class="site-top">
			<div class="top-container">
				<ul class="info">
					<li class="mail">邮箱：<a href="mailto:www@anchong.net">www@anchong.net</a></li>
					<li class="tel">垂询电话：0317-8155026</li>
					<li>
						<img class="little-tx" src="home/images/business/tx.jpg"/>
						<span class="userinfo">
							{{session('name')}}
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
					<img src="home/images/business/logo.jpg"/>
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
			<div class="middle-container">
				<div class="publisher">
				<ul>
					<li><img src="home/images/business/tx.jpg"/></li>
					<li class="publisher-name">李先生</li>
					<li class="server-type">
						服务类型：建筑防爆
					</li>
					<li class="server-area">
						服务区域：湖南常德
					</li>
					<li class="contact">
						<span class="contact-tel">联系电话：</span>
						<span class="contact-info">认证后可查看联系方式</span>
					</li>
				</ul>
			</div>
			<div class="project-detail">
				<h2 class="project-title">湖南常德万达广场建设安防系统招标</h2>
				<span class="type">建筑防爆</span>
				<span class="area">湖南常德</span>
				<p class="publish-time">
					发布于
					<span class="">2016-4-13&nbsp;11:35</span>
				</p>
				<ul class="project-desc">
					<h5>一、项目概况</h5>
					<li>项目所属行业：建筑房地产</li>
					<li>所属领域类型：办公楼、商业楼</li>
					<li>设备来源：国内采购</li>
					<li>预算投资总额：150000万元</li>
					<li>投资性质：非政府投资</li>
					<li>资金到位情况：已到位</li>
					<li>项目建设等级：行业中等标准</li>
				</ul>
				<ul class="construction">
					<h5>二、施工期间</h5>
					<li>坐在酿造忧愁的酒馆里&nbsp;谁闭着眼&nbsp;坐在没有星光的灯火阑珊&nbsp;与黑夜缠绵 拨开时光的脸&nbsp;坐在酿造忧愁的酒馆里&nbsp;
						谁闭着眼&nbsp;坐在没有星光的灯火阑珊&nbsp;与黑夜缠绵 拨开时光的脸</li>
					<li><img src="home/images/business/image1.jpg"/></li>
					<li><img src="home/images/business/image1.jpg"/></li>
					<li><img src="home/images/business/image1.jpg"/></li>
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
