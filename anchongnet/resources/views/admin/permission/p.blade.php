<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>权限分配</title>
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
			<h1>权限分配</h1>
		</section>

		<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-body">
						    <form action="/permission" method="get" class="form-horizontal form-inline f-ib">
						        <input type="text" name="nm"  placeholder="角色查找" class="form-control input-sm" value="{{$datacol['args']['nm']}}">&nbsp;
						        <button type="submit" class="btn btn-primary btn-sm" id="filter">筛选</button>
						    </form>
							<a href="/permission" class="btn btn-default btn-sm unplay f-ib" role="button">取消筛选</a>
							<table id="example1" class="table table-bordered table-striped">
								<tr>
									<th>ID</th>
									<th>角色名</th>
									<th>角色描述</th>
									<th>操作</th>
								</tr>
								@foreach ($datacol['datas'] as $data)
								<tr>
								  <td align="center">{{$data['id']}}</td>
								  <td align="center">{{$data['label']}}</td>
								  <td align="center">{{$data['description']}}</td>
								  <td align="center">
								      <button type="button" class="view btn btn-default btn-xs" rid="{{$data['id']}}" data-toggle="modal" data-target="#myModal">权限分配</button>
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
	  <!-- Modal -->
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
	/**
	*为 ‘权限设置’ 按钮绑定点击事件
	*问题：为什么点击后会是弹框呢？
	*/
	$(".view").click(function(){
		
		$("#myper").empty();                  //清空
	    var rid=parseInt($(this).attr("rid"));
	    $('#hidrid').val(rid);                 //角色id
		$.ajax({
			  type: "GET",
			  url: "/permission/perm/"+rid,
			  cache:true,
			  success:function(data,status){
					var con='';
					//该角色已有的权限
					for(var i=0;i<data[0].length;i++){
						con+='<label class="col-md-4 col-xs-3"><input type="checkbox"  name="perms[]" value="'+data[0][i].id+'" checked="checked" /> '+data[0][i].label+'</label>';
					}
					//该角色还没有的权限
					for(var i=0;i<data[1].length;i++){
						if(data[0])
						con+='<label class="col-md-4 col-xs-3"><input type="checkbox" name="perms[]" value="'+data[1][i].id+'" /> '+data[1][i].label+'</label>';
					}
					$("#myper").append(con);
				}
		})
	})


	/**
	* 使用ajax提交
	*/
	 $("#ajaxsub").click(function(){
		 //角色id
		 var rid=$('#hidrid').val();
		 //接收checkbox的值为字符串
		 var a=[];
		 $('input[type="checkbox"]:checked').each(function(k,v){a.push(v.value)});
		 //组织ajax
        $.ajax({
            type: 'post',
            url: '/permission/addperm',
            data:{
                'rid':rid,
                'perms':a.join()                    //如果a是空数组，将向服务器端传递空字符串
                },
            success: function (data) {
                alert(data);
            },
            error: function(xhr,error){
                alert(error);
            }
        });
        //阻止浏览器默认行为
        return false;
    });
})
</script>
</body>
</html>
