<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>用户浏览</title>
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
		.radio-inline{position: relative; top: -4px;}
	</style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
	<?php echo $__env->make('inc.admin.mainHead', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<!-- Left side column. contains the logo and sidebar -->
	<aside class="main-sidebar">
		<!-- sidebar: style can be found in sidebar.less -->
		<?php echo $__env->make('inc.admin.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<!-- /.sidebar -->
	</aside>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>用户浏览</h1>
		</section>

		<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-body">
						    <form action="/users" method="get" class="form-horizontal form-inline f-ib">
						      <input type="number" name="phone"  placeholder="手机号码" class="form-control input-sm" value="<?php echo e($datacol['args']['phone']); ?>">&nbsp;
						        会员等级：
								<label class="radio-inline">
									<input type="radio" name="users_rank" id="level0" class="level" value="1">普通会员
								</label>
								<label class="radio-inline">
									<input type="radio" name="users_rank" id="level1" class="level" value="2">商家
								</label>
						      <button type="submit" class="btn btn-primary btn-sm" id="filter">筛选</button>
						    </form>
		                    <a href="/users" class="btn btn-default btn-sm unplay f-ib" role="button">取消筛选</a>
							<table id="example1" class="table table-bordered table-striped">
								<tr>
									<th>ID</th>
									<th>电话</th>
									<th>邮箱</th>
									<th>用户等级</th>
								</tr>
								<?php foreach($datacol['datas'] as $data): ?>
								<tr>
								  <td align="center"><?php echo e($data['users_id']); ?></td>
								  <td align="center"><?php echo e($data['phone']); ?></td>
								  <td align="center"><?php echo e($data['email']); ?></td>
								  <td align="center">
								  <?php 
								  switch ($data['users_rank']){
									  case 1:
									  echo $data['id'];
									  echo "普通会员";
									  break;
									  case 2:
									  echo "商户";
									  break;
									  case 3:
									  echo "管理员";
									  break;
								  }?>
								  </td>
								</tr>  
								<?php endforeach; ?>
								<tr>
								  <td colspan="4" align="center">
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
	<input type="hidden" id="activeFlag" value="treeuser">
	<?php echo $__env->make('inc.admin.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>
<!-- ./wrapper -->
<!-- Bootstrap 3.3.5 -->
<script src="/admin/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="/admin/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/admin/dist/js/app.min.js"></script>
<?php
if(isset($datacol['args']['users_rank'])){
	switch ($datacol['args']['users_rank']){
		case 1:
		echo '<script>$(function(){$("#level0").attr("checked",true)});</script>';
		break;
		case 2:
		echo '<script>$(function(){$("#level1").attr("checked",true)});</script>';
		break;
		default:
		echo '<script>$(function(){$("#level0").attr("checked",false);$("#level1").attr("checked",false)});</script>';
	}
}
?>
</body>
</html>
