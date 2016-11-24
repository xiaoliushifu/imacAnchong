<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>干货管理</title>
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
			<h1>干货管理</h1>
		</section>

		<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-body">
						    <form action="/upfile" class="form-horizontal form-inline f-ib">
						        <input type="text" name="f"  placeholder="文件名" class="form-control input-sm" >&nbsp;
						        <input type="text" name="u"  placeholder="上传者ID" class="form-control input-sm" >&nbsp;
						        <button type="submit" class="btn btn-primary btn-sm" id="filter">筛选</button>
						    </form>
							<table id="example1" class="table table-bordered table-striped">
								<tr>
									<th>ID</th>
									<th>文件名</th>
									<th>上传时间</th>
									<th>上传者ID</th>
									<th>操作</th>
								</tr>
								@foreach ($mydata as $data)
								<tr>
								  <td align="center">{{$data->auid}}</td>
								  <td align="center">{{substr($data->filename,strrpos($data->filename,'/')+1)}}</td>
								  <td align="center">{{$data->created_time}}</td>
								  <td align="center">{{$data->filenoid}}</td>
								  <td align="center">
								      <button type="button" class="btn btn-default btn-xs" data-auid="{{$data->auid}}">删除</button>
								  </td>
								</tr>  
								@endforeach
								<tr>
								  <td colspan="5" align="center">
									<?php echo $mydata->appends($args)->render(); ?>
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
	{{--修改模态框--}}
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
        		{{--整个modal内容区--}}
            <div class="modal-content">
            		{{--header--}}
                <div class="modal-header" style="margin-top:50px">
                    <h4 class="modal-title" id="myModalLabel">编辑权限</h4>
                    <small>名称前打对勾的，代表该角色已有的权限</small>
                </div>
                <form class="form-horizontal" id="myform" action="" method="post">
                		<input type="hidden" id='hidrid' name="rid" value="">
                    {{--body,临时调整使之分三栏显示--}}
                    <div class="modal-body container" style="width:80%">
                         <div id="myper"  class="row" ></div>
                    </div>
                    {{--footer--}}
                     <div class="modal-footer">
                         <button type="button" class="btn btn-default"  data-dismiss="modal">关闭</button>
                         <button type="submit" id="ajaxsub" class="btn btn-primary text-center">保存</button>
                     </div>
                </form>
            </div><!--modal-content -->
        </div>
    </div>
</div>
	<input type="hidden" id="activeFlag" value="treeperm">
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
	$('table').on('click','button',function(){
		if(confirm('确认删除这个文件吗？')){
			var that = $(this);
        		$.post('/upfile/del',{fid:that.attr('data-auid')},function(data){
        			if(data){
					that.parents('tr').remove();
                	}
                	console.log(data);
        		});
		}
	});
})
</script>
</body>
</html>
