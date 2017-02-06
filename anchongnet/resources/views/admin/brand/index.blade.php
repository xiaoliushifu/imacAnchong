<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>品牌列表</title>
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
        .level{position:relative; top:8px;}
        .dl dt{cursor: pointer;}
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
            <h1>品牌列表</h1>
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
                            <form action="/goodbrand" method="get" class="form-horizontal form-inline f-ib">
                                <input type="text" name="kn"  class="form-control" placeholder="品牌关键字">
                                <button type="submit" class="btn btn-primary btn-sm">筛选</button>
                            </form>
                            <table id="example1" class="table table-bordered table-striped">
                                <tr>
                                    <th>品牌编号</th>
                                    <th>品牌名称</th>
                                    <th>品牌logo</th>
                                    <th>操作</th>
                                </tr>
                                @foreach ($datacol['datas'] as $data)
                                    <tr>
                                        <td align="center">{{$data['brand_id']}}</td>
                                        <td align="center">{{$data['brand_name']}}</td>
                                        <td align="center"><img src="{{$data['brand_logo']}}" width="80"></td>
                                        <td align="center">
                                        		@can('cate-action')
                                            <button type="button" class='act btn-primary btn-xs' data-id="{{$data['brand_id']}}" data-toggle="modal" data-target="#myModal">编辑</button>
                                            <button type="button" class="del btn btn-danger btn-xs" data-id="{{$data['brand_id']}}">禁用</button>
                                        		@endcan
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="6" align="center">
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
    <input type="hidden" id="activeFlag" value="treecate">
    <!-- /.content-wrapper -->
    @include('inc.admin.footer')
     {{--品牌编辑--}}
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">品牌编辑</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="myform" action="" method="post">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="brand_id" value="">
                        <div class="form-group">
                            <label for="brand_name" class="col-sm-2 control-label">品牌名称</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="bn" name="brand_name">
                            </div>
                        </div>
                        <!--  <div class="form-group">
                            <label for="brand_logo" class="col-sm-2 control-label">品牌logo</label>
                            <div class="col-sm-9">
                                <img  class="form-control" name="brand_logo">
                            </div>
                        </div>-->
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-9">
                            		<button type="button" data-dismiss="modal">取消</button>
                                <button type="submit" class="btn btn-primary">保存</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ./wrapper -->
<!-- Bootstrap 3.3.5 -->
<script src="/admin/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="/admin/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/admin/dist/js/app.min.js"></script>
<script src="/admin/js/brand.js"></script>
</body>
</html>
