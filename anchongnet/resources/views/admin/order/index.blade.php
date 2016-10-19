<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>订单列表</title>
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
		.f-ib{display: inline-block;}
		.tables th{
			border: 1px solid #333;
		}
		.tables td{
			border: 1px solid #333;
			font-size: 12px;
		}
		.table1 {
			border: 0px solid #333;
		}
		li{
			list-style:none;
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
	<div class="content-wrapper" id="pageindex">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				订单列表
			</h1>
		</section>

		<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-body">
							<form action="/order" method="get" class="form-horizontal form-inline f-ib">
								<input type="text" name="kn" class="form-control" placeholder="订单编号">
								<select name="state">
                                    		<option value="0" >--筛选状态--</option>
                                    		<option value="1">待收款</option>
                                    		<option value="2">待发货</option>
                                    		<option value="3">已发货</option>
                                    		<option value="4">待审核</option>
                                    		<option value="5">已退款</option>
                                    		<option value="6">交易关闭</option>
                                    		<option value="7">交易成功</option>
                                </select>
								<button type="submit" class="btn btn-primary btn-sm" id="filter">筛选</button>
							</form>
							<table id="example1" class="table table-bordered table-striped">
								<tr>
									<th>商铺名称</th>
									<th>订单编号</th>
									<th>订单状态</th>
									<th>订单生成时间</th>
									<th>收货人</th>
									<th>收货人电话</th>
									<th>收货地址</th>
									<th>操作</th>
								</tr>
								@foreach ($datacol['datas'] as $data)
									<tr>
										<td align="center">{{$data['sname']}}</td>
										<td align="center">{{$data['order_num']}}</td>
										<td align="center">
											<?php
												switch($data['state']){
													case 1:
														echo "待收款";
														break;
													case 2:
														echo "待发货";
														break;
													case 3:
														echo "已发货";
														break;
													case 4:
														echo "退货待审核";
														break;
													case 5:
														echo "已退款";
														break;
													case 6:
														echo "交易关闭";
														break;
													case 7:
														echo "交易成功";
														break;
												}
											?>
										</td>
										<td align="center">{{$data['created_at']}}</td>
										<td align="center">{{$data['name']}}</td>
										<td align="center">{{$data['phone']}}</td>
										<td align="center">{{$data['address']}}</td>
										<td align="center">
											<button type="button" class="view f-ib btn btn-default btn-xs" data-id="{{$data['order_id']}}"
											data-num="{{$data['order_num']}}" data-name="{{$data['name']}}" data-phone="{{$data['phone']}}" data-address="{{$data['address']}}" data-price="{{$data['total_price']}}" data-freight="{{$data['freight']}}"
											data-time="{{$data['created_at']}}" data-sname="{{$data['sname']}}" data-tname="{{$data['tname']}}" data-invoice="{{$data['invoice']}}" data-acpid="{{$data['acpid']}}" data-toggle="modal" data-target="#myView">打印</button>
												@can('order-ship')
													<button type='button' class='shipbtn f-ib btn btn-primary btn-xs {{ ($data["state"])!=2? "hidden":""}}'  data-id="{{$data['order_id']}}" data-num="{{$data['order_num']}}" data-toggle="modal" data-target="#mySend">发货</button>
													<button type='button' class='status btn btn-primary btn-xs {{ ($data["state"])!=3? "hidden":""}}' ' data-id="{{$data['order_id']}}" data-num="{{$data['order_num']}}" data-toggle="modal" data-target="#myStatus">物流状态</button>
													<button type='button' class='check f-ib btn btn-primary btn-xs {{ ($data["state"])!=4? "hidden":""}}' data-id="{{$data['order_id']}}" data-num="{{$data['order_num']}}" data-toggle="modal" data-target="#myCheck">审核</button>
												@else
													<button type='button' class='disabled btn btn-primary btn-xs' >发货</button>
													<button type='button' class='disabled btn btn-primary btn-xs '>物流状态</button>
													<button type='button' class='disabled btn btn-primary btn-xs'>审核</button>
												@endcan
										</td>
									</tr>
								@endforeach
								<tr>
									<td colspan="8" align="center">
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

	{{--打印订单，弹框--}}
	<div class="modal fade" id="myView" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true" class="glyphicon glyphicon-paperclip" id="viewclose"></span>
					</button>
					<h4 style="margin-top:50px" align="center">北京安虫电子商务有限公司</h4>
					<h3 align="center" style="margin-top:0px" id="myModalLabel">发货清单</h3>
				</div>
				<div class="modal-body">
					<table class="table1" style="width:100%;margin-bottom:7px">
						<tr>
                            <td align="left" id="ordersname">商铺名称:</td>
							<td style="padding-left:10px" align="right" id="ordertime">订单日期:</td>
                        </tr>
                        <tr>
                            <td align="left" id="ordertname">客户名称:</td>
                            <td style="padding-left:10px" align="right" id="ordernum">订单编号:</td>
                        </tr>
					</table>
					<table class="tables" id="mbody">
						<tr>
							<td colspan="2" id="orderinvoiceinfo">发票信息:</td>
							<td colspan="5" id="orderinvoice">发票抬头:</td>
						</tr>
					</table>
					<table class="table1" style="margin-top:7px">
						<tr>
                            <td align="left" id="ordername"></td>
                            <td align="right" width="150px" id="orderphone"></td>
                        </tr>
						<tr>
                            <td align="left" id="orderaddress"></td>
                        </tr>
					</table>
					<div style="margin-top:30px">
						<div class="" style="float:right">
							<li><img style="width:100px;height:100px;" src="/admin/image/code/安虫微信公众号.jpg" alt="安虫微信公众号" /></li>
							<li align="center"><b>安虫微信公众号</b></li>
						</div>
						<div class="" style="float:right">
							<li><img style="margin-right:50px;width:100px;height:100px;" src="/admin/image/code/安虫APP二维码.jpg" alt="安虫APP二维码" /></li>
							<li style="margin-right:50px;" align="center"><b>安虫APP二维码</b></li>
						</div>
						<div  style="clear:both">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	{{--审核通过与否，弹窗口--}}
	<div class="modal fade" id="myCheck" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header"></div>
				<div class="modal-body" id="cbody"></div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal">取消</button>
					<button type="button" class="btn btn-success" id="pass">通过</button>
					<button type="button" class="btn btn-danger" id="fail">不通过</button>
				</div>
			</div>
		</div>
	</div>
	{{--发货方式选择，弹窗口--}}
	<div class="modal fade" id="mySend" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header" style="margin-top:50px">	</div>
				<div class="modal-body">
					<form action="/order/ordership" method="post" class="form-group form-inline" id="goform">
						<input type="hidden" name="orderid"  id="orderid">
						<input type="hidden" name="onum" id="onum">
						<p>
							<label>发货方式：</label>
							<label class="radio-inline">
								<input type="radio" name="ship"  value="hand" checked> 手动发货
							</label>
							<label class="radio-inline">
								<input type="radio" name="ship" value="wl"> 物流发货
							</label>
						</p>
						<div class="hidden" id="wlist">
							<p>
								<label>选择物流：</label>
								<select class="form-control" name="logistics" id="logs"></select>
							</p>
							<p>
								<label for="lognum">物流单号：</label>
								<input type="number" name="lognum" class="form-control" required>
								<small></small>
							</p>
						</div>
				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal">取消</button>
					<button type="button" class="btn btn-sm btn-primary text-center" id="go">开始发货</button>
				</div>
				</form>
			</div>
		</div>
	</div>
	
	{{--物流状态，弹窗口--}}
	<div class="modal fade" id="myStatus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header" style="margin-top:50px">
					<h4 class="modal-title">编号为:<span id='ff'></span>的订单已发货</h4>
					<small class="text-danger">物流发货”方式可用</small>
				</div>
				<div class="modal-body">
					<div id="wlstatus">
						订单信息：<p></p>
						<hr>
						物流信息：<p></p>
					</div>
				</div>
                <div class="modal-footer">
					<button type="button" data-dismiss="modal">关闭</button>
					<button type="button" id="cancelO" data-num="" data-id="" title="在快递取件之前仍可取消发货">取消发货</button>
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" id="activeFlag" value="treeorder">
	<!-- /.content-wrapper -->
	@include('inc.admin.footer')
<!-- Bootstrap 3.3.5 -->
<script src="/admin/bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="/admin/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/admin/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/admin/dist/js/app.min.js"></script>
<script src="/admin/js/jquery.form.js"></script>
<script src="/admin/js/order.js"></script>
</body>
</html>
