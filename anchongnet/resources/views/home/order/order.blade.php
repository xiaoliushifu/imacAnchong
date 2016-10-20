@extends('inc.home.pcenter.pcenter')
@section('info')
	<title>订单详情</title>
	<link rel="stylesheet" type="text/css" href="home/css/order.css"/>
	<link rel="stylesheet" type="text/css" href="home/css/collectgoods.css">

@endsection
@section('content')

	<div class="main">
		<div class="mainlf">
			<div class="topll">
				<img src="{{$msg->headpic}}" alt="">
				<p>{{$msg->nickname}}</p>
				<p>QQ：{{$msg->qq}}</p>
				<p>邮箱：{{$msg->email}}</p>
			</div>
			<div class="toppp">
				<ul>
					<li><a href="javascript:" class="inactive">我的发布<b class="caret"></b></a>
						<ul class="ttt" style="display: none">
							<hr>
							<li><a href="{{url('/conwork')}}" class="inactive active">发包工程</a></li>
							<li><a href="{{url('/conwork')}}" class="inactive active">承接工程</a></li>
							<li><a href="{{url('/reoder')}}" class="inactive active">发布人才</a></li>
							<li><a href="{{url('/mypublish')}}" class="inactive active">人才自荐</a></li>
							<li><a href="{{url('/fngoods')}}" class="inactive active">找货</a></li>

						</ul>

					</li>
					<hr>
					<li><a href="javascript:" class="inactive">我的收藏<b class="caret"></b></a>
						<ul class="ttt" style="display: none">
							<hr>
							<li><a href="{{url('/colgoods')}}" class="inactive active">商品</a></li>
							<li class="last"><a href="{{url('/colshop')}}">商铺</a></li>
							<li class="last"><a href="{{url('/colcommunity')}}">社区</a></li>
						</ul>
					</li>
					<hr>
					<li><a href="javascript:" class="inactive">我的订单<b class="caret"></b></a>
						<ul class="ttt" style="display: none">
							<hr>
							<li><a href="#" class="inactive active">未完成订单</a>

							</li>
							<li><a href="#" class="inactive active">已完成订单</a>

						</ul>

					</li>
					<hr>
					<li><a href="#">我的钱袋</a></li>
					<hr>
					<li><a href="#">虫虫粉丝</a></li>
					<hr>
					<li><a href="{{url('/applysp')}}">商铺申请</a></li>
					<hr>
					<li><a href="{{url('/honor')}}">会员认证</a></li>
					<hr>

				</ul>
			</div>
		</div>
		<div class="mainrg">
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
					{{--<div class="pages-container">--}}
						{{--<a href="">--}}
							{{--<span class="up"><</span>--}}
							{{--<span class="up-page">上一页</span>--}}
						{{--</a>--}}
						{{--<a href="">--}}
							{{--<span class="down-page">下一页</span>--}}
							{{--<span class="down">></span>--}}
						{{--</a>--}}
					{{--</div>--}}
					<div class="cl"></div>
				</div>
				<div class="show-list">
					@foreach($orderlist as $o)
					<ul class="order-desc">
						<li class="show-title">
							<span class="d-title"><a href="">{{$o->sname}}</a></span>
							<span class="order-id">订单号：{{$o->order_num}}</span>
							<span class="c-seller"><a href="">联系卖家</a></span>
							<span class="del"><a href="">删除</a></span>
						</li>
						@foreach($orderinfo[$o->order_num] as $ml=>$f)
						<li class="show-desc">
							<ul>
								<li>
									<img class="g-img" src="{{$f->img}}"/>
								</li>
								<li>
									<h5 class="g-title">{{$f->goods_name}}</h5>
									<span class="g-desc">{{$f->goods_type}}</span>
								</li>
								<li class="g-price">{{$f->goods_price}}</li>
								<li class="g-num">{{$f->goods_num}}</li>
								<li class="refund">申请退款</span>
								</li>
								<li class="all-price">{{$f->goods_price*$f->goods_num}}</li>
								<li class="trade-desc">
									<p class="trade">交易成功</p>
									<p class="order-detail">交易详情</p>
								</li>
							</ul>
						</li>
						</ul>
						@endforeach

					@endforeach

				</div>
			</div>


		</div>


	</div>
	<div style="clear: both"></div>
	<script type="text/javascript" src="home/js/navleft.js"></script>
	@endsection






