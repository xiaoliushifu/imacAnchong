<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>订单详情</title>
		<link rel="stylesheet" type="text/css" href="{{asset('home/css/orderdetail.css')}}"/>
		<script src="{{url('home/js/jquery-3.1.0.js')}}"></script>
		<script src="{{url('home/js/orderdetail.js')}}" type="text/javascript" charset="utf-8"></script>
		<link rel="stylesheet" href="{{asset('home/css/top.css')}}">
		<script src="{{asset('home/js/top.js')}}"></script>
	</head>
	<body>
	@include('inc.home.top')
		<div class="site-header">
			<div class="header-container">
				<a href="{{url('/')}}"><img src="{{asset('home/images/order/logo.jpg')}}"/></a>
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
					@if($orderdetail->state==1||$orderdetail->state==2)
						<img src="{{asset('home/images/cart/pay.png')}}"/>
					@endif
						@if($orderdetail->state==3||$orderdetail->state==7)
					<img src="{{asset('home/images/order/order-status4.png')}}"/>
						@endif
				</div>
				<div class="item">
					<ul class="line-item">
						<li class="item-title"><h4>订单信息</h4></li>
						<li class="consignee">收货人：{{$orderdetail->name}}</li>
						<li class="telphone">联系电话：{{$orderdetail->phone}}</li>
						<li class="add">收货地址：{{$orderdetail->address}}</li>
						<li class="order-id">订单号：{{$orderdetail->order_num}}</li>
						<li class="order-time">下单时间：{{$orderdetail->created_at}}</li>
						<span class="parting"></span>
						<span class="shop-name"><a href="">{{$orderdetail->sname}}</a></span>
						<span class="c-seller"><a href="">联系卖家</a></span>
					</ul>
					<ul class="order-info">
						<li class="order-state">
							<img src="{{asset('home/images/order/sucessed.png')}}"/>
							订单状态：
							@if($orderdetail->state==1)
								待付款
							@endif
							@if($orderdetail->state==2)
								待发货
							@endif
							@if($orderdetail->state==3)
								待收货
							@endif
							@if($orderdetail->state==4)
								待审核
							@endif
							@if($orderdetail->state==5)
								已退款
							@endif
							@if($orderdetail->state==6)
								交易关闭
							@endif
							@if($orderdetail->state==7)
								交易成功
							@endif
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
						@foreach($orderlist as $l)
						<ul class="order-list-1">
							<li class="g-title">
								<img src="{{$l->img}}" style="width: 100px;height: 100px;"/>
								<h5>
									<nobr><p style="overflow:hidden;text-overflow: ellipsis;width: 500px;"><a href="">{{$l->goods_name}}</a></p></nobr>
									<p class="g-desc">{{$l->goods_type}}
										@if(!empty($l->oem))
											<span style="padding-left: 20px;color:red;">{{$l->oem}}</span>
										@endif
									</p>

								</h5>
							</li>
							<li class="g-price">{{$l->goods_price}}</li>
							<li class="g-num">{{$l->goods_num}}</li>
							<li class="total-price">{{$l->goods_price*$l->goods_num}}</li>
							<div class="cl"></div>
						</ul>
						@endforeach

					</div>
				</div>
				<div class="count">
					<p class="count-price">订单总额：{{$orderdetail->total_price}}</p>
					<p class="fare">运费：{{$orderdetail->freight}}元</p>
				</div>
			</div>
		</div>
		@include('inc.home.site-foot')
	</body>
</html>
