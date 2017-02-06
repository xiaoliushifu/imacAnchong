<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>角色设置</title>
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
			<h1>角色设置<small>已开通商铺的用户除外</small></h1>
		</section>

		<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-body">
						<form action="/permission/role" method="get" class="form-horizontal form-inline f-ib">
						     <input type="tel" name="phone"  placeholder="电话" class="form-control input-sm" value="{{$datacol['args']['phone']}}">&nbsp;
						     <select name="ur" >
						     	<option value="0">身份筛选</option>
						     	<option value="3">管理员</option>
						     	<option value="2">认证会员</option>
						     	<option value="1">普通会员</option>
						     </select>
						     <button type="submit" class="btn btn-primary btn-sm" id="filter">筛选</button>
						 </form>
							<table id="example1" class="table table-bordered table-striped">
								<tr>
									<th>ID</th>
									<th>电话</th>
									<th>身份</th>
									<th>操作</th>
								</tr>
								@foreach ($datacol['datas'] as $data)
								<tr>
								  <td align="center">{{$data['users_id']}}</td>
								  <td align="center">{{$data['phone']}}</td>
								  <td align="center" ur="{{$data['users_rank']}}"><?php
								    switch ($data['users_rank']) {
								        case 1:
								            echo '普通用户';
								            break;
								        case 2:
								            echo '认证用户';
								            break;
								        case 3:
								            echo '管理员';
								    }
								  ?></td>
								  <td align="center">
								      <button type="button" class="view btn btn-default btn-xs" uid="{{$data['users_id']}}" data-toggle="modal" data-target="#myModal">角色设置</button>
								  </td>
								  </td>
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
	<!-- /.content-wrapper -->
	{{--弹框--}}
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            		{{--header--}}
                <div class="modal-header" style="margin-top:50px">
                    <h4 class="modal-title" id="myModalLabel">设置角色</h4>
                    <small>名称前打对勾的，代表该用户已分配的角色</small>
                </div>
                <form class="form-horizontal" id="myform" action="" method="post">
                        <input type="hidden" id='hiduid' name="uid" value="">
                         {{--body--}}
                        <div class="modal-body">
                                <div id="myrole"></div>
                        </div>
                			{{--footer--}}
                     <div class="modal-footer">
                     	<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                     	<button type="submit" id="ajaxsub" class="btn btn-primary">保存</button>
                     </div>
               </form>
            </div><!-- modal-content -->
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
	*'设置角色' 按钮
	*
	*/
	$(".view").click(function(){
		$("#myrole").empty();                  //清空
	    var uid=parseInt($(this).attr("uid"));
	    $('#hiduid').val(uid);                 //用户id
		$.ajax({
			  type: "GET",
			  url: "/permission/allrole/"+uid,
			  success:function(data,status){
					var con='';
					//该用户担任的角色
					for(var i=0;i<data[0].length;i++){
						con+='<label ><input type="checkbox" name="roles[]" value="'+data[0][i].id+'" checked="checked" /> '+data[0][i].label+'</label><br />';
					}
					//其他权限
					for(var i=0;i<data[1].length;i++){
						if(data[0])
						con+='<label ><input type="checkbox" name="roles[]" value="'+data[1][i].id+'" /> '+data[1][i].label+'</label> <br />';
					}
					$("#myrole").append(con);
				}
		});
	});

	/**
	* 使用ajax提交，关键两点：
	*@为submit按钮绑定 click事件，
	*@最后return false 阻止浏览器默认行为。
	*/
	 $("#ajaxsub").click(function(){
		 //用户id
		 var uid=$('#hiduid').val();
		 //接收checkbox的值为字符串
		 var a=[];
		 $('input[type="checkbox"]:checked').each(function(k,v){a.push(v.value)});
		 //为哪个form绑定
        $.ajax({
            type: 'post',
            url: '/permission/addrole',
            data:{
                'uid':uid,
                'roles':a.join()                        //当为某用户清除角色身份时，将是空字符串
                },
            success: function (data) {
                console.log(data);
                alert(data);
            },
            error: function(xhr,error){
                alert(error);
            }
        });
        return false;
    });
})
</script>
</body>
</html>
