<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>资讯列表</title>
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
			<h1>资讯查看</h1>
		</section>

		<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-body">
						    <form action="/release" method="get" class="form-horizontal form-inline f-ib">
								名称筛选：
								<input type="text" name="search">
						      <button type="submit" class="btn btn-primary btn-sm" id="filter">筛选</button>
						    </form>
		                    <a href="/release" class="btn btn-default btn-sm unplay f-ib" role="button">取消筛选</a>
							<table id="example1" class="table table-bordered table-striped">
								<tr>
									<th width="40%">标题</th>
									<th width="40%">图片</th>
									<th width="15%">操作</th>
								</tr>
								@foreach ($datacol as $data)
								<tr>
								    <td align="center">
										{{$data['title']}}
									</td>
									<td align="center">
										<img style="height:100px;width:100px;" src="{{$data['img']}}">
									</td>
									<td align="center">
										@can('news-action')
										<button type='button' class='edit f-ib btn btn-primary btn-xs' data-toggle="modal" data-id="{{$data['infor_id']}}" data-target="#myModal">编辑</button>
										<button type="button" class="del f-ib btn btn-danger btn-xs" data_id={{$data['infor_id']}}>删除</button>
										@endcan
										@if(Auth::user()['user_rank']==3)
										    @can('advert-toggle')
											<button type="button" class="advertpic f-ib btn btn-info btn-xs" data-id="{{$data['infor_id']}}"  data-toggle="modal"
											data-target="#myAdvert"
											>广告轮播图</button>
											@endcan
										@endif
									</td>
								</tr>
								@endforeach
								<tr>
								  <td colspan="4" align="center">
									  <?php echo $datacol->appends($datacol['args'])->render(); ?>
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
						<input type="hidden" id="infor_id" name="infor_id" value="">
						<div class="form-group">
							<label class="col-sm-2 control-label" for="title">标题</label>
							<div class="col-sm-9">
								<input type="text" name="title" id="title" class="form-control" required/>
							</div>
						</div><!--end form-group-->
						<input type="hidden" id="newsimg" name="newsimg" value="">
						<div class="form-group">
							<label class="col-sm-2 control-label" for="content">内容</label>
							<div class="col-sm-9">
								@include('UEditor::head')
										<!-- 加载编辑器的容器 -->
								<script id="content" name="content" type="text/plain"></script>
								<!-- 实例化编辑器 -->
								<script>
									UE.getEditor('content');
								</script>
							</div>
						</div><!--end form-group-->
						<div class="form-group text-center">
							<label class="col-sm-3 control-label"></label>
							<div class="col-sm-3">
								<button type="button" class="btn btn-info" id="save">保存</button>
							</div>
						</div><!--end form-group text-center-->
					</form>
					<div class="form-group">
						<form role="form" class="form-horizontal" action="" id="formToUpdateimg" method="post" enctype="multipart/form-data">
						<div id="method"></div>
							<div class="gallery text-center">
								<img src="" style="height:100px;width:100px;" id="updateimg">
								<input type="file" name="file" id="newspic">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- 资讯广告推送 -->
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
	<input type="hidden" id="activeFlag" value="treeadvert">
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
<script src="/admin/js/news.js"></script>
</body>
</html>
