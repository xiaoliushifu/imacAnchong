<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>标签列表</title>
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
			<h1>标签浏览</h1>
		</section>

		<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-body">
						    <form action="/tag" method="get" class="form-horizontal form-inline f-ib">
								标签类型：
								<select class="form-control" name="type">
									<option value="" id="check">请选择</option>
									<option value="0" id="type0">区域标签</option>
									<option value="1" id="type1">发布工程</option>
									<option value="2" id="type2">承接工程</option>
									<option value="3" id="type3">发布人才</option>
									<option value="4" id="type4">招聘人才</option>
								</select>
						      <button type="submit" class="btn btn-primary btn-sm" id="filter">筛选</button>
						    </form>
		                    <a href="/tag" class="btn btn-default btn-sm unplay f-ib" role="button">取消筛选</a>
							<table id="example1" class="table table-bordered table-striped">
								<tr>
									<th>标签类型</th>
									<th>标签名称</th>
									<th>操作</th>
								</tr>
								@foreach ($datacol['datas'] as $data)
								<tr>
								    <td align="center">
								    <?php
								    switch ($data['type_id']){
										case 0:
											echo "区域标签";
											break;
									    case 1:
											echo "发布工程";
											break;
									    case 2:
											echo "承接工程";
											break;
									    case 3:
											echo "发布人才";
											break;
										case 4:
											echo "招聘人才";
											break;
										default:
											echo "区域标签";
								    }?>
								    </td>
									<td align="center">{{$data['tag']}}</td>
									<td align="center">
										<button type="button" class="del f-ib btn btn-danger btn-xs" data-id="{{$data['id']}}">删除</button>
									</td>
								</tr>
								@endforeach
								<tr>
								  <td colspan="2" align="center">
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
	<!-- /.content-wrapper -->
	<input type="hidden" id="activeFlag" value="treetag">
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
<script src="/admin/js/tag.js"></script>
<?php
if(isset($datacol['args']['type'])){
	switch ($datacol['args']['type']){
		case "":
			echo '<script>$(function(){$("#check").attr("selected",true)})</script>';
			break;
		case 0:
			echo '<script>$(function(){$("#type0").attr("selected",true)});</script>';
			break;
		case 1:
			echo '<script>$(function(){$("#type1").attr("selected",true)});</script>';
			break;
		case 2:
		    echo '<script>$(function(){$("#type2").attr("selected",true)});</script>';
		    break;
		case 3:
			echo '<script>$(function(){$("#type3").attr("selected",true)});</script>';
			break;
		case 4:
			echo '<script>$(function(){$("#type4").attr("selected",true)});</script>';
			break;
	}
}
?>
</body>
</html>
