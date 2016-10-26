<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>会员认证</title>
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
			<h1>认证列表</h1>
		</section>

		<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-body">
						    <form action="/user/list" method="get" class="form-horizontal form-inline f-ib">
						        <input type="number" name="id"  placeholder="用户ID" class="form-control input-sm" >&nbsp;
								<select name="auth_status">
                                		<option value="0">--认证状态--</option>
                                		<option value="1">待认证</option>
                                		<option value="2">未通过</option>
                                		<option value="3">已认证</option>
                            		</select>
						        <button type="submit" class="btn btn-primary btn-sm" id="filter">筛选</button>
						    </form>
							<table id="example1" class="table table-bordered table-striped">
								<tr>
									<th>用户ID</th>
									<th>认证名称</th>
									<th>申请时间</th>
									<th>认证状态</th>
									<th>查看资质</th>
									<th>操作</th>
								</tr>
								@foreach ($datacol['datas'] as $data)
								<tr>
								  <td align="center">{{$data['users_id']}}</td>
								  <td align="center">{{$data['auth_name']}}</td>
								  <td align="center">{{$data['created_at']}}</td>
								  <td align="center" id="as">
								  <?php
								  switch($data['auth_status']){
									  case 1:
        									  echo "待认证";
        									  break;
									  case 2:
        									  echo "未通过";
        									  break;
									  case 3:
        									  echo "已认证";
								  }
								  ?>
								  </td>
								  <td align="center">
								      <button type="button" class="view btn btn-default btn-xs" data-auth="{{$data['auth_name']}}" data-exp="{{$data['explanation']}}" data-qua="{{$data['qua_name']}}" data-id="{{$data['id']}}" data-toggle="modal" data-target="#myModal">查看</button>
								  </td>
								  <td align="center"  id="act">
								  {{-- 应用权限判定--}}
								  @if($data['auth_status']==1)
								  	  @can('authentication')
									  <button type='button' data-id="{{$data['id']}}" class='btn-success btn-xs' data-p='p'>通过</button>&nbsp;&nbsp;<button type='button' data-id="{{$data['id']}}"   class='btn-danger btn-xs'  data-p=''>不通过</button>
									  @else
									  {{--  权限不许时，灰色按钮--}}
									  <button type='button'  class='disabled btn-xs'>通过</button>&nbsp;&nbsp;<button type='button'  class='disabled btn-xs'>不通过</button>
									  @endcan
								  @endif
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

	{{--查看认证资料 弹窗--}}
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h4 class="modal-title" id="myModalLabel">弹框标题</h4>
		  </div>
		  <div class="modal-body">
			  <table class="table">
				  <tr>
					  <td align="right" width="25%">认证方式</td>
					  <td align="left" id="vqua"></td>
				  </tr>
				  <tr>
					  <td align="right" width="25%">认证描述</td>
					  <td align="left" id="vexpla"></td>
				  </tr>
		  	</table>
			<table class="table">
				<tr><th>认证照片</th></tr>
			    <tbody id="qua"></tbody>
				<tr><td colspan="3"><ul class="pagination" id="rendor"></ul>	</td></tr>
			</table>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
		  </div>
		</div>
	  </div>
	</div>
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
    $("table #act").on("click",'button',function(){
		if(confirm('确定'+$(this).text()+'吗？')){
			var id=parseInt($(this).attr("data-id"));
			var param=$(this).attr("data-p");
			var thisp = $(this).parents('tr');
			$.get("/user/check",{"id":id,"confi":param},function(data,status){
				thisp.find('#act').empty();
				if(param){
					thisp.find('#as').text('已认证');
				} else {
					thisp.find('#as').text('未通过');
				}
			});
		}
	});
	@endcan
	/**
	*查看认证资料
	*/
	$(".view").click(function(){
	    var id=parseInt($(this).attr("data-id"));
		$("#myModalLabel").text($(this).attr("data-auth"));//认证标题
		$("#vqua").text($(this).attr("data-qua"));
		$("#vexpla").text($(this).attr("data-exp"));
		$.get("/user/certfile/"+id,function(data,status){
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
