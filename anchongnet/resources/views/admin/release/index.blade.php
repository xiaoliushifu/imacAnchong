<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>聊聊列表</title>
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
			<h1>{{ ($all)? "所有聊聊":"我的聊聊" }}</h1>
		</section>

		<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-body">
						    <form action="{{ ($all)? '/releases' : '/release' }}" method="get" class="form-horizontal form-inline f-ib">
								标签类型：
								<select class="form-control" name="tag">
									<option value="" id="check">请选择</option>
									<option value="闲聊" id="tag0">闲聊</option>
									<option value="问问" id="tag1">问问</option>
									<option value="活动" id="tag2">活动</option>
								</select>
						      <button type="submit" class="btn btn-primary btn-sm" id="filter">筛选</button>
						    </form>
		                    <a href="{{ ($all)? '/releases' : '/release'  }}" class="btn btn-default btn-sm unplay f-ib" role="button">取消筛选</a>
							<table id="example1" class="table table-bordered table-striped">
								<tr>
									<th width="15%">标题</th>
									<th width="55%">内容</th>
									<th width="15%">标签</th>
									<th width="15%">操作</th>
								</tr>
								@foreach ($datacol['datas'] as $data)
								<tr>
								    <td align="center">{{$data['title']}}</td>
									<td align="center">
										<?php
										    echo $data['content'];
										?>
									</td>
									<td align="center">{{$data['tags']}}</td>
									<td align="center">
										<a href="/comment?chat={{$data['chat_id']}}" target="_blank" class="btn btn-primary btn-xs">查看评论</a>
										<button type='button' class='edit f-ib btn btn-primary btn-xs' data-id="{{$data['chat_id']}}" data-uid="{{$data['users_id']}}" data-toggle="modal" data-target="#myModal">编辑</button>
										<button type="button" class="del f-ib btn btn-danger btn-xs" data-id="{{$data['chat_id']}}">删除</button>
									</td>
								</tr>
								@endforeach
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
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="myModalLabel">编辑发布</h4>
				</div>
				<div class="modal-body">
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
								<textarea name="content" id="content" class="form-control" rows="5"></textarea>
							</div>
						</div><!--end form-group-->
						<div class="form-group text-center">
							<label class="col-sm-3 control-label"></label>
							<div class="col-sm-3">
								<button type="button" class="btn btn-info" id="save">保存</button>
							</div>
						</div><!--end form-group text-center-->
					</form>
					<hr>
					<h5 class="text-center">图片信息</h5>
						<div id="method"></div>
						<input type="hidden" name="cid" id="cid">
						<div class="gal form-group">
							<table class="table">
								<input type="hidden" id="chat_id" value="">
								<input type="hidden" id="imgdata" value="">

								<tr id="imgcontent">
								</tr>
							</table>
						</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /.content-wrapper -->
	<input type="hidden" id="activeFlag" value="treerelease">
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
<script src="/admin/js/release.js"></script>
<?php
if(isset($datacol['args']['tag'])){
	switch ($datacol['args']['tag']){
		case "":
			echo '<script>$(function(){$("#check").attr("selected",true)})</script>';
			break;
		case "闲聊":
			echo '<script>$(function(){$("#tag0").attr("selected",true)});</script>';
			break;
		case "问问":
			echo '<script>$(function(){$("#tag1").attr("selected",true)});</script>';
			break;
		case "活动":
		    echo '<script>$(function(){$("#tag2").attr("selected",true)});</script>';
		    break;
	}
}
?>
</body>
</html>
