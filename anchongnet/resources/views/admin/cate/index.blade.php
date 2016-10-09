<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>分类列表</title>
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
            <h1>分类列表</h1>
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
                            <form action="/goodcate" method="get" class="form-horizontal form-inline f-ib">
                                <input type="text" name="keyName" value="{{$datacol['args']['keyName']}}" class="form-control" placeholder="分类名称">
                                <button type="submit" class="btn btn-primary btn-sm" id="filter">筛选</button>
                            </form>
                            <a href="/goodcate" class="btn btn-default btn-sm unplay f-ib" role="button">取消筛选</a>
                            <table id="example1" class="table table-bordered table-striped">
                                <tr>
                                    <th>分类名称</th>
                                    <th>关键字</th>
                                    <th>分类描述</th>
                                    <th>分类级别</th>
                                    <th>是否显示</th>
                                    <th>操作</th>
                                </tr>
                                @foreach ($datacol['datas'] as $data)
                                    <tr>
                                        <td align="center">{{$data['cat_name']}}</td>
                                        <td align="center">{{$data['keyword']}}</td>
                                        <td align="center">{{$data['cat_desc']}}</td>
                                        <td align="center">
                                            <?php
                                                switch ($data['parent_id']){
                                                    case 0:
                                                        echo "一级分类";
                                                        break;
                                                    default:
                                                        echo "二级分类";
                                                        break;
                                                }
                                            ?>
                                        </td>
                                        <td align="center">
                                            <?php
                                                switch($data['is_show']){
                                                    case 0:
                                                        echo "否";
                                                        break;
                                                    case 1:
                                                        echo "是";
                                                        break;
                                                }
                                            ?>
                                        </td>
                                        <td align="center">
                                            <button type="button" class="view f-ib btn btn-primary btn-xs" data-id="{{$data['cat_id']}}" data-pid="{{$data['parent_id']}}" data-toggle="modal" data-target="#myView">查看子分类</button>
                                            <button type="button" class='edit f-ib btn btn-primary btn-xs' data-id="{{$data['cat_id']}}" data-pid="{{$data['parent_id']}}" data-toggle="modal" data-target="#myModal">编辑</button>
                                            <button type="button" class="del f-ib btn btn-danger btn-xs" data-id="{{$data['cat_id']}}" data-pid="{{$data['parent_id']}}">删除</button>
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
            <!-- Modal -->
    <div class="modal fade" id="myView" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">查看子分类</h4>
                </div>
                <div class="modal-body">
                    <dl class="dl" id="soncate">
                    </dl>
                </div>
            </div>
        </div>
    </div>
            <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">编辑分类</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="myform" action="" method="post">
                        <input type="hidden" name="_method" value="PUT">
                        <div class="form-group">
                            <label for="catname" class="col-sm-2 control-label">分类名称</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="catname" id="catname" placeholder="Name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="keyword" class="col-sm-2 control-label">关键字</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Keyword">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="keyword" class="col-sm-2 control-label">排名</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="sort" id="sort" placeholder="阿拉伯数字，从小到大排">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">描述</label>
                            <div class="col-sm-9">
                                <textarea name="description" id="description" placeholder="Description" cols="57" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="form-group" id="par">
                            <label for="parent" class="col-sm-2 control-label">父级分类</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="parent" id="par0"></select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="parent" class="col-sm-2 control-label">是否显示</label>
                            <div class="col-sm-9">
                                <div class="level f-ib">
                                    <input type="radio" name="ishow" id="show0" value="0">
                                    <label for="show0">不显示</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="ishow" id="show1"  value="1">
                                    <label for="show1">显示</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-9">
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
<script src="/admin/js/cate.js"></script>
</body>
</html>
