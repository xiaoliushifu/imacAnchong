<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>评论列表</title>
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
	<?php echo $__env->make('inc.admin.mainHead', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<!-- Left side column. contains the logo and sidebar -->
	<aside class="main-sidebar">
		<!-- sidebar: style can be found in sidebar.less -->
		<?php echo $__env->make('inc.admin.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
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
									<th>评论人</th>
									<th>内容</th>
									<th>评论时间</th>
									<th>操作</th>
								</tr>
								<?php foreach($datas as $data): ?>
								<tr>
								    <td align="center"><?php echo e($data['name']); ?></td>
									<td align="center"><?php echo e($data['content']); ?></td>
									<td align="center"><?php echo e($data['created_at']); ?></td>
									<td align="center">
										<button type='button' class='reply btn btn-primary btn-xs' data-id="<?php echo e($data['comid']); ?>" data-toggle="modal" data-target="#myModal" data-comname="<?php echo e($data['name']); ?>">回复</button>
										<button type="button" class="del btn btn-danger btn-xs" data-id="<?php echo e($data['comid']); ?>">删除</button>
									</td>
								</tr>  
								<?php endforeach; ?>
								<tr>
								  <td colspan="4" align="center">
									<?php echo $datas->render(); ?>
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
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="myModalLabel">回复评论</h4>
				</div>
				<div class="modal-body">
					<form role="form" class="form-horizontal" action="/reply" method="post" id="replyform">
						<input type="hidden" name="comid" id="comid">
						<input type="hidden" name="name" value="<?php echo e(Auth::user()['username']); ?>">
						<input type="hidden" name="headpic" value="<?php echo e(Auth::user()['headpic']); ?>">
						<input type="hidden" name="comname" id="comname">
						<input type="hidden" name="chat" value="<?php echo e($_REQUEST['chat']); ?>">
						<div class="form-group">
							<label class="col-sm-3 control-label" for="content">编辑内容</label>
							<div class="col-sm-8">
								<textarea name="content" id="content" class="form-control" required rows="5"></textarea>
							</div>
						</div><!--end form-group-->
						<div class="form-group text-center">
							<label class="col-sm-3 control-label"></label>
							<div class="col-sm-3">
								<button type="button" class="btn btn-info" id="reply">回复</button>
							</div>
						</div><!--end form-group text-center-->
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- /.content-wrapper -->
	<input type="hidden" id="activeFlag" value="treerelease">
	<?php echo $__env->make('inc.admin.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>
<!-- ./wrapper -->
<!-- Bootstrap 3.3.5 -->
<script src="/admin/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="/admin/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/admin/dist/js/app.min.js"></script>
<script src="/admin/js/jquery.form.js"></script>
<script src="/admin/js/comment.js"></script>
</body>
</html>
