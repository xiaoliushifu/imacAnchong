<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>我的订单</title>
		<link rel="stylesheet" type="text/css" href="home/css/order.css"/>
		<script src="{{asset('/home/js/jquery-3.1.0.js')}}"></script>
		<script src="{{asset('/home/js/order.js')}}" type="text/javascript" charset="utf-8"></script>
	</head>
	<body>
		<div class="site-top">
			<div class="top-container">
				<a class="index" href="#">安虫首页</a>
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
