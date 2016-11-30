<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>促销详情列表</title>
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
		<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-body">
							<table id="example1" class="table table-bordered table-striped">
								<tr>
									<th width="10%">货品ID</th>
									<th width="30%">货品编号</th>
									<th width="15%">促销价格</th>
									<th width="10%">排序</th>
									<th width="30%">操作</th>
								</tr>
								@foreach ($datas as $data)
								<tr>
								    <td align="center">{{$data->gid}}</td>
									<td align="center">{{$data->goods_numbering}}</td>
									<td align="center">{{$data->promotion_price}}</td>
									<td align="center">{{$data->sort}}</td>
									<td align="center">
										<button type='button' class='edit btn btn-primary btn-xs' data-id="{{$data->pg_id}}" data-toggle="modal" data-target="#myModal" data-gid="{{$data->gid}}" data-num="{{$data->goods_numbering}}" data-price="{{$data->promotion_price}}" data-sort="{{$data->sort}}">编辑</button>
										<button type="button" class="del btn btn-danger btn-xs" data-id="{{$data->pg_id}}">删除</button>
									</td>
								</tr>
								@endforeach
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
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="myModalLabel">促销商品修改</h4>
				</div>
				<div class="modal-body">
					<input type="hidden" id="pg_id" name="pg_id" value="">
					<form role="form" class="form-horizontal" action="" method="" id="promotionForm">
						<div class="form-group">
	                        <label class="col-sm-2 control-label"  style="padding-top:0px;" for="name">货品ID</label>
	                        <div class="col-sm-8" id="pro_gid">

	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label class="col-sm-2 control-label" style="padding-top:0px;" for="name">货品编号</label>
	                        <div class="col-sm-8" id="pro_num">

	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label class="col-sm-2 control-label" for="name">促销价格</label>
	                        <div class="col-sm-6">
	                            <input type="text" name="promotion_price" class="form-control" id="pro_price" placeholder="促销的价格" required>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label class="col-sm-2 control-label" for="name">促销排序</label>
	                        <div class="col-sm-6">
	                            <input type="text" name="sort" class="form-control" placeholder="促销排序，20在最前0在最后" id="pro_sort" required>
	                        </div>
	                    </div>
						<div class="form-group text-center">
							<label class="col-sm-3 control-label"></label>
							<div class="col-sm-3">
								<button type="button" class="btn btn-info" id="save">保存</button>
							</div>
						</div><!--end form-group text-center-->
					</form>
				</div>
			</div>
		</div>
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
<script src="/admin/js/jquery.form.js"></script>
<script src="/admin/js/promotioninfo.js"></script>
</body>
</html>
