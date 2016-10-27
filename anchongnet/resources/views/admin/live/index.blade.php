<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>直播列表</title>
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
		.tables th{
			border: 1px solid #333;
		}
		.tables td{
			border: 1px solid #333;
			font-size: 12px;
		}
		.table1 {
			border: 0px solid #333;
		}
		li{
			list-style:none;
		}
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
	<div class="content-wrapper" id="pageindex">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				直播列表
			</h1>
		</section>

		<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-body">
							<form action="/order" method="get" class="form-horizontal form-inline f-ib">
								<input type="text" name="kn" class="form-control" placeholder="订单编号">
								<select name="state">
                                    		<option value="0" >--筛选状态--</option>
                                    		<option value="1">待收款</option>
                                    		<option value="2">待发货</option>
                                    		<option value="3">已发货</option>
                                    		<option value="4">待审核</option>
                                    		<option value="5">已退款</option>
                                    		<option value="6">交易关闭</option>
                                    		<option value="7">交易成功</option>
                                </select>
								<button type="submit" class="btn btn-primary btn-sm" id="filter">筛选</button>
							</form>
							<table id="example1" class="table table-bordered table-striped">
								<tr>
									<th>直播ID</th>
									<th>直播标题</th>
									<th>直播封面</th>
									<th>主播昵称</th>
									<th>聊天室ID</th>
									<th>操作</th>
								</tr>
								@foreach ($datacol['datas'] as $data)
									<tr>
										<td align="center">{{$data->zb_id}}</td>
										<td align="center">{{$data->title}}</td>
										<td align="center"><img style="height:50px;width:50px;" src="{{$data->images}}"></td>
										<td align="center">{{$data->nick}}</td>
										<td align="center">{{$data->room_id}}</td>
										<td align="center">
											<button type="button" class="closes f-ib btn btn-danger btn-xs" data-id="{{$data->zb_id}}" data-usersid="{{$data->users_id}}">强制关闭直播
											</button>
											<button type="button" class="open f-ib btn btn-success btn-xs" data-id="{{$data->zb_id}}" data-usersid="{{$data->users_id}}">重新开启直播
											</button>
										</td>
									</tr>
								@endforeach
								<tr>
									<td colspan="8" align="center">
										<?php echo $datacol['datas']->render(); ?>
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
	<input type="hidden" id="activeFlag" value="treelive">
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
<script src="/admin/js/jquery.form.js"></script>
<script src="/admin/js/live.js"></script>
</body>
</html>
