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
							@if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
						    <form action="/coupon" method="get" class="form-horizontal form-inline f-ib">
						        <input type="number" name="acpid"  placeholder="券ID"  value="{{$datacol['args']['acpid']}}">&nbsp;
						        <select name="status"  title="优惠券状态">
						        		<option value="1" checked>启用</option>
						        		<option value="0">停用</option>
						        </select>
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
								  <?php 
								    switch($data['type']){
								        case 1:
								            echo '<td align="center"  value="1">通用</td>';
								            break;
								        case 2:
								            echo '<td align="center"  value="2">商铺</td>';
								            break;
								        case 3:
								            echo '<td align="center"  value="3">商品</td>';
								            break;
								        default :
							                echo '<td align="center"  value="1">通用</td>';
								    }
								  ?>
								  <td align="center">{{$data['type2']}}</td>
								  <td align="center">{{$data['beans']}}</td>
								  <td align="center">{{($data['open'])? '启用':'停用'}}</td>
								  <td align="center">
								  {{-- 应用权限判定--}}
								  	  @can('coupon')
									  <button type='button' data-id="{{$data['acpid']}}" class='check-success {{ ($data["open"])? "disabled":""}} btn btn-success btn-xs act'>启用</button>&nbsp;&nbsp;<button type='button' data-id="{{$data['acpid']}}"   class='check-failed {{ ($data["open"])? "":"disabled"}} btn btn-danger btn-xs act'>停用</button>&nbsp;&nbsp;<button type="button" class="edit f-ib btn btn-primary btn-xs" data-id="1347" data-toggle="modal" data-target="#myModal">编辑</button>
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
<!-- Modal ---for edit -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
        		{{--大块内容--}}
            <div class="modal-content">
            		{{--header--}}
                <div class="modal-header" style="margin-top:50px">
                    <h4 class="modal-title" id="myModalLabel">优惠券编辑</h4>
                    <small>当前优惠券：</small>
                </div>
                <form class="form-horizontal" id="myform" action="" method="POST">
                		<input type="hidden" id='hid' name="acpid" value="">
                		<input type="hidden" name="_method" value="PUT">
                    <div class="form-name form-group">
                            <label for="title" class="col-sm-2 control-label">优惠券标题</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="title" id="title" required>
                            </div>
                    </div>
                    <div class="form-name form-group">
                            <label for="cvalue" class="col-sm-2 control-label">优惠券面值</label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" name="cvalue" id="cvalue" required>
                            </div>
                    </div>
                    <div class="form-name form-group">
                            <label for="beans" class="col-sm-2 control-label">可抵虫豆数</label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" name="beans" id="beans" placeholder="0代表不可兑换">
                            </div>
                    </div>
                    <!-- <div class="form-name form-group">
                            <label for="beans" class="col-sm-2 control-label">优惠券类型</label>
                            <div class="col-sm-9">
                            		<div class="col-xs-4">
                                    <select class="form-control" name="type"  id="type" placeholder="选项">
                                    		<option value="1" tit="通用">通用</option>
                                    		<option value="2"  tit="请填写商铺ID">商铺</option>
                                    		<option value="3"  tit="请填写商品ID">商品</option>
                                    		<option value="4" tit = "其他">其他</option>
                                    </select>
                                </div>
                                <div class="col-xs-4">
                                		<input type="text" class="form-control" name="type2"  id="type2"  placeholder="请填写内容" />
                                </div>
                            </div>
                    </div> -->
                    {{--footer--}}
                     <div class="modal-footer">
                         <button type="button" class="btn btn-default"  data-dismiss="modal">关闭</button>
                         <button type="submit" class="btn btn-primary text-center">保存</button>
                     </div>
                </form>
            </div>
        </div>
    </div>
	<input type="hidden" id="activeFlag" value="treecoupon">
	@include('inc.admin.footer')
</div>
<!-- ./wrapper -->
<!-- Bootstrap 3.3.5 -->
<script src="/admin/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="/admin/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/admin/dist/js/app.min.js"></script>
<script src="/admin/js/couponlist.js"></script>
</body>
</html>
