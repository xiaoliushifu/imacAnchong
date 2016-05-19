<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>订单列表</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.5 -->
	<link rel="stylesheet" href="/admin/bootstrap/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="/admin/dist/dfonts/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="/admin/dist/dfonts/ionicons.min.css">
	<!-- DataTables -->
	<link rel="stylesheet" href="/admin/plugins/datatables/dataTables.bootstrap.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="/admin/dist/css/AdminLTE.min.css">
	<!-- AdminLTE Skins. Choose a skin from the css/skins
			 folder instead of downloading all of them to reduce the load. -->
	<link rel="stylesheet" href="/admin/dist/css/skins/_all-skins.min.css">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<style>
	    th{text-align:center;}
		.f-ib{display: inline-block;}
	</style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
	@include('inc.admin.mainHead')
		<!-- Left side column. contains the logo and sidebar -->
	<aside class="main-sidebar">
		<!-- sidebar: style can be found in sidebar.less -->
		@include('inc.admin.sidebar')
		<!-- /.sidebar -->
	</aside>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				订单管理
				<small>订单列表</small>
			</h1>
		</section>

		<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
<!-- 						<div class="box-header"> -->
<!-- 							<h3 class="box-title">Data Table With Full Features</h3> -->
<!-- 						</div> -->
						<!-- /.box-header -->
						<div class="box-body">
							<form action="/order" method="get" class="form-horizontal form-inline f-ib">
								<input type="text" name="keyNum" value="{{$datacol['args']['keyNum']}}" class="form-control" placeholder="订单编号">
								<button type="submit" class="btn btn-primary btn-sm" id="filter">筛选</button>
							</form>
							<a href="/order" class="btn btn-default btn-sm unplay f-ib" role="button">取消筛选</a>
							<table id="example1" class="table table-bordered table-striped">
								<tr>
									<th>商铺名称</th>
									<th>订单编号</th>
									<th>订单状态</th>
									<th>订单生成时间</th>
									<th>收货人</th>
									<th>收货人电话</th>
									<th>收货地址</th>
									<th>操作</th>
								</tr>
								@foreach ($datacol['datas'] as $data)
									<tr>
										<td align="center">{{$data['sname']}}</td>
										<td align="center">{{$data['order_num']}}</td>
										<td align="center">
											<?php
												switch($data['state']){
													case 1:
														echo "待支付";
														break;
													case 2:
														echo "待发货";
														break;
													case 3:
														echo "待收货";
														break;
													case 4:
														echo "待审核";
														break;
													case 5:
														echo "已退款";
														break;
													case 6:
														echo "交易关闭";
														break;
													case 7:
														echo "交易成功";
														break;
												}
											?>
										</td>
										<td align="center">{{$data['created_at']}}</td>
										<td align="center">{{$data['name']}}</td>
										<td align="center">{{$data['phone']}}</td>
										<td align="center">{{$data['address']}}</td>
										<td align="center">
											<button type="button" class="view f-ib btn btn-default btn-xs" data-id="{{$data['order_id']}}" data-num="{{$data['order_num']}}" data-toggle="modal" data-target="#myView">查看详情</button>
											@if ($data['state'] == 2)
												<button type='button' class='send f-ib btn btn-primary btn-xs' data-id="{{$data['order_id']}}">发货</button>
											@elseif ($data['state']==4)
												<button type='button' class='check f-ib btn btn-primary btn-xs' data-id="{{$data['order_id']}}" data-num="{{$data['order_num']}}">审核</button>
											@else
											@endif
										</td>
									</tr>
								@endforeach
								<tr>
									<td colspan="8" align="center">
										<?php echo $datacol['datas']->appends($datacol['args'])->render(); ?>
									</td>
								</tr>
							</table>
						</div>
						<!-- /.box-body -->
					</div>
					<!-- /.box -->
				</div>
				<!-- /.col -->
			</div>
			<!-- /.row -->
		</section>
		<!-- /.content -->
	</div>

	<!-- Modal -->
	<div class="modal fade" id="myView" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="myModalLabel"></h4>
				</div>
				<div class="modal-body" id="mbody">
					<dl class="dl-horizontal">
						<dt>订单编号</dt>
						<dd>1</dd>
						<dt>商品数量</dt>
						<dd>2</dd>
					</dl>
					<hr>
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" id="activeFlag" value="treeorder">
	<!-- /.content-wrapper -->
	@include('inc.admin.footer')
<!-- Bootstrap 3.3.5 -->
<script src="/admin/bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="/admin/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/admin/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/admin/dist/js/app.min.js"></script>
<script src="/admin/js/order.js"></script>
</body>
</html>
