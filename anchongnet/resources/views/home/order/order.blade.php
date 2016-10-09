<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>我的订单</title>
		<link rel="stylesheet" type="text/css" href="home/css/order.css"/>
		<script src="{{asset('/home/js/jquery-3.1.0.js')}}"></script>
		<script src="{{asset('/home/js/order.js')}}" type="text/javascript" charset="utf-8"></script>
		<link rel="stylesheet" href="{{asset('home/css/top.css')}}">
		<script src="{{asset('home/js/top.js')}}"></script>
	</head>
	<body>
	@include('inc.home.top')
		<div class="site-header">
			<div class="header-container">
				<img src="home/images/order/logo.png"/>
				<ul class="header-nav">
					<li><a href="">首页</a></li>
					<li><a href="">个人资料</a></li>
					<li><a href="">消息</a></li>
				</ul>
			</div>
		</div>
		<div class="site-middle">
			<div class="middle-container">
				<div class="my-info">
					<img src="home/images/order/tx.jpg"/>
					<ul class="my-mesg">
						<li>风信子</li>
						<li>QQ：1092554920</li>
						<li>邮箱：1092554920@qq.com</li>
					</ul>
					<ul class="my-info-list">
						<li class="my-publish">
							我的发布
							<span class="triangle"></span>
							<div>
								<p><a href="">评价</a></p>
								<p><a href="">提问</a></p>
								<p><a href="">帖子</a></p>
							</div>
						</li>
						<li class="my-favorite">
							我的收藏
							<span class="triangle"></span>
							<div>
								<p><a href="">店铺</a></p>
								<p><a href="">商品</a></p>
								<p><a href="">社区</a></p>
							</div>
						</li>
						<li class="my-order">
							我的订单
							<span class="triangle"></span>
							<div>
								<p><a href="">所有订单</a></p>
								<p><a href="">待付款</a></p>
								<p><a href="">待发货</a></p>
								<p><a href="">待收货</a></p>
								<p><a href="">售后</a></p>
							</div>
						</li>
						<li><a href="">商铺申请</a></li>
						<li><a href="">商家认证</a></li>
					</ul>
				</div>
				<div class="information">
					<div class="information-nav">
						<ul>
							<li class="all-order"><a href="">所有订单</a></li>
							<li><a href="">待付款</a></li>
							<li><a href="">待发货</a></li>
							<li><a href="">待收货</a></li>
							<li><a href="">售后</a></li>
							<div class="cl"></div>
						</ul>
					</div>
					<div class="show-nav">
						<span class="goods">
							商品
						</span>
						<ul class = "order-info">
							<li>单价（元）</li>
							<li>数量</li>
							<li>商品操作</li>
							<li>总价（元）</li>
							<li>
								交易状态
								<span class="triangle1"></span>
							</li>
						</ul>
					</div>
					<div class="pages">
						<div class="pages-container">
							<a href="">
								<span class="up"><</span>
								<span class="up-page">上一页</span>
							</a>
							<a href="">
								<span class="down-page">下一页</span>
								<span class="down">></span>
							</a>
						</div>
						<div class="cl"></div>
					</div>
					<div class="show-list">
						<ul class="order-desc">
							<li class="show-title">
								<span class="d-title"><a href="">小白菜的店</a></span>
								<span class="order-id">订单号：2011860830092415</span>
								<span class="c-seller"><a href="">联系卖家</a></span>
								<span class="del"><a href="">删除</a></span>
							</li>
							<li class="show-desc">
								<ul>
									<li>
										<img class="g-img" src="home/images/order/goods.jpg"/>
									</li>
									<li>
										<h5 class="g-title">普通一拓扑达 普通双磁力锁停车管理系统</h5>
										<span class="g-desc">白色：#94574</span>
									</li>
									<li class="g-price">130</li>
									<li class="g-num">10</li>
									<li class="refund">申请退款</span>
									</li>
									<li class="all-price">1300</li>
									<li class="trade-desc">
										<p class="trade">交易成功</p>
										<p class="order-detail">交易详情</p>
									</li>
								</ul>
							</li>
							<li class="show-desc1">
								<ul>
									<li>
										<img class="g-img" src="home/images/order/goods.jpg"/>
									</li>
									<li>
										<h5 class="g-title">普通一拓扑达 普通双磁力锁停车管理系统</h5>
										<span class="g-desc">白色：#94574</span>
									</li>
									<li class="g-price">130</li>
									<li class="g-num">10</li>
									<li class="refund">申请退款</span>
									</li>
									<li class="all-price">1300</li>
									<li class="trade-desc">
										<p class="trade">交易成功</p>
										<p class="order-detail">交易详情</p>
									</li>
								</ul>
							</li>
							<li class="show-desc1">
								<ul>
									<li>
										<img class="g-img" src="home/images/order/goods.jpg"/>
									</li>
									<li>
										<h5 class="g-title">普通一拓扑达 普通双磁力锁停车管理系统</h5>
										<span class="g-desc">白色：#94574</span>
									</li>
									<li class="g-price">130</li>
									<li class="g-num">10</li>
									<li class="refund">申请退款</span>
									</li>
									<li class="all-price">1300</li>
									<li class="trade-desc">
										<p class="trade">交易成功</p>
										<p class="order-detail">交易详情</p>
									</li>
								</ul>
							</li>
						</ul>
						<ul class="order-desc1">
							<li class="show-title">
								<span class="d-title"><a href="">小白菜的店</a></span>
								<span class="order-id">订单号：2011860830092415</span>
								<span class="c-seller"><a href="">联系卖家</a></span>
								<span class="del"><a href="">删除</a></span>
							</li>
							<li class="show-desc">
								<ul>
									<li>
										<img class="g-img" src="home/images/order/goods.jpg"/>
									</li>
									<li>
										<h5 class="g-title">普通一拓扑达 普通双磁力锁停车管理系统</h5>
										<span class="g-desc">白色：#94574</span>
									</li>
									<li class="g-price">130</li>
									<li class="g-num">10</li>
									<li class="refund">申请退款</span>
									</li>
									<li class="all-price">1300</li>
									<li class="trade-desc">
										<p class="trade">交易成功</p>
										<p class="order-detail">交易详情</p>
									</li>
								</ul>
							</li>
							<li class="show-desc1">
								<ul>
									<li>
										<img class="g-img" src="home/images/order/goods.jpg"/>
									</li>
									<li>
										<h5 class="g-title">普通一拓扑达 普通双磁力锁停车管理系统</h5>
										<span class="g-desc">白色：#94574</span>
									</li>
									<li class="g-price">130</li>
									<li class="g-num">10</li>
									<li class="refund">申请退款</span>
									</li>
									<li class="all-price">1300</li>
									<li class="trade-desc">
										<p class="trade">交易成功</p>
										<p class="order-detail">交易详情</p>
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
				<div class="cl"></div>
			</div>
		</div>
		@include('inc.home.site-foot')
	</body>
</html>
