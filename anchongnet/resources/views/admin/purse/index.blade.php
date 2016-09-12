<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>提现列表</title>
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
			<h1>用户提现查看</h1>
		</section>

		<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-body">
						    <form action="/purse" method="get" class="form-horizontal form-inline f-ib">
								提现订单类型：
								<select class="form-control" name="type">
									<option value="" id="check">请选择</option>
									<option value="1">未提现订单</option>
									<option value="2">已提现订单</option>
								</select>
						      <button type="submit" class="btn btn-primary btn-sm" id="filter">筛选</button>
						    </form>
		                    <a href="/purse" class="btn btn-default btn-sm unplay f-ib" role="button">取消筛选</a>
							<table id="example1" class="table table-bordered table-striped">
								<tr>
									<th>提现ID</th>
									<th>提现单号</th>
									<th>提现金额</th>
                                    <th>提现时间</th>
                                    <th>提现方式</th>
                                    <th>收款人姓名</th>
                                    <th>收款人账号</th>
                                    <th>操作</th>
								</tr>
								@foreach ($datacol['datas'] as $data)
								<tr>
                                    <td align="center">{{$data['purse_oid']}}</td>
                                    <td align="center">{{$data['order_num']}}</td>
                                    <td align="center">{{$data['price']}}</td>
                                    <td align="center">{{$data['created_at']}}</td>
                                    <td align="center">{{$data['remark']}}</td>
								    <?php
								    $user_arr=explode(":",trim($data['pay_num']));
                                    if(count($user_arr)>1){
                                        echo '<td align="center">'.$user_arr[0].'</td><td align="center">'.$user_arr[1].'</td>';
                                    }else{
                                        echo '<td align="center">无</td><td align="center">无</td>';
                                    }
                                    ?>
                                    <?php
                                        if($state){
                                            echo '<td align="center">
                                                <button type="button" class="withdraw f-ib btn btn-info btn-xs" data-id="'.$data['purse_oid'].'" >提现成功</button>
                                            </td>';
                                        }else{
                                            echo '<td align="center">
                                                <button type="button" class="withdrawinfo f-ib btn btn-success btn-xs" data-id="'.$data['purse_oid'].'" data-order="'.$data['order_num'].'" data-price="'.$data['price'].'"          data-time="'.$data['created_at'].'"        data-pay="'.$data['pay_num'].'"     data-remark="'.$data['remark'].'" data-users="'.$data['users_id'].'"  data-toggle="modal" data-target="#myView">查看详情</button>
                                            </td>';
                                        }
                                    ?>
								</tr>
								@endforeach
								<tr>
								  <td colspan="8" align="center">
									<?php echo $datacol['datas']->appends($datacol['args'])->appends($state)->render(); ?>
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

    <!-- 发货清单 -->
    <div class="modal fade" id="myView" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="glyphicon glyphicon-paperclip"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tr>
                            <td align="right">备注</td>
                            <td align="left" id="vremark"></td>
                        </tr>
                        <tr>
                            <td align="right" width="25%">提现人</td>
                            <td align="left" id="vusers_id"></td>
                        </tr>
                        <tr>
                            <td align="right">提现单号</td>
                            <td align="left" id="vorder_num"></td>
                        </tr>
                        <tr>
                            <td align="right">提现金额</td>
                            <td align="left" id="vprice"></td>
                        </tr>
                        <tr>
                            <td align="right">提现时间</td>
                            <td align="left" id="vtime"></td>
                        </tr>
                        <tr>
                            <td align="right">收款人姓名</td>
                            <td align="left" id="vname"></td>
                        </tr>
                        <tr>
                            <td align="right">收款人账号</td>
                            <td align="left" id="vaccount"></td>
                        </tr>
                        <tr>
                            <td align="right">提现人可用余额</td>
                            <td align="left" id="vusable_money"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
	<input type="hidden" id="activeFlag" value="treewithdraw">
	@include('inc.admin.footer')
</div>
<!-- ./wrapper -->
<!-- Bootstrap 3.3.5 -->
<script src="/admin/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="/admin/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/admin/dist/js/app.min.js"></script>
<!-- 标签管理的js -->
<script src="/admin/js/purse.js"></script>

</body>
</html>
