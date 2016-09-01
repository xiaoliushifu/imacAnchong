<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>优惠券</title>
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
			<h1>优惠券列表</h1>
		</section>

		<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-body">
						    <form action="/coupon" method="get" class="form-horizontal form-inline f-ib">
						        <input type="number" name="id"  placeholder="用户ID" class="form-control input-sm" value="{{$datacol['args']['id']}}">&nbsp;
						        <button type="submit" class="btn btn-primary btn-sm" id="filter">筛选</button>
						    </form>
							<table id="example1" class="table table-bordered table-striped">
								<tr>
									<th>券ID</th>
									<th>券标题</th>
									<th>券面值</th>
									<th>券类型</th>
									<th>券类型2</th>
									<th>可换虫豆数</th>
									<th>状态</th>
									<th>操作</th>
								</tr>
								@foreach ($datacol['datas'] as $data)
								<tr>
								  <td align="center">{{$data['acpid']}}</td>
								  <td align="center">{{$data['title']}}</td>
								  <td align="center">{{$data['cvalue']}}</td>
								  <td align="center">{{$data['type']}}</td>
								  <td align="center">{{$data['type2']}}</td>
								  <td align="center">{{$data['beans']}}</td>
								  <td align="center">{{($data['open'])? '使用中':'已停用'}}</td>
								  <td align="center">
								  {{-- 应用权限判定--}}
								  	  @can('coupon')
									  <button type='button' data-id="{{$data['acpid']}}" class='check-success btn btn-success btn-xs'>启用</button>&nbsp;&nbsp;<button type='button' data-id="{{$data['acpid']}}"   class='check-failed btn btn-danger btn-xs'>停用</button>
									  @else
									  {{--  权限不许时，灰色按钮--}}
									  <button type='button'  class='btn disabled btn-success btn-xs'>启用</button>&nbsp;&nbsp;<button type='button'  class='btn disabled btn-danger btn-xs'>停用</button>
									  @endcan
								  </td>
								</tr>
								@endforeach
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
	<!-- /.content-wrapper -->

	<input type="hidden" id="activeFlag" value="treeuser">
	@include('inc.admin.footer')
</div>
<!-- ./wrapper -->
<!-- Bootstrap 3.3.5 -->
<script src="/admin/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="/admin/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/admin/dist/js/app.min.js"></script>
<script>
$(function(){
	{{--加上权限判定：是否可点击 “通过”按钮--}}
	@can('authentication')
    $("body").on("click",'.check-success',function(){
		if(confirm('确定要通过吗？')){
			var id=parseInt($(this).attr("data-id"));
			$.get("/check",{"id":id,"certified":"yes"},function(data,status){
				alert(data);
				setTimeout(function(){location.reload()},1000);
			});
		}
	})
	{{--加上权限判定：是否可点击 “不通过”按钮--}}
	$("body").on("click",'.check-failed',function(){
		if(confirm('确定审核不通过吗？')){
			var id=parseInt($(this).attr("data-id"));
			$.get("/check",{"id":id,"certified":"no"},function(data,status){
				alert(data);
				setTimeout(function(){location.reload()},1000);
			});
		}
	})
	@endcan
	$(".view").click(function(){
	    var id=parseInt($(this).attr("data-id"));
		var auth=$(this).attr("data-auth");
		$("#myModalLabel").text(auth);
		$("#view-qua").text($(this).attr("data-qua"));
		$("#view-explanation").text($(this).attr("data-exp"));
		$.get("/cert/"+id,function(data,status){
			$("#qua").empty();
			var con="";
			for(var i=0;i<data.length;i++){
				con+="<tr><td align='center'><a href="+data[i].credentials+" target='_blank'><img src="+data[i].credentials+" width='100'></a></td></tr>";
			}
			$("#qua").append(con);
		});
	})
})
</script>
</body>
</html>
