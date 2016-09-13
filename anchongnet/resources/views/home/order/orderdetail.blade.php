<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>订单详情</title>
		<link rel="stylesheet" type="text/css" href="home/css/orderdetail.css"/>
		<script src="home/js/jquery-3.0.0.js"></script>
		<script src="home/js/orderdetail.js" type="text/javascript" charset="utf-8"></script>
	</head>
	<body>
		<div class="site-top">
			<div class="top-container">
				<ul class="info">
					<li class="mail">邮箱：<a href="mailto:www@anchong.net">www@anchong.net</a></li>
					<li class="tel">垂询电话：0317-8155026</li>
					<li>
						<img class="little-tx" src="home/images/order/tx.jpg"/>
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
		<div class="site-header">
			<div class="header-container">
				<a href="{{url('/')}}"><img src="home/images/order/logo.jpg"/></a>
			</div>
		</div>
		<div class="site-middle">
			<div class="middle-container">
				<div class="middle-top">
					<i class="site-location">您的位置:</i>
					<a href="{{url('/')}}"><i class="home">首页</i></a>
					<span class =connector"">></span>
					<a href="{{url('/pcenter')}}"><i class="personal">我的个人中心</i></a>
					<span class ="connector">></span>
					<a href="{{url('/order')}}"><i class="owner-order">我的订单</i></a>
					<span class ="connector">></span>
					<i class = "order-detail">订单详情</i>
				</div>
				<div class="order-stauts">
					<img src="home/images/order/order-status4.png"/>
				</div>
				<div class="item">
					<ul class="line-item">
						<li class="item-title"><h4>订单信息</h4></li>
						<li class="consignee">收货人：韩师傅</li>
						<li class="telphone">联系电话：13388888888</li>
						<li class="add">收货地址：北京市昌平区沙河镇于辛庄村天利家园C300</li>
						<li class="order-id">订单号：2011860830092415</li>
						<li class="order-time">下单时间：2016-07-04 15:00:58</li>
						<span class="parting"></span>
						<span class="shop-name"><a href="">小白白的店</a></span>
						<span class="c-seller"><a href="">联系卖家</a></span>
					</ul>
					<ul class="order-info">
						<li class="order-state">
							<img src="home/images/order/sucessed.png"/>
							订单状态：交易成功
						</li>
						<li class="logistics">物流：安虫物流</li>
						<li class="waybill">运单号：50286811309603</li>
						<li class="receiving">收货时间:2016-07-04 15:00:38</li>
						<li class="invoice">
							<span class="type">发票类型：个人电子发票</span>
							<span class="download"><a href="">下载</a></span>
						</li>
						<li class="invoice-title">发票抬头：个人</li>
					</ul>
					<div class="cl"></div>
				</div>
				<div class="middle-info">
					<div class="info-title">
						<ul>
							<li class="company">商品/商铺：<a href="">小白白的店</a></li>
							<li class="price">单价</li>
							<li class="number">数量</li>
							<li class="total">总计</li>
							<div class="cl"></div>
							<span class="parting-line"></span>
						</ul>
					</div>
					<div class="order-list">
						<ul class="order-list-1">
							<li class="g-title">
								<img src="home/images/order/goods.jpg"/>
								<h5>
									<a href="">312-双门双向网络型控制板 AT8002</a>
									<p class="g-desc">商品规格：312</p>
								</h5>
							</li>
							<li class="g-price">130</li>
							<li class="g-num">2</li>
							<li class="total-price">260</li>
							<div class="cl"></div>
						</ul>
						<ul class="order-list-2">
							<li class="g-title">
								<img src="home/images/order/goods.jpg"/>
								<h5>
									<a href="">312-双门双向网络型控制板 AT8002</a>
									<p class="g-desc">商品规格：312</p>
								</h5>
							</li>
							<li class="g-price">130</li>
							<li class="g-num">2</li>
							<li class="total-price">260</li>
							<div class="cl"></div>
						</ul>
						<ul class="order-list-3">
							<li class="g-title">
								<img src="home/images/order/goods.jpg"/>
								<h5>
									<a href="">312-双门双向网络型控制板 AT8002</a>
									<p class="g-desc">商品规格：312</p>
								</h5>
							</li>
							<li class="g-price">130</li>
							<li class="g-num">2</li>
							<li class="total-price">260</li>
							<div class="cl"></div>
						</ul>
					</div>
				</div>
				<div class="count">
					<p class="count-price">订单总额：780元</p>
					<p class="fare">运费：0元</p>
				</div>
			</div>
		</div>
		@include('inc.home.site-foot')
	</body>
</html>
