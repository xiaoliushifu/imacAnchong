<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>促销管理</title>
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
	.f-ib{display:inline-block;}
	#example1{margin-top:10px;}
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
			<h1>促销管理</h1>
		</section>

		<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-body">
							<form>
		                        <div class="form-group">
		                            <div class="col-sm-12">
		                                <table class="table text-center">
		                                    <thead>
		                                    <tr>
		                                        <th class="text-center col-sm-1">开始时间</th>
		                                        <th class="text-center col-sm-1">结束时间</th>
		                                        <th class="text-center col-sm-1">操作</th>
												<th class="text-center col-sm-1">查看</th>
		                                    </tr>
		                                    </thead>
		                                    <tbody id="promotionlist">
												@if(count($datacol['datas']) ==0)
												<tr class="line">
													<td>
														<input type="text" class="starttime form-control" value=""/>
													</td>
													<td>
														<input type="text" class="endtime form-control" value=""/>
													</td>
													<td>
														<button type="button" class="addcuspro btn-sm btn-link" title="添加" data-id="1">
															<span class="glyphicon glyphicon-plus">
															</span>
														</button>
														<button type="button" class="savepromotion btn-sm btn-link" title="保存" data-id="1">
															<span class="glyphicon glyphicon-save">
															</span>
														</button>
														<button type="button" class="delcuspro btn-sm btn-link" title="删除" data-id="1">
															<span class="glyphicon glyphicon-minus">
															</span>
														 </button>
													</td>
													<td>
														<button type="button" class="f-ib btn btn-info btn-xs">查看促销列表</button>
													</td>
												</tr>
												@endif
												@foreach ($datacol['datas'] as $data)
												<tr class="line">
													<td>
														<input type="text" class="starttime form-control" value="{{date('Y-m-d',$data->start_time)}}" readonly="true"/>
													</td>
													<td>
														<input type="text" class="endtime form-control" value="{{date('Y-m-d',$data->end_time)}}" readonly="true"/>
													</td>
													<td>
														<button type="button" class="addcuspro btn-sm btn-link" title="添加" data-id="{{$data->promotion_id}}">
															<span class="glyphicon glyphicon-plus">
															</span>
														</button>
														<button type="button" class="savepromotion btn-sm btn-link" title="保存" data-id="{{$data->promotion_id}}">
															<span class="glyphicon glyphicon-save">
															</span>
														</button>
														<button type="button" class="delcuspro btn-sm btn-link" title="删除" data-id="{{$data->promotion_id}}">
															<span class="glyphicon glyphicon-minus">
															</span>
														 </button>
													</td>
													<td>
														<a href="/promotioninfo?promotion_id={{$data->promotion_id}}" target="_blank" class="btn btn-primary btn-xs">查看促销列表</a>
													</td>
													</tr>
												@endforeach
		                                    </tbody>
		                                </table>
		                            </div>
		                            <div style="clear:both"></div>
		                        </div>
		                    </form>
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
	<!-- /.content-wrapper -->

	<input type="hidden" id="activeFlag" value="treepromotion">
	@include('inc.admin.footer')
</div>
<!-- ./wrapper -->
<!-- Bootstrap 3.3.5 -->
<script src="/admin/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="/admin/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/admin/dist/js/app.min.js"></script>
<!-- 标签管理的js -->
<script src="/admin/js/promotion.js"></script>

</body>
</html>
