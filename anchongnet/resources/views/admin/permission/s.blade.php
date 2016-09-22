<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>缓存与搜索</title>
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
			<h1>搜索</h1>
		</section>
		<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-body">
						    <!--  <form action="http://api.anchong.net/goods/goodssearch" method="post" >
						        <input type="text" name="param"  value='{"search":"磁力锁"}' style="width:300px">&nbsp;
						        <input type="hidden" name="guid"  value='0' >&nbsp;
						        <button type="submit" class="btn btn-primary">线上搜索</button>
						    </form>-->
						    <form action="/search/key" method="post" >
						        <input type="text" name="q"  placeholder="磁力锁" style="width:300px">&nbsp;
						        <button type="submit" class="btn btn-primary">go</button>
						        <button type="button" class="btn btn-primary" onclick="my()">清除缓存</button>
						        <small class="text-danger">为性能考虑，请慎重使用“清除缓存”功能</small>
						    </form>
						    <span>{{$ori}}---{{$hex}}</span>
							<table id="example1" class="table table-bordered table-striped">
								<tr>
									<th>货品ID</th>
									<th>商品ID</th>
									<th>商品名称</th>
									<th>市场价</th>
									<th>会员价</th>
									<th>操作</th>
								</tr>
								@foreach($res?: array() as $v)
								<tr>
								  <td align="center">{{$v['gid']}}</td>
								  <td align="center">{{$v['goods_id']}}</td>
								  <td align="center">{{$v['title']}}</td>
								  <td align="center">{{$v['price']}}</td>
								  <td align="center">{{$v['vip_price']}}</td>
								  <td align="center">
								      <button type="button" class="view btn btn-default btn-xs"  >操作</button>
								  </td>
								</tr>
								@endforeach  
							</table>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>
	<input type="hidden" id="activeFlag" value="treeperm">
	@include('inc.admin.footer')
</div>
<!-- Bootstrap 3.3.5 -->
<script src="/admin/bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="/admin/dist/js/app.min.js"></script>
<script>
	function my(){
		$.post('/search/del',function(data){
			$('button[type="button"]').text('缓存清除了');
		});
	}
</script>
</body>
</html>
