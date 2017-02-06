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
	.gallery{width: 80px; height: 80px; background: url("/admin/image/catetypecreate/add.jpg") center center no-repeat; border: solid #ddd 1px;  cursor: pointer; display:table-cell; vertical-align: middle;}
	.gallery img{max-width: 100%; max-height: 100%;}
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
			<h1>商铺浏览</h1>
		</section>

		<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-body">
						    <form action="/shop" method="get" class="form-horizontal form-inline f-ib">
						      <input type="text" name="name"  placeholder="店铺名称" class="form-control input-sm" >
									<select name="audit" >
										<option value="0">审核状态</option>
										<option value="1">待审核</option>
										<option value="2">审核已通过</option>
										<!--  <option value="3">审核未通过</option>-->
									</select>
						      <button type="submit" class="btn btn-primary btn-sm" id="filter">筛选</button>
						    </form>
							<table id="example1" class="table table-bordered table-striped">
								<tr>
									<th width="6%">属主ID</th>
									<th width="13%">名称</th>
									<th width="6%">申请时间</th>
									<th width="20%">店铺简介</th>
									<th width="18%">经营地</th>
									<th width="6%">店铺缩略图</th>
									<th width="6%">经营范围</th>
									<th width="10%">商铺状态</th>
									<th width="20%">操作</th>
								</tr>
								@foreach ($datacol['datas'] as $data)
								<tr>
								    <td align="center">{{$data['users_id']}}</td>
								    <td align="center">{{$data['name']}}</td>
								    <td align="center">{{date('Y/m/d',empty($data['created_at'])?0:$data['created_at'])}}</td>
									<td align="center">{{$data['introduction']}}</td>
									<td align="center">{{$data['premises']}}</td>
									<td align="center">
										<img src="{{$data['img']}}" width="50">
									</td>
									<td align="center">
										<button type="button" class="view f-ib btn btn-primary btn-xs" data-id="{{$data['sid']}}" data-toggle="modal" data-target="#myView">经营范围</button>
									</td>
								    <td align="center" class="check">
								    <?php
								    switch ($data['audit']){
									    case 1:
									        if (Gate::denies('shop-check')) {
									            echo "<button type='button'  class='disabled btn btn-xs'>通过</button>&nbsp;&nbsp;<button type='button'  class='disabled btn btn-xs'>不通过</button>";
									        } else {
									            echo "<button type='button' data-id='{$data['sid']}' data-uid='{$data['users_id']}' act='pass' class='check-success btn btn-success btn-xs'>通过</button>&nbsp;&nbsp;<button type='button' data-id='{$data['sid']}' data-uid='{$data['users_id']}' act='selfpass' class='check-success btn btn-success btn-xs'>通过自营</button>&nbsp;&nbsp;<button type='button' data-id='{$data['sid']}' act='' class='check-failed btn btn-danger btn-xs'>不通过</button>";
									        }
									        break;
									    case 2:
        									    echo "审核已通过";
        									    break;
									    case 3:
									        echo "审核未通过";
									        break;
										case 4:
									        echo "店铺已关闭";
								    }?>
								    </td>
									<td>
										@can('shop-advert')
        										<button type="button" class="advert btn btn-warning btn-xs" data-id="{{$data['sid']}}" data-toggle="modal" data-target="#myAdvert"
        										data-name="{{$data['name']}}"	>广告</button>
										@endcan
										{{--商铺开关权限--}}
										@can('shop-toggle')
        										<button type="button" class="shop btn-danger btn-xs {{($data['audit']==2)?'':'hidden'}}"  state="4"  data-id="{{$data['sid']}}">关闭</button>
        										<button type="button" class="shop btn-success btn-xs {{($data['audit']==4)?'':'hidden'}}" state="2"  data-id="{{$data['sid']}}">开启</button>
        									@endcan
        									{{---查看指定商铺的货品--}}
        									@can('create-goods')
        										<button type="button" class="btn btn-info btn-xs" data-id="{{$data['sid']}}" data-toggle="modal">
        										<a href="/good?sid={{$data['sid']}}"><font color="white">商品管理</font></a></button>
										@endcan
									</td>
								</tr>
								@endforeach
								<tr>
								  <td colspan="7" align="center">
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

	{{--经营范围--}}
	<div class="modal fade" id="myView" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel"></h4>
				</div>
				<div class="modal-body">
					<dl class="dl-horizontal">
						<dt id="cat">主营类别：</dt>
					</dl>
					<div id="brand">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal">关闭</button>
				</div>
			</div>
		</div>
	</div>

	<!-- /.content-wrapper -->
	<input type="hidden" id="activeFlag" value="treeshop">
	@include('inc.admin.footer')
</div>
{{--广告--}}
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
					<tr>
						<td align="right" width="25%">商铺名称</td>
						<td align="left" id="advert-shopsname"></td>
					</tr>
					<input type="hidden" id="advert-sid" value="">
					<th>
						<td align="center"><b>商城轮播图</b></td>
					</th>
					<tr>
						<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate31" method="post" enctype="multipart/form-data">
							<div id="method"></div>
										<div class="gallery text-center">
											<img src="/admin/image/advert/1125-540.jpg" style="height:100px;width:100px;" class="img31">
										</div>
										<input type="file" name="file" class="newgoodspic31">
						</form></td>
						<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate32" method="post" enctype="multipart/form-data">
							<div id="method"></div>
										<div class="gallery text-center">
											<img src="/admin/image/advert/1125-540.jpg" style="height:100px;width:100px;" class="img32">
										</div>
										<input type="file" name="file" class="newgoodspic32">
						</form></td>
						<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate33" method="post" enctype="multipart/form-data">
							<div id="method"></div>

										<div class="gallery text-center">
											<img src="/admin/image/advert/1125-540.jpg" style="height:100px;width:100px;" class="img33">
										</div>
										<input type="file" name="file" class="newgoodspic33">
						</form></td>
						<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate34" method="post" enctype="multipart/form-data">
							<div id="method"></div>

										<div class="gallery text-center">
											<img src="/admin/image/advert/1125-540.jpg" style="height:100px;width:100px;" class="img34">
										</div>
										<input type="file" name="file" class="newgoodspic34">
						</form></td>
					</tr>
					<th>
						<td align="center"><b>金牌店铺</b></td>
					</th>
					<tr>
						<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate61" method="post" enctype="multipart/form-data">
							<div id="method"></div>
										<div class="gallery text-center">
											<img src="/admin/image/advert/1125-300.jpg" style="height:100px;width:100px;" class="img61">
										</div>
										<input type="file" name="file" class="newgoodspic61">
						</form></td>
						<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate62" method="post" enctype="multipart/form-data">
							<div id="method"></div>
										<div class="gallery text-center">
											<img src="/admin/image/advert/561-300.png" style="height:100px;width:100px;" class="img62">
										</div>
										<input type="file" name="file" class="newgoodspic62">
						</form></td>
						<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate63" method="post" enctype="multipart/form-data">
							<div id="method"></div>

										<div class="gallery text-center">
											<img src="/admin/image/advert/561-300.png" style="height:100px;width:100px;" class="img63">
										</div>
										<input type="file" name="file" class="newgoodspic63">
						</form></td>
					</tr>
					<th>
						<td align="center"><b>下面的那个单一店铺</b></td>
					</th>
					<tr>
						<td><form role="form" style="height:100px;width:100px" class="form-horizontal" action="" id="formToUpdate81" method="post" enctype="multipart/form-data">
							<div id="method"></div>
										<div class="gallery text-center">
											<img src="/admin/image/advert/1125-300.jpg" style="height:100px;width:100px;" class="img81">
										</div>
										<input type="file" name="file" class="newgoodspic81">
						</form></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
<!-- ./wrapper -->
<!-- Bootstrap 3.3.5 -->
<script src="/admin/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="/admin/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/admin/dist/js/app.min.js"></script>
<script src="/admin/js/jquery.form.js"></script>
<script src="/admin/js/shop.js"></script>
</body>
</html>
