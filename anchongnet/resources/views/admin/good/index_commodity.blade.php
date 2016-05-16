<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>商品列表</title>
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
        .dl-horizontal dt{width: 40px;}
        .dl-horizontal dd{margin-left:48px;}
        .pic{position: relative; top: 7px; visibility: hidden;}
        .gal{margin-top: 20px;}
        .gallerys li{width:10%; min-width: 80px; position: relative;}
        .gallery{width: 80px; height: 80px; background: url("/admin/image/catetypecreate/add.jpg") center center no-repeat; border: solid #ddd 1px;  cursor: pointer; display:table-cell; vertical-align: middle;}
        .gallery img{max-width: 100%; max-height: 100%;}
         .add,.minus{margin-top:4px;}
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
            <h1>商品列表</h1>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <form action="/commodity" method="get" class="form-horizontal form-inline f-ib">
                                <input type="text" name="keyName" value="{{$datacol['args']['keyName']}}" class="form-control" placeholder="商品名称">
                                <button type="submit" class="btn btn-primary btn-sm" id="filter">筛选</button>
                            </form>
                            <a href="/commodity" class="btn btn-default btn-sm unplay f-ib" role="button">取消筛选</a>
                            <table id="example1" class="table table-bordered table-striped">
                                <tr>
                                    <th width="20%">商品名称</th>
                                    <th width="60%">描述</th>
                                    <th>操作</th>
                                </tr>
                                @foreach ($datacol['datas'] as $data)
                                    <tr>
                                        <td align="center">{{$data['title']}}</td>
                                        <td align="center">{{$data['desc']}}</td>
                                        <td align="center">
                                            <button type="button" class="view f-ib btn btn-primary btn-xs" data-id="{{$data['goods_id']}}" data-toggle="modal" data-target="#myView">查看下属货品</button>
                                            <button type='button' class='edit f-ib btn btn-primary btn-xs' data-id="{{$data['goods_id']}}"  data-toggle="modal" data-target="#myModal">编辑</button>
                                            <button type="button" class="del f-ib btn btn-danger btn-xs" data-id="{{$data['goods_id']}}">删除</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3" align="center">
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
    <div class="modal fade" id="myView" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-body">
                    <table class="table" id="viewtable">
                        <tr>
                            <th>货品标签</th>
                            <th>货品编号</th>
                            <th>货品图片</th>
                        </tr>
                    </table>
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
                    <h4 class="modal-title" id="myModalLabel">商品编辑</h4>
                </div>
                <div class="modal-body">
                    <h5 class="text-center">基本信息</h5>
                    <div class="catemplate hidden form-group">
                        <label class="col-sm-2 control-label">商品分类</label>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-xs-4">
                                    <select class="mainselect form-control" name="mainselect" required>
                                        <option value="">请选择</option>
                                    </select>
                                </div>
                                <div class="col-xs-4">
                                    <select class="midselect form-control" name="midselect[]" required>
                                        <option value="">请选择</option>
                                    </select>
                                </div>
                                <div class="add col-xs-1">
                                    <button type="button" class="btn btn-xs glyphicon glyphicon-plus" title="添加分类"></button>
                                </div>
                                <div class="minus col-xs-1">
                                    <button type="button" class="btn btn-xs glyphicon glyphicon-minus" title="删除分类"></button>
                                </div>
                            </div><!--end row-->
                        </div><!--end col-sm-10-->
                    </div><!--end form-group-->
                    <form action="" method="post" class="form-horizontal" id="updataForm">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="flag" id="flag">
                        <div id="catarea">

                        </div>
                        <div class="form-name form-group">
                            <label for="title" class="col-sm-2 control-label">商品名称</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="title" id="title" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="keyword">关键字</label>
                            <div class="col-sm-9">
                                <input type="text" name="keyword" id="keyword" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">描述</label>
                            <div class="col-sm-9">
                                <textarea name="description" id="description" class="form-control" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="gal form-group">
                            <label class="col-sm-2 control-label">技术参数</label>
                            <div class="gallerys col-sm-9">
                                @include('UEditor::head')
                                        <!-- 加载编辑器的容器 -->
                                <script id="container" name="param" type="text/plain">
                                </script>
                            </div>
                        </div>
                        <div class="gal form-group">
                            <label class="col-sm-2 control-label">包装清单</label>
                            <div class="gallerys col-sm-9">
                                @include('UEditor::head')
                                        <!-- 加载编辑器的容器 -->
                                <script id="container1" name="data" type="text/plain"></script>
                                <!-- 实例化编辑器 -->
                                <script>
                                    UE.getEditor('container');
                                    UE.getEditor('container1');
                                </script>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label text-right">备注<br></label>
                            <div class="col-sm-9">
                                <textarea name="remark" id="remark" class="form-control" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-9">
                                <button type="submit" name="sub" class="btn btn-primary btn-sm" id="sub">保存</button>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <h5 class="text-center">属性信息</h5>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <table class="table text-center">
                                <thead>
                                <tr>
                                    <th class="text-center col-sm-1">属性名</th>
                                    <th class="text-center col-sm-2">属性值</th>
                                    <th class="text-center col-sm-1">操作</th>
                                </tr>
                                </thead>
                                <tbody id="stock">
                                </tbody>
                            </table>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <hr>
                    <h5 class="text-center">图片信息</h5>
                    <form role="form" class="form-horizontal" action="" id="formToUpdate" method="post" enctype="multipart/form-data">
                        <div id="method"></div>
                        <input type="hidden" name="gid" id="gid">
                        <div class="gal form-group">
                            <label class="col-sm-2 control-label">详情图片</label>
                            <div class="gallerys col-sm-10 list-inline">
                                <div class="gallery text-center">
                                    <img src="" class="img" id="img">
                                </div>
                                <input type="file" name="file" class="pic">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="activeFlag" value="treegood">
    <!-- /.content-wrapper -->
    @include('inc.admin.footer')
</div>
<!-- ./wrapper -->
<!-- Bootstrap 3.3.5 -->
<script src="/admin/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="/admin/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/admin/dist/js/app.min.js"></script>
<script src="/admin/js/jquery.form.js"></script>
<script src="/admin/js/commodity.js"></script>
</body>
</html>
