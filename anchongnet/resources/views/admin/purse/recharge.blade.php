<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>余额充值</title>
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
	/*************************
	 * 自定义validate插件的验证错误时的样式
	************************/
	#myform label.error
    {
        color:Red;
        font-size:13px;
        margin-left:5px;
        padding-left:16px;
    }
    .form-group{
        width: 800px;
    }
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
			<h1>余额充值</h1>
		</section>
		<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-xs-18">
					<div class="box">
						<div class="box-body">
						    <form  method="post" class="form-horizontal  f-ib" id="myform">
						        <div class="form-group">
                                    <label class="col-sm-4 control-label" for="clabel" title="账号">账号</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="username" id="username" placeholder="用户的电话号" class="form-control" value="" required   />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="clabel" title="密码">安全密码</label>
                                    <div class="col-sm-8">
                                        <input type="password" name="password" id="password" placeholder="安虫的安全密码" class="form-control" value="" required   />
                                    </div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-4 control-label" for="clabel" title="金额">金额</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="money" id="money" placeholder="充值金额" class="form-control" value="" required   />
                                    </div>
                                </div>
                                <div class="form-group" style="text-align: center;">
						            <button  type="submit" style="align:center;" class="btn btn-primary btn-info">充值</button>
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
	<!-- /.content-wrapper -->
</div>
	<input type="hidden" id="activeFlag" value="treepurse">
	@include('inc.admin.footer')
</div>
<!-- ./wrapper -->
<!-- Bootstrap 3.3.5 -->
<script src="/admin/bootstrap/js/bootstrap.min.js"></script>
<!-- jquery validator -->
<script src="/admin/plugins/form/jquery.validate.min.js"></script>
<script src="/admin/plugins/form/messages_zh.js"></script>
<!-- FastClick -->
<script src="/admin/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/admin/dist/js/app.min.js"></script>
<script>
/**
 * jquery 加载事件
 */
$(function(){
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
					  url: "/purse",
					  data:{                                     //提交参数
						  username:$('#username').val(),
						  password:$('#password').val(),
						  money:$('#money').val()
					  },
					  success:function(data,status){
							if(data=='充值成功'){
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
