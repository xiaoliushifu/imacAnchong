<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>商机广告</title>
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
	.radio-inline{position:relative; top:-4px;}
	.gallery{width: 80px; height: 80px; background: url("/admin/image/catetypecreate/add.jpg") center center no-repeat; border: solid #ddd 1px;  cursor: pointer; display:table-cell; vertical-align: middle;}
	.gallery img{max-width: 100%; max-height: 100%;}
	</style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<?php echo $__env->make('inc.admin.mainHead', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<?php echo $__env->make('inc.admin.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<!-- /.sidebar -->
</aside>
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>店铺浏览</h1>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
				<div class="box-body">
			<div class="modal-body">
				<table class="table">
					<input type="hidden" id="advert-sid" value="">
					<th>
						<td align="center"><b>商机首页轮播图</b></td>
					</th>
					<tr>
						<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate31" method="post" enctype="multipart/form-data">
							<div id="method"></div>
										<div class="gallery text-center">
											<img src="/admin/image/advert/1125-540.jpg" style="height:100px;width:100px;" class="img31">
										</div>
										<input type="file" name="file" class="appbusinesspic31">
						</form></td>
						<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate32" method="post" enctype="multipart/form-data">
							<div id="method"></div>
										<div class="gallery text-center">
											<img src="/admin/image/advert/1125-540.jpg" style="height:100px;width:100px;" class="img32">
										</div>
										<input type="file" name="file" class="appbusinesspic32">
						</form></td>
						<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate33" method="post" enctype="multipart/form-data">
							<div id="method"></div>

										<div class="gallery text-center">
											<img src="/admin/image/advert/1125-540.jpg" style="height:100px;width:100px;" class="img33">
										</div>
										<input type="file" name="file" class="appbusinesspic33">
						</form></td>
						<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate34" method="post" enctype="multipart/form-data">
							<div id="method"></div>

										<div class="gallery text-center">
											<img src="/admin/image/advert/1125-540.jpg" style="height:100px;width:100px;" class="img34">
										</div>
										<input type="file" name="file" class="appbusinesspic34">
						</form></td>
					</tr>
					<th>
						<td align="center"><b>商机首页最新招标项目</b></td>
					</th>
					<tr>
						<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate31" method="post" enctype="multipart/form-data">
							<div id="method"></div>
										<div class="gallery text-center">
											<img src="/admin/image/advert/564-270.jpg" style="height:100px;width:100px;" class="img31">
										</div>
										<input type="file" name="file" class="appbusinesspic31">
						</form></td>
						<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate32" method="post" enctype="multipart/form-data">
							<div id="method"></div>
										<div class="gallery text-center">
											<img src="/admin/image/advert/561-135.jpg" style="height:100px;width:100px;" class="img32">
										</div>
										<input type="file" name="file" class="appbusinesspic32">
						</form></td>
						<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate33" method="post" enctype="multipart/form-data">
							<div id="method"></div>

										<div class="gallery text-center">
											<img src="/admin/image/advert/282-135.jpg" style="height:100px;width:100px;" class="img33">
										</div>
										<input type="file" name="file" class="appbusinesspic33">
						</form></td>
						<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate34" method="post" enctype="multipart/form-data">
							<div id="method"></div>

										<div class="gallery text-center">
											<img src="/admin/image/advert/282-135.jpg" style="height:100px;width:100px;" class="img34">
										</div>
										<input type="file" name="file" class="appbusinesspic34">
						</form></td>
					</tr>
					<th>
						<td align="center"><b>商机工程轮播图</b></td>
					</th>
					<tr>
						<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate31" method="post" enctype="multipart/form-data">
							<div id="method"></div>
										<div class="gallery text-center">
											<img src="/admin/image/advert/1125-540.jpg" style="height:100px;width:100px;" class="img31">
										</div>
										<input type="file" name="file" class="appbusinesspic31">
						</form></td>
						<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate32" method="post" enctype="multipart/form-data">
							<div id="method"></div>
										<div class="gallery text-center">
											<img src="/admin/image/advert/1125-540.jpg" style="height:100px;width:100px;" class="img32">
										</div>
										<input type="file" name="file" class="appbusinesspic32">
						</form></td>
						<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate33" method="post" enctype="multipart/form-data">
							<div id="method"></div>

										<div class="gallery text-center">
											<img src="/admin/image/advert/1125-540.jpg" style="height:100px;width:100px;" class="img33">
										</div>
										<input type="file" name="file" class="appbusinesspic33">
						</form></td>
						<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate34" method="post" enctype="multipart/form-data">
							<div id="method"></div>

										<div class="gallery text-center">
											<img src="/admin/image/advert/1125-540.jpg" style="height:100px;width:100px;" class="img34">
										</div>
										<input type="file" name="file" class="appbusinesspic34">
						</form></td>
					</tr>
					<th>
						<td align="center"><b>商机人才轮播图</b></td>
					</th>
					<tr>
						<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate31" method="post" enctype="multipart/form-data">
							<div id="method"></div>
										<div class="gallery text-center">
											<img src="/admin/image/advert/1125-540.jpg" style="height:100px;width:100px;" class="img31">
										</div>
										<input type="file" name="file" class="appbusinesspic31">
						</form></td>
						<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate32" method="post" enctype="multipart/form-data">
							<div id="method"></div>
										<div class="gallery text-center">
											<img src="/admin/image/advert/1125-540.jpg" style="height:100px;width:100px;" class="img32">
										</div>
										<input type="file" name="file" class="appbusinesspic32">
						</form></td>
						<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate33" method="post" enctype="multipart/form-data">
							<div id="method"></div>

										<div class="gallery text-center">
											<img src="/admin/image/advert/1125-540.jpg" style="height:100px;width:100px;" class="img33">
										</div>
										<input type="file" name="file" class="appbusinesspic33">
						</form></td>
						<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate34" method="post" enctype="multipart/form-data">
							<div id="method"></div>

										<div class="gallery text-center">
											<img src="/admin/image/advert/1125-540.jpg" style="height:100px;width:100px;" class="img34">
										</div>
										<input type="file" name="file" class="appbusinesspic34">
						</form></td>
					</tr>
					<th>
						<td align="center"><b>商机找货轮播图</b></td>
					</th>
					<tr>
						<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate31" method="post" enctype="multipart/form-data">
							<div id="method"></div>
										<div class="gallery text-center">
											<img src="/admin/image/advert/1125-540.jpg" style="height:100px;width:100px;" class="img31">
										</div>
										<input type="file" name="file" class="appbusinesspic31">
						</form></td>
						<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate32" method="post" enctype="multipart/form-data">
							<div id="method"></div>
										<div class="gallery text-center">
											<img src="/admin/image/advert/1125-540.jpg" style="height:100px;width:100px;" class="img32">
										</div>
										<input type="file" name="file" class="appbusinesspic32">
						</form></td>
						<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate33" method="post" enctype="multipart/form-data">
							<div id="method"></div>

										<div class="gallery text-center">
											<img src="/admin/image/advert/1125-540.jpg" style="height:100px;width:100px;" class="img33">
										</div>
										<input type="file" name="file" class="appbusinesspic33">
						</form></td>
						<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate34" method="post" enctype="multipart/form-data">
							<div id="method"></div>

										<div class="gallery text-center">
											<img src="/admin/image/advert/1125-540.jpg" style="height:100px;width:100px;" class="img34">
										</div>
										<input type="file" name="file" class="appbusinesspic34">
						</form></td>
					</tr>

				</table>
				<!-- /.content-wrapper -->
				<input type="hidden" id="activeFlag" value="treeadvert">
			</div>
		</div>
	</div>
</div>
</div>
</div>
	<?php echo $__env->make('inc.admin.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<!-- ./wrapper -->
<!-- Bootstrap 3.3.5 -->
<script src="/admin/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="/admin/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/admin/dist/js/app.min.js"></script>
<script src="/admin/js/jquery.form.js"></script>
<script src="/admin/js/advert.js"></script>
</body>
</html>
