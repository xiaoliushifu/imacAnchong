<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>用户浏览</title>
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
			<h1>用户浏览</h1>
		</section>

		<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-body">
						    <form action="/user" method="get" class="form-horizontal form-inline f-ib">
						      	<input type="number" name="phone"  placeholder="手机号码"  style="width:120px">&nbsp;
						    		<input type="number" name="uid"  placeholder="用户ID" style="width:100px">&nbsp;
					        	  	<select name="users_rank">
                                		<option value="0">--筛选等级--</option>
                                		<option value="1">普通会员</option>
                                		<option value="2">认证会员</option>
                            		</select>
						        <button type="submit" class="btn btn-primary btn-sm" id="filter">筛选</button>
						    </form>
							<table id="example1" class="table table-bordered table-striped">
								<tr>
									<th>用户ID</th>
									<th>电话</th>
									<th>邮箱</th>
									<th>注册时间</th>
									<th>用户等级</th>
									<th>操作</th>
								</tr>
								@foreach ($datacol['datas'] as $data)
								<tr>
								  <td align="center">{{$data['users_id']}}</td>
								  <td align="center">{{$data['phone']}}</td>
								  <td align="center">{{$data['email']}}</td>
								  <td align="center">{{date('Y-m-d H:i:s',$data['ctime'])}}</td>
								  <td align="center">
								  <?php
								  switch ($data['users_rank']){
									  case 1:
        									  echo "普通会员";
        									  break;
									  case 2:
        									  echo "认证会员";
        									  break;
									  case 3:
        									  echo "管理员";
        									  break;
								  }?>
								  </td>
								  <td align="center"><button type="button" class="fpasswd f-ib btn btn-primary btn-xs" data-id="{{$data['users_id']}}"  data-toggle="modal"
								  data-target="#myModal"
								  >修改密码</button></td>
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
					<h4 class="modal-title" id="myModalLabel"></h4>
				</div>
				<div class="modal-body">
					<!-- Content Header (Page header) -->
					<section class="content-header">
						<h1>修改密码</h1>
					</section>
					<!-- Main content -->
					<section class="content">
						<div class="row">
							<div class="col-xs-18">
								<div class="box">
									<div class="box-body">
									    <form  method="post" class="form-horizontal  f-ib" id="myform">
			                                <div class="form-group">
			                                    <label class="col-sm-4 control-label" for="clabel" title="密码">密码</label>
												<input type="hidden" name="users_id" id="users_id" value=""/>
			                                    <div class="col-sm-8">
			                                        <input type="text" name="password" id="password" placeholder="不超过20位" class="form-control" value="" required   />
			                                    </div>
			                                </div>
			                                <div class="form-group" style="text-align: center;">
									            <button  type="submit" style="align:center;" class="btn btn-primary btn-info">修改密码</button>
			                                </div>
									    </form>
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
				</div>
			</div>
		</div>
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
<?php
if(isset($datacol['args']['users_rank'])){
	switch ($datacol['args']['users_rank']){
		case 1:
		echo '<script>$(function(){$("#level0").attr("checked",true)});</script>';
		break;
		case 2:
		echo '<script>$(function(){$("#level1").attr("checked",true)});</script>';
		break;
		default:
		echo '<script>$(function(){$("#level0").attr("checked",false);$("#level1").attr("checked",false)});</script>';
	}
}
?>
<script src="/admin/plugins/form/jquery.validate.min.js"></script>
<script type="text/javascript">
/**
 * jquery 加载事件
 */
$(function(){
	//当点击修改密码时执行
	$(".fpasswd").click(function(){
        $('#users_id').val($(this).attr("data-id"));
	});
	/**
	*jquery插件jquery.validate.min.js
	*用于验证表单
	*/
	 $("#myform").validate({
		   //绑定规则
		   rules:{

		   },
		   //绑定ajax提交
		   submitHandler: function(form) {
			   $.ajax({
					  type: "POST",
					  url: "/user/fpasswd",
					  data:{                                     //提交参数
						  password:$('#password').val(),
						  users_id:$('#users_id').val()
					  },
					  success:function(data,status){
							if(data=='密码修改成功'){
								alert(data);
								location.reload();
							}else{
								alert(data);
							}
					  },
					  error:function(xhr,error,exception){
						  alert(error);
					  }
				})
		   }
	 });
})
</script>
</body>
</html>
