<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>商铺列表</title>
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
			<h1>店铺浏览</h1>
		</section>

		<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-body">
						    <form action="/shop" method="get" class="form-horizontal form-inline f-ib">
						      <input type="text" name="name"  placeholder="店铺名称" class="form-control input-sm" value="<?php echo e($datacol['args']['name']); ?>">&nbsp;
						        审核状态：
								<label class="radio-inline">
									<input type="radio" name="audit" id="audit1" class="audit" value="1">待审核
								</label>
								<label class="radio-inline">
									<input type="radio" name="audit" id="audit2" class="audit" value="2">审核未通过
								</label>
								<label class="radio-inline">
									<input type="radio" name="audit" id="audit3" class="audit" value="3">审核已通过
								</label>
						      <button type="submit" class="btn btn-primary btn-sm" id="filter">筛选</button>
						    </form>
		                    <a href="/shop" class="btn btn-default btn-sm unplay f-ib" role="button">取消筛选</a>
							<table id="example1" class="table table-bordered table-striped">
								<tr>
									<th>名称</th>
									<th>主营品牌</th>
									<th>品牌授权书</th>
									<th>主营类别</th>
									<th>店铺简介</th>
									<th>经营地</th>
									<th>店铺缩略图</th>
									<th>审核</th>
								</tr>
								<?php foreach($datacol['datas'] as $data): ?>
								<tr>
								    <td align="center"><?php echo e($data['name']); ?></td>
								    <td align="center"><?php echo e($data['mainbrand']); ?></td>
								    <td align="center">
										<img src="<?php echo e($data['authorization']); ?>" width="50">
									</td>
									<td align="center"><?php echo e($data['category']); ?></td>
									<td align="center"><?php echo e($data['introduction']); ?></td>
									<td align="center"><?php echo e($data['premises']); ?></td>
									<td align="center">
										<img src="<?php echo e($data['img']); ?>" width="50">
									</td>
								    <td align="center">
								    <?php
								    switch ($data['audit']){
									    case 1:
									    echo "<button type='button' data-id='{$data['sid']}' class='check-success btn btn-success btn-xs'>通过</button>&nbsp;&nbsp;<button type='button' data-id='{$data['sid']}'  class='check-failed btn btn-danger btn-xs'>不通过</button>";
									    break;
									    case 2:
									    echo "审核未通过";
									    break;
									    case 3:
									    echo "审核已通过";
									    break;
								    }?>
								    </td>
								</tr>  
								<?php endforeach; ?>
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
	<!-- /.content-wrapper -->
	<input type="hidden" id="activeFlag" value="treeshop">
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
if(isset($datacol['args']['audit'])){
	switch ($datacol['args']['audit']){
		case 1:
			echo '<script>$(function(){$("#audit1").attr("checked",true)});</script>';
			break;
		case 2:
		    echo '<script>$(function(){$("#audit2").attr("checked",true)});</script>';
		    break;
		case 3:
			echo '<script>$(function(){$("#audit3").attr("checked",true)});</script>';
			break;
		default:
		    echo '<script>$(function(){$("#audit1").attr("checked",false);$("#audit2").attr("checked",false)});$("#audit3").attr("checked",false)});</script>';
	}
}
?>
<script>
	$(function(){
		$("body").on("click",'.check-success',function(){
			if(confirm('确定要通过吗？')){
				var id=parseInt($(this).attr("data-id"));
				$.get("/checkShop",{"sid":id,"certified":"yes"},function(data,status){
					alert(data);
					setTimeout(function(){location.reload()},1000);
				});
			}
		})
		$("body").on("click",'.check-failed',function(){
			if(confirm('确定审核不通过吗？')){
				var id=parseInt($(this).attr("data-id"));
				$.get("/checkShop",{"sid":id,"certified":"no"},function(data,status){
					alert(data);
					setTimeout(function(){location.reload()},1000);
				});
			}
		})
	})
</script>
</body>
</html>
