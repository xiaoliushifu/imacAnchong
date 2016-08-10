<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>意见反馈</title>
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
	img{max-width: 100%; max-height: 500px;}
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
			<h1>意见反馈</h1><div align="center"><font color="red">{{ Session::get('commentresult') }}</font></div>
		</section>

		<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-body">
							<table id="example1" class="table table-bordered table-striped">
								<tr>
									<th width="5%">编号</th>
									<th width="20%">标题</th>
									<th width="15%">联系电话</th>
									<th width="10%">联系人</th>
									<th width="7%">状态</th>
									<th width="23%">操作</th>
								</tr>
								@foreach ($datacol['datas'] as $data)
								<tr>
									<td align="center">{{$data['feed_id']}}</td>
								    <td align="center">{{$data['title']}}</td>
									<td align="center">{{$data['phone']}}</td>
									<td align="center">{{$data['contact']}}</td>
									<td align="center">
										<?php
											switch($data['state']){
												case 1:
													echo '<font color="red">未查看</font>';
													break;
												case 2:
													echo '<font color="orange">已查看</font>';
													break;
												case 3:
													echo '<font color="blue">处理中</font>';
													break;
												case 4:
													echo '<font color="green">已修复</font>';
													break;
											}
										?>
									</td>
									<td align="center">
										<button type='button' class='view f-ib btn btn-primary btn-xs' data-id="{{$data['feed_id']}}" data-uid="{{$data['users_id']}}" data-title="{{$data['title']}}" data-content="{{$data['content']}}" data-state="{{$data['state']}}" data-phonemodel="{{$data['phonemodel']}}" data-phone="{{$data['phone']}}" data-contact="{{$data['contact']}}" data-toggle="modal" data-target="#myModal">查看</button>
										<button type="button" class="del f-ib btn btn-danger btn-xs" data-id="{{$data['feed_id']}}">删除</button>
										<button type="button" class="success f-ib btn btn-success btn-xs" data-id="{{$data['feed_id']}}">处理</button>
										<button type="button" class="comment f-ib btn btn-warning btn-xs" data-id="{{$data['feed_id']}}" data-uid="{{$data['users_id']}}" data-toggle="modal" data-target="#mycomment">已修复</button>

									</td>
								</tr>
								@endforeach
								<tr>
								  <td colspan="4" align="center">
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
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="location.reload();">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="myModalLabel">查看反馈</h4>
				</div>
				<div class="modal-body">
					<form role="form" class="form-horizontal" action="" method="post" id="updateform">
						<input type="hidden" name="_method" value="PUT">
						<div class="form-group">
							<label class="col-sm-2 control-label" for="title">标题</label>
							<div class="col-sm-9">
								<label class="col-sm-2 control-label" id="feedbacktitle"></label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="content">内容</label>
							<div class="col-sm-9">
								<label class="col-sm-2 control-label" id="feedbackcontent"></label>
							</div>
						</div><!--end form-group-->
						<div class="form-group">
							<label class="col-sm-2 control-label" for="content">联系电话</label>
							<div class="col-sm-9">
								<label class="col-sm-2 control-label" id="feedbackphone"></label>
							</div>
						</div><!--end form-group-->
						<div class="form-group">
							<label class="col-sm-2 control-label" for="content">联系人</label>
							<div class="col-sm-9">
								<label class="col-sm-2 control-label" id="feedbackcontact"></label>
							</div>
						</div><!--end form-group-->
						<div class="form-group">
							<label class="col-sm-2 control-label" for="content">手机型号</label>
							<div class="col-sm-9">
								<label class="col-sm-2 control-label" id="feedbackphonemodel"></label>
							</div>
						</div><!--end form-group-->
					</form>
					<hr>
					<h5 class="text-center">图片信息</h5>
					<div id="method"></div>
					<div class="gal form-group">
						<table class="table">
							<tr id="imgcontent">
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal -->
	<div class="modal fade" id="mycomment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="myModalLabel">回复反馈</h4>
				</div>
				<div class="modal-body">
					<form role="form" class="form-horizontal" action="/feedback/feedbackreply" method="POST" id="formToUpdate">
						<input type="hidden" class="form-control" id="commentfeedid" name="feed_id">
						<input type="hidden" class="form-control" id="commentfeedusersid" name="users_id">
						<div class="form-group">
							<label class="col-sm-2 control-label" for="title">标题</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="commenttitle" required name="title">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="content">内容</label>
							<div class="col-sm-9">
								<textarea class="form-control" rows="5" id="commentcontent" required name="content"></textarea>
							</div>
						</div><!--end form-group-->
						<div class="form-group">
							<label class="col-sm-2 control-label" for="content">奖励信息</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="reward" name="reward" placeholder="无奖励则不填">
							</div>
						</div><!--end form-group-->
						<div class="form-group text-center">
							<label class="col-sm-3 control-label"></label>
							<div class="col-sm-3">
								<button type="submit" class="btn btn-info" id="save">回复</button>
							</div>
						</div><!--end form-group text-center-->
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- /.content-wrapper -->
	<input type="hidden" id="activeFlag" value="treefeedback">
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
<script src="/admin/js/feedback.js"></script>
</body>
</html>
