<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>AdminLTE 2 | General Form Elements</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.5 -->
	<link rel="stylesheet" href="/admin/bootstrap/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="/admin/dist/dfonts/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="/admin/dist/dfonts/ionicons.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="/admin/dist/css/AdminLTE.min.css">
	<!-- Bootstrap Color Picker -->
	<link rel="stylesheet" href="/admin/plugins/colorpicker/bootstrap-colorpicker.min.css">
	<!-- daterange picker -->
	<link rel="stylesheet" href="/admin/plugins/daterangepicker/daterangepicker-bs3.css">
	
		<link rel="stylesheet" href="/admin/plugins/timepicker/bootstrap-timepicker.min.css">
	<!-- AdminLTE Skins. Choose a skin from the css/skins
			 folder instead of downloading all of them to reduce the load. -->
	<link rel="stylesheet" href="/admin/dist/css/skins/_all-skins.min.css">
	 <link rel="stylesheet" href="/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
@include('Inc.admin.mainHead')
	<!-- Left side column. contains the logo and sidebar -->
	<aside class="main-sidebar">
		<!-- sidebar: style can be found in sidebar.less -->
	@include('Inc.admin.sidebar')
		<!-- /.sidebar -->
	</aside>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				商家认证
<!--         <small>Preview</small> -->
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> 首页</a></li>
				<li><a href="#">商家管理</a></li>
				<li class="active">商家认证资料</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">
			<div class="row">
				<!-- left column -->
				<div class="col-md-6">
					<!-- general form elements -->
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">请填写商家认证资料</h3>
						</div>
						<!-- /.box-header -->
						<!-- form start -->
						<form role="form">
							<div class="box-body">
								<div class="form-group">
									<label for="exampleInputPassword1">商家名称</label>
									<input type="enterprisename" class="form-control" id="exampleInputPassword1" placeholder="企业认证">
								</div>
								<div class="form-group">
									<label>商家类别</label>
									<select class="form-control">
										<option>个体</option>
										<option>企业</option>
									 
									</select>
									
									<div class="form-group">
										<label for="exampleInputFile">上传资质</label>
										<input type="file" id="exampleInputFile">

									<p class="help-block">个体认证请上传省份证，商家认证请上传营业执照</p>
									</div>
								</div>
							</div>
							<div class="box-footer">
								<button type="submit" class="btn btn-primary">确认</button>
							</div>						
						</form>
					</div>
					 </section>
		</div>
	<!-- /.content-wrapper -->
 @include('inc.admin.footer')

	<!-- Control Sidebar -->
@include('inc.admin.controlsidebar')
	<!-- /.control-sidebar -->
	<!-- Add the sidebar's background. This div must be placed
			 immediately after the control sidebar -->
	<div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.0 -->
<script src="/admin/plugins/jQuery/jQuery-2.2.0.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="/admin/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="/admin/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/admin/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/admin/dist/js/demo.js"></script>
<!-- bootstrap color picker -->
<script src="/admin/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<script src="/admin/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="/admin/plugins/daterangepicker/daterangepicker.js"></script>


	<script>
		$(function () {
			//Initialize Select2 Elements
			//Colorpicker
			$(".my-colorpicker1").colorpicker();
			//color picker with addon
			$(".my-colorpicker2").colorpicker();

		});
 </script>
</body>
</html>
