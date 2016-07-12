<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>权限管理</title>
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
			<h1>创建权限</h1>
		</section>

		<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-body">
						    <form  role="form" class="form-horizontal  f-ib" id="myform">
						          <div class="form-group">
                                    <label class="col-sm-4 control-label" for="clabel" title="权限中文名">权限标识</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="label" id="clabel" placeholder="上传图片" class="form-control" value=""  required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="cname" title="权限英文名">权限名</label>
                                    <div class="col-sm-8">
                                        <input type="text" placeholder="post-pic" name="name" id="cname"  value="" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="cdescription" class="col-sm-4 control-label">权限描述</label>
                                    <div class="col-sm-8">
                                    <textarea class="form-control " name="description" id="cdescription" rows="5" required></textarea>
                                    </div>
                                </div>
						        <button  type="submit" class="btn btn-primary btn-info">添加</button>
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
	<input type="hidden" id="activeFlag" value="treeperm">
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
	*验证规则的触发，是发生submit事件，绑定的函数要写在submitHandler中
	*验证规则有两种方式书写，第一种是写在表单项的class属性里，第二种是像代码中的，写到rules里，使用name属性对应
	*
	*/
	 $("#myform").validate({
    	 rules:{
    		   name:{                        //name="name"的表单项的验证规则
    			   nochinese:true,                //规则名称
    			   required:true,
    		   },
    		   label:{                        //name="name"的表单项的验证规则
    			   required:true,
    		   },
    		   description:{                        //name="name"的表单项的验证规则
    			   required:true,
    		   },
    	 },
		 //绑定ajax处理，form参数是DOM对象
		 submitHandler: function(form) {
		     $.ajax({
		    	  type: "POST",
		    	  url: "/permission/ip",
		    	  data:{
		    		  name:$('#cname').val(),
		    		  label:$('#clabel').val(),
		    		  description:$('#cdescription').val(),
		    		  },
		    	  success:function(data,status){
		    			if(data=='OK'){
		    				$('#cname').val(''),
		    				  $('#clabel').val(''),
		    				  $('#cdescription').val(''),
		    				alert('已经添加成功，可以把这个权限交给角色了');
		    				//location.href='/permission/cp';
		    			}
		    		},
		    	  error:function(xhr,error,exception){
		    		  alert(error);  
		    	  }
		    	})
		    	return false;    
	     },
	 });
})
</script>
</body>
</html>
