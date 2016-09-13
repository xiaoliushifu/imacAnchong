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
					<a href="{{url('/')}}"><img src="home/images/business/logo.jpg"/></a>
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
						<li class="equipment nav-item"><a href="{{url('/business')}}">设备选购</a></li>
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
		@include('inc.home.site-foot')
	</body>
</html>
