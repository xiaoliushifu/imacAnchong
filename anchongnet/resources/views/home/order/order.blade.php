@extends('inc.home.pcenter.pcenter')
@section('info')
	<title>订单详情</title>
	<link rel="stylesheet" type="text/css" href="/home/css/order.css"/>
	<link rel="stylesheet" type="text/css" href="/home/css/collectgoods.css">

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
			 <input type="hidden" name="_token" value="{{ csrf_token() }}">
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
							<li><a href="javascript:"  class="totle">所有订单</a></li>
							<li><a href="javascript:"  class="money">待付款</a>
							<li><a href="javascript:"  class="push">待发货</a>
							<li><a href="javascript:"  class="pull">待收货</a>
							<li><a href="#" class="inactive active">售后</a>

						</ul>

					</li>
					<hr>
					<li><a href="#">我的钱袋</a></li>
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
						<li class="all-order totle"><a href="javascript:">所有订单</a></li>
						<li><a href="javascript:" class ="money">待付款</a></li>
						<li><a href="javascript:" class="push">待发货</a></li>
						<li><a href="javascript:" class="pull">待收货</a></li>
						<li><a href="">售后</a></li>
						<div class="cl"></div>
					</ul>
					<style>
						.information-nav li a{text-decoration: none;}
						.information-nav li a:hover{color: #1DABD8;font-weight: bold;}
					</style>
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
						<li style="padding-right: 20px;">
							交易状态
						</li>
					</ul>
				</div>
				<div class="pages">
					<div class="cl"></div>
				</div>
				<div class="show-list" id="all">
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
									<a href="{{url('order/'.$f->order_num)}}"><img class="g-img" src="{{$f->img}}"/></a>
								</li>
								<li>
									<a href="{{url('order/'.$f->order_num)}}"><h5 class="g-title">{{$f->goods_name}}</h5></a>
									<span class="g-desc">{{$f->goods_type}}</span>
									@if(!empty($f->oem))
										<span style="padding-left: 20px;color:red;">{{$f->oem}}</span>
									@endif
								</li>
								<li class="g-price">{{$f->goods_price}}</li>
								<li class="g-num">{{$f->goods_num}}</li>
								<li class="refund">申请退款</span>
								</li>
								<li class="all-price">{{$f->goods_price*$f->goods_num}}</li>
								<li class="trade-desc">
									<p class="trade" style="color: red;">
											@if($o->state==1)
												待付款
												<div class="btn-group">
												  <button type="button" style="padding:5px 4px;" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" data-oid="{{$o->order_id}}" data-price="{{$o->total_price}}" data-info="{{$f->goods_name}}">
												    立即支付 <span class="caret"></span>
												  </button>
												  <ul class="dropdown-menu" role="menu">
												    <li><a href="#" class="alipay" data-oid="{{$o->order_id}}" data-price="{{$o->total_price}}" data-info="{{$f->goods_name}}">支付宝</a></li>
												    <li><a href="#" class="wxpay" data-oid="{{$o->order_id}}" data-price="{{$o->total_price}}" data-info="{{$f->goods_name}}">微信</a></li>
												  </ul>
												</div>
											@endif
											@if($o->state==2)
												待发货
											@endif
											@if($o->state==3)
												待收货
												<button style="padding:5px 4px;" type="button" class="btn btn-warning dropdown-toggle">确认收货</button>
											@endif
											@if($o->state==4)
												待审核
											@endif
											@if($o->state==5)
												已退款
											@endif
											@if($o->state==6)
												交易关闭
											@endif
											@if($o->state==7)
												交易成功
											@endif
									</p>
									<a href="{{url('order/'.$f->order_num)}}"><p class="order-detail">交易详情</p></a>
								</li>
							</ul>
						</li>
						</ul>
						@endforeach
					@endforeach
				</div>

				<div class="show-list" id="or1"style="display: none;">
					@foreach($ordernum1 as $o)
						<ul class="order-desc">
							<li class="show-title">
								<span class="d-title"><a href="">{{$o->sname}}</a></span>
								<span class="order-id">订单号：{{$o->order_num}}</span>
								<span class="c-seller"><a href="">联系卖家</a></span>
								<span class="del"><a href="">删除</a></span>
							</li>
							@foreach($order1[$o->order_num] as $ml=>$f)
								<li class="show-desc">
									<ul>
										<li>
											<a href="{{url('order/'.$f->oid)}}"><img class="g-img" src="{{$f->img}}"/></a>
										</li>
										<li>
											<a href=""><h5 class="g-title">{{$f->goods_name}}</h5></a>
											<span class="g-desc">{{$f->goods_type}}</span>
											@if(!empty($f->oem))
												<span style="padding-left: 20px;color:red;">{{$f->oem}}</span>
											@endif
										</li>
										<li class="g-price">{{$f->goods_price}}</li>
										<li class="g-num">{{$f->goods_num}}</li>
										<li class="refund">申请退款</span>
										</li>
										<li class="all-price">{{$f->goods_price*$f->goods_num}}</li>
										<li class="trade-desc">
											<p class="trade" style="color: red;">待付款</p>
											<a href="{{url('order/'.$f->order_num)}}"><p class="order-detail">交易详情</p></a>
										</li>
									</ul>
								</li>
						</ul>
					@endforeach
					@endforeach
				</div>

				<div class="show-list" id="or2" style="display: none;">
					@foreach($ordernum2 as $o)
						<ul class="order-desc">
							<li class="show-title">
								<span class="d-title"><a href="">{{$o->sname}}</a></span>
								<span class="order-id">订单号：{{$o->order_num}}</span>
								<span class="c-seller"><a href="">联系卖家</a></span>
								<span class="del"><a href="">删除</a></span>
							</li>
							@foreach($order2[$o->order_num] as $ml=>$f)
								<li class="show-desc">
									<ul>
										<li>
											<a href="{{url('order/'.$f->order_num)}}"><img class="g-img" src="{{$f->img}}"/></a>
										</li>
										<li>
											<a href="{{url('order/'.$f->order_num)}}"><h5 class="g-title">{{$f->goods_name}}</h5></a>
											<span class="g-desc">{{$f->goods_type}}</span>
											@if(!empty($f->oem))
												<span style="padding-left: 20px;color:red;">{{$f->oem}}</span>
											@endif
										</li>
										<li class="g-price">{{$f->goods_price}}</li>
										<li class="g-num">{{$f->goods_num}}</li>
										<li class="refund">申请退款</span>
										</li>
										<li class="all-price">{{$f->goods_price*$f->goods_num}}</li>
										<li class="trade-desc">
											<p class="trade" style="color: red;">待发货</p>
											<a href="{{url('order/'.$f->order_num)}}"><p class="order-detail">交易详情</p></a>
										</li>
									</ul>
								</li>
						</ul>
					@endforeach
					@endforeach
				</div>

				<div class="show-list" id="or3" style="display: none;">
					@foreach($ordernum3 as $o)
						<ul class="order-desc">
							<li class="show-title">
								<span class="d-title"><a href="">{{$o->sname}}</a></span>
								<span class="order-id">订单号：{{$o->order_num}}</span>
								<span class="c-seller"><a href="">联系卖家</a></span>
								<span class="del"><a href="">删除</a></span>
							</li>
							@foreach($order3[$o->order_num] as $ml=>$f)
								<li class="show-desc">
									<ul>
										<li>
											<a href="{{url('order/'.$f->order_num)}}"><img class="g-img" src="{{$f->img}}"/></a>
										</li>
										<li>
											<a href="{{url('order/'.$f->order_num)}}"><h5 class="g-title">{{$f->goods_name}}</h5></a>
											<span class="g-desc">{{$f->goods_type}}</span>
											@if(!empty($f->oem))
												<span style="padding-left: 20px;color:red;">{{$f->oem}}</span>
											@endif
										</li>
										<li class="g-price">{{$f->goods_price}}</li>
										<li class="g-num">{{$f->goods_num}}</li>
										<li class="refund">申请退款</span>
										</li>
										<li class="all-price">{{$f->goods_price*$f->goods_num}}</li>
										<li class="trade-desc">
											<p class="trade" style="color: red;">待收货</p>
											<p class="order-detail"><a href="{{url('order/'.$f->order_num)}}">交易详情</a></p>
										</li>
									</ul>
								</li>
						</ul>
					@endforeach
					@endforeach
				</div>


			</div>
			<script>

//详情。参数。相关
					$(document).ready(function(){
						$(".totle").click(function(){
							$("#all").show();
							$("#or1").hide();
							$("#or2").hide();
							$("#or3").hide();
						});
						$(".money").click(function(){
							$("#or1").show();
							$("#or2").hide();
							$("#or3").hide();
							$("#all").hide();
						});
						$(".push").click(function(){
							$("#or2").show();
							$("#or1").hide();
							$("#or3").hide();
							$("#all").hide();
						});
						$(".pull").click(function(){
							$("#or3").show();
							$("#or1").hide();
							$("#or2").hide();
							$("#all").hide();
						});
					});
			</script>

		</div>


	</div>
	<div style="clear: both"></div>
	<script type="text/javascript" src="home/js/navleft.js"></script>
	<script type="text/javascript" src="home/js/order.js"></script>
	@endsection
