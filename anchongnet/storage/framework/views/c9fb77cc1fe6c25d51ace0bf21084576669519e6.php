<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>我的商机</title>
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
	.pic{position: relative; top: 7px; visibility: hidden;}
	.gal{margin-top: 20px;}
	.gallerys li{width:10%; min-width: 80px; position: relative;}
	.delpic{position: absolute; right: 0; top: -5px;}
	.gallery{width: 80px; height: 80px; background: url("/admin/image/catetypecreate/add.jpg") center center no-repeat; border: solid #ddd 1px;  cursor: pointer; display:table-cell; vertical-align: middle;}
	.gallery img{max-width: 100%; max-height: 100%;}
	.addpic{margin-top: -100px;}
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
			<h1>我的商机</h1>
		</section>

		<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-body">
						    <form action="/business" method="get" class="form-horizontal form-inline f-ib">
								商机类型：
								<select class="form-control" name="type">
									<option value="" id="check">请选择</option>
									<option value="1" id="type1">发布工程</option>
									<option value="2" id="type2">承接工程</option>
									<option value="3" id="type3">发布人才</option>
									<option value="4" id="type4">招聘人才</option>
									<option value="5" id="type5">找商品</option>
								</select>
						      <button type="submit" class="btn btn-primary btn-sm" id="filter">筛选</button>
						    </form>
		                    <a href="/business" class="btn btn-default btn-sm unplay f-ib" role="button">取消筛选</a>
							<table id="example1" class="table table-bordered table-striped">
								<tr>
									<th>标题</th>
									<th>电话</th>
									<th>联系人</th>
									<th>类型</th>
									<th>操作</th>
								</tr>
								<?php foreach($datacol['datas'] as $data): ?>
								<tr>
								    <td align="center"><?php echo e($data['title']); ?></td>
									<td align="center"><?php echo e($data['phone']); ?></td>
									<td align="center"><?php echo e($data['contact']); ?></td>
									<td align="center">
									<?php
										switch($data['type']){
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
											case 5:
												echo "找商品";
												break;
										}
									?>
									</td>
									<td align="center">
										<button type="button" class="view f-ib btn btn-primary btn-xs" data-id="<?php echo e($data['bid']); ?>" data-toggle="modal" data-target="#myview">查看详情</button>
										<button type='button' class='edit f-ib btn btn-primary btn-xs' data-id="<?php echo e($data['bid']); ?>" data-uid="<?php echo e($data['users_id']); ?>" data-toggle="modal" data-target="#myModal">编辑</button>
										<button type="button" class="del f-ib btn btn-danger btn-xs" data-id="<?php echo e($data['bid']); ?>">删除</button>
										<button type="button" class="advert f-ib btn btn-warning btn-xs" data-id="<?php echo e($data['bid']); ?>"  data-toggle="modal"
										>广告推送</button>
										<button type="button" class="advertcancel f-ib btn btn-warning btn-xs" data-id="<?php echo e($data['bid']); ?>"  data-toggle="modal"
										>取消推送</button>
										<button type="button" class="advertpic f-ib btn btn-info btn-xs" data-id="<?php echo e($data['bid']); ?>"  data-toggle="modal"
										data-target="#myAdvert"
										>广告轮播图</button>
									</td>
								</tr>
								<?php endforeach; ?>
								<tr>
								  <td colspan="5" align="center">
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
	<div class="modal fade" id="myview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h5 class="modal-title" id="bustitle">&nbsp;</h5>
				</div>
				<div class="modal-body">
					<table class="table">
						<tr>
							<td align="right" width="25%">标题</td>
							<td align="left" id="vtitle"></td>
						</tr>
						<tr>
							<td align="right">内容</td>
							<td align="left" id="vcontent"></td>
						</tr>
						<tr>
							<td align="right">图片</td>
							<td align="left">
								<ul id="vimg" class="list-group">

								</ul>
							</td>
						</tr>
						<tr>
							<td align="right">标签</td>
							<td align="left" id="vtag"></td>
						</tr>
						<tr>
							<td align="right">联系电话</td>
							<td align="left" id="vphone"></td>
						</tr>
						<tr>
							<td align="right">联系人</td>
							<td align="left" id="vcontact"></td>
						</tr>
						<tr>
							<td align="right">类型</td>
							<td align="left" id="vtype"></td>
						</tr>
						<tr>
							<td align="right">发布时间</td>
							<td align="left" id="vcreate"></td>
						</tr>
						<tr>
							<td align="right">更新时间</td>
							<td align="left" id="vupdate"></td>
						</tr>
						<tr>
							<td align="right">区域</td>
							<td align="left" id="varea"></td>
						</tr>
						<tr>
							<td align="right">工程结束时间</td>
							<td align="left" id="vendtime"></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="myModalLabel">编辑商机</h4>
				</div>
				<div class="modal-body">
					<h5 class="text-center">基本信息</h5>
					<form role="form" class="form-horizontal" action="" method="post" id="updateform">
						<input type="hidden" name="_method" value="PUT">
						<div class="form-group">
							<label class="col-sm-2 control-label" for="title">标题</label>
							<div class="col-sm-9">
								<input type="text" name="title" id="title" class="form-control" required/>
							</div>
						</div><!--end form-group-->
						<div class="form-group">
							<label class="col-sm-2 control-label" for="content">内容</label>
							<div class="col-sm-9">
								<textarea class="form-control" rows="5" id="content" required name="content"></textarea>
							</div>
						</div><!--end form-group-->
						<div class="form-group">
							<label class="col-sm-2 control-label" for="tag">标签</label>
							<div class="col-sm-9">
								<select name="tag" id="tag" class="form-control" required>

								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="contact">联系人</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="contact" name="contact">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="phone">电话</label>
							<div class="col-sm-9">
								<input type="number" class="form-control" id="phone" name="phone" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="etype">类型</label>
							<div class="col-sm-9">
								<select name="type" class="form-control" id="etype" required>
									<option value="1">发布工程</option>
									<option value="2">承接工程</option>
									<option value="3">发布人才</option>
									<option value="4">招聘人才</option>
									<option value="5">找商品</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="area">区域</label>
							<div class="col-sm-9">
								<input type="text" id="area" class="form-control" name="area">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="area">工程结束时间</label>
							<div class="col-sm-9">
								<input type="text" id="endtime" class="form-control" name="endtime">
							</div>
						</div>
						<div class="form-group text-center">
							<label class="col-sm-3 control-label"></label>
							<div class="col-sm-3">
								<button type="submit" class="btn btn-info" id="save">保存</button>
							</div>
						</div><!--end form-group text-center-->
					</form>
					<hr>
					<h5 class="text-center">图片信息</h5>
					<form role="form" class="form-horizontal" action="" id="formToUpdate" method="post" enctype="multipart/form-data">
						<div id="method"></div>
						<input type="hidden" name="bid" id="bid">
						<div class="gal form-group">
							<label for="pic" class="col-sm-2 control-label">商机图片</label>
							<ul class="gallerys col-sm-10 list-inline">
								<li class="template hidden">
									<div class="gallery text-center">
										<img src="" class="img">
									</div>
									<input type="file" name="file" class="pic">
								</li>
								<button type="button" class="goodpic addpic btn btn-default" title="继续添加图片" id="addforgood">+</button>
							</ul>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="myAdvert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-body">
					<table class="table">
						<input type="hidden" id="advert-bid" value="">
						<th>
							<td align="center"><b>商机首页轮播图</b></td>
						</th>
						<tr>
							<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate21" method="post" enctype="multipart/form-data">
								<div id="method"></div>
											<div class="gallery text-center">
												<img src="/admin/image/advert/1125-540.jpg" style="height:100px;width:100px;" class="img21">
											</div>
											<input type="file" name="file" class="appbusinesspic21">
							</form></td>
							<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate22" method="post" enctype="multipart/form-data">
								<div id="method"></div>
											<div class="gallery text-center">
												<img src="/admin/image/advert/1125-540.jpg" style="height:100px;width:100px;" class="img22">
											</div>
											<input type="file" name="file" class="appbusinesspic22">
							</form></td>
							<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate23" method="post" enctype="multipart/form-data">
								<div id="method"></div>

											<div class="gallery text-center">
												<img src="/admin/image/advert/1125-540.jpg" style="height:100px;width:100px;" class="img23">
											</div>
											<input type="file" name="file" class="appbusinesspic23">
							</form></td>
							<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate24" method="post" enctype="multipart/form-data">
								<div id="method"></div>

											<div class="gallery text-center">
												<img src="/admin/image/advert/1125-540.jpg" style="height:100px;width:100px;" class="img24">
											</div>
											<input type="file" name="file" class="appbusinesspic24">
							</form></td>
						</tr>
						<th>
							<td align="center"><b>商机首页最新招标项目图片</b></td>
						</th>
						<tr>
							<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate41" method="post" enctype="multipart/form-data">
								<div id="method"></div>
											<div class="gallery text-center">
												<img src="/admin/image/advert/564-270.jpg" style="height:100px;width:100px;" class="img41">
											</div>
											<input type="file" name="file" class="appbusinesspic41">
							</form></td>
							<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate42" method="post" enctype="multipart/form-data">
								<div id="method"></div>
											<div class="gallery text-center">
												<img src="/admin/image/advert/561-135.jpg" style="height:100px;width:100px;" class="img42">
											</div>
											<input type="file" name="file" class="appbusinesspic42">
							</form></td>
							<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate43" method="post" enctype="multipart/form-data">
								<div id="method"></div>

											<div class="gallery text-center">
												<img src="/admin/image/advert/282-135.jpg" style="height:100px;width:100px;" class="img43">
											</div>
											<input type="file" name="file" class="appbusinesspic43">
							</form></td>
							<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate44" method="post" enctype="multipart/form-data">
								<div id="method"></div>

											<div class="gallery text-center">
												<img src="/admin/image/advert/282-135.jpg" style="height:100px;width:100px;" class="img44">
											</div>
											<input type="file" name="file" class="appbusinesspic44">
							</form></td>
						</tr>
						<th>
							<td align="center"><b>商机工程轮播图</b></td>
						</th>
						<tr>
							<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate111" method="post" enctype="multipart/form-data">
								<div id="method"></div>
											<div class="gallery text-center">
												<img src="/admin/image/advert/1125-540.jpg" style="height:100px;width:100px;" class="img111">
											</div>
											<input type="file" name="file" class="appbusinesspic111">
							</form></td>
							<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate112" method="post" enctype="multipart/form-data">
								<div id="method"></div>
											<div class="gallery text-center">
												<img src="/admin/image/advert/1125-540.jpg" style="height:100px;width:100px;" class="img112">
											</div>
											<input type="file" name="file" class="appbusinesspic112">
							</form></td>
							<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate113" method="post" enctype="multipart/form-data">
								<div id="method"></div>

											<div class="gallery text-center">
												<img src="/admin/image/advert/1125-540.jpg" style="height:100px;width:100px;" class="img113">
											</div>
											<input type="file" name="file" class="appbusinesspic113">
							</form></td>
							<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate114" method="post" enctype="multipart/form-data">
								<div id="method"></div>

											<div class="gallery text-center">
												<img src="/admin/image/advert/1125-540.jpg" style="height:100px;width:100px;" class="img114">
											</div>
											<input type="file" name="file" class="appbusinesspic114">
							</form></td>
						</tr>
						<th>
							<td align="center"><b>商机人才轮播图</b></td>
						</th>
						<tr>
							<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate121" method="post" enctype="multipart/form-data">
								<div id="method"></div>
											<div class="gallery text-center">
												<img src="/admin/image/advert/1125-540.jpg" style="height:100px;width:100px;" class="img121">
											</div>
											<input type="file" name="file" class="appbusinesspic121">
							</form></td>
							<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate122" method="post" enctype="multipart/form-data">
								<div id="method"></div>
											<div class="gallery text-center">
												<img src="/admin/image/advert/1125-540.jpg" style="height:100px;width:100px;" class="img122">
											</div>
											<input type="file" name="file" class="appbusinesspic122">
							</form></td>
							<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate123" method="post" enctype="multipart/form-data">
								<div id="method"></div>

											<div class="gallery text-center">
												<img src="/admin/image/advert/1125-540.jpg" style="height:100px;width:100px;" class="img123">
											</div>
											<input type="file" name="file" class="appbusinesspic123">
							</form></td>
							<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate124" method="post" enctype="multipart/form-data">
								<div id="method"></div>

											<div class="gallery text-center">
												<img src="/admin/image/advert/1125-540.jpg" style="height:100px;width:100px;" class="img124">
											</div>
											<input type="file" name="file" class="appbusinesspic124">
							</form></td>
						</tr>
						<th>
							<td align="center"><b>商机找货轮播图</b></td>
						</th>
						<tr>
							<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate131" method="post" enctype="multipart/form-data">
								<div id="method"></div>
											<div class="gallery text-center">
												<img src="/admin/image/advert/1125-540.jpg" style="height:100px;width:100px;" class="img131">
											</div>
											<input type="file" name="file" class="appbusinesspic131">
							</form></td>
							<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate132" method="post" enctype="multipart/form-data">
								<div id="method"></div>
											<div class="gallery text-center">
												<img src="/admin/image/advert/1125-540.jpg" style="height:100px;width:100px;" class="img132">
											</div>
											<input type="file" name="file" class="appbusinesspic132">
							</form></td>
							<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate133" method="post" enctype="multipart/form-data">
								<div id="method"></div>

											<div class="gallery text-center">
												<img src="/admin/image/advert/1125-540.jpg" style="height:100px;width:100px;" class="img133">
											</div>
											<input type="file" name="file" class="appbusinesspic133">
							</form></td>
							<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate134" method="post" enctype="multipart/form-data">
								<div id="method"></div>

											<div class="gallery text-center">
												<img src="/admin/image/advert/1125-540.jpg" style="height:100px;width:100px;" class="img134">
											</div>
											<input type="file" name="file" class="appbusinesspic134">
							</form></td>
						</tr>
					</table>
                </div>
            </div>
        </div>
    </div>



	<!-- /.content-wrapper -->
	<input type="hidden" id="activeFlag" value="treebusiness">
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
<script src="/admin/js/business.js"></script>
<?php
if(isset($datacol['args']['type'])){
	switch ($datacol['args']['type']){
		case "":
			echo '<script>$(function(){$("#check").attr("selected",true)})</script>';
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
		case 5:
			echo '<script>$(function(){$("#type5").attr("selected",true)});</script>';
			break;
	}
}
?>
</body>
</html>
