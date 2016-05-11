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
        .delpic{position: absolute; right: 0; top: -5px;}
        .gallery{width: 80px; height: 80px; background: url("/admin/image/catetypecreate/add.jpg") center center no-repeat; border: solid #ddd 1px;  cursor: pointer; display:table-cell; vertical-align: middle;}
        .gallery img{max-width: 100%; max-height: 100%;}
        .addpic{margin-top: -100px;}
    </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <?php echo $__env->make('inc.admin.mainHead', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <?php echo $__env->make('inc.admin.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
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
                                <input type="text" name="keyName" value="<?php echo e($datacol['args']['keyName']); ?>" class="form-control" placeholder="商品名称">
                                <button type="submit" class="btn btn-primary btn-sm" id="filter">筛选</button>
                            </form>
                            <a href="/commodity" class="btn btn-default btn-sm unplay f-ib" role="button">取消筛选</a>
                            <table id="example1" class="table table-bordered table-striped">
                                <tr>
                                    <th width="20%">商品名称</th>
                                    <th width="60%">描述</th>
                                    <th>操作</th>
                                </tr>
                                <?php foreach($datacol['datas'] as $data): ?>
                                    <tr>
                                        <td align="center"><?php echo e($data['title']); ?></td>
                                        <td align="center"><?php echo e($data['desc']); ?></td>
                                        <td align="center">
                                            <button type="button" class="view f-ib btn btn-primary btn-xs" data-id="<?php echo e($data['goods_id']); ?>" data-toggle="modal" data-target="#myView">查看下属货品</button>
                                            <button type='button' class='edit f-ib btn btn-primary btn-xs' data-id="<?php echo e($data['goods_id']); ?>" data-tid="<?php echo e($data['type']); ?>" data-toggle="modal" data-target="#myModal">编辑</button>
                                            <button type="button" class="del f-ib btn btn-danger btn-xs" data-id="<?php echo e($data['goods_id']); ?>">删除</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
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
                    <form action="" method="post" class="form-horizontal" id="updataForm">
                        <input type="hidden" name="_method" value="PUT">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">商品分类</label>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <select class="form-control" id="mainselect" name="mainselect" required>
                                        </select>
                                    </div>
                                    <div class="col-xs-4">
                                        <select class="form-control" id="midselect" name="midselect" required>
                                        </select>
                                    </div>
                                </div><!--end row-->
                            </div><!--end col-sm-10-->
                        </div><!--end form-group-->
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">商品名称</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="title" id="title" placeholder="Name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">描述</label>
                            <div class="col-sm-9">
                                <textarea name="description" id="description" class="form-control" rows="5"></textarea>
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
                            <ul class="gallerys col-sm-10 list-inline">
                                <li class="template hidden">
                                    <div class="gallery text-center">
                                        <img src="" class="img">
                                    </div>
                                    <input type="file" name="file" class="pic" data-type="1">
                                </li>
                                <button type="button" class="addpic btn btn-default" title="继续添加图片" id="addfordetail">+</button>
                            </ul>
                        </div>
                        <div class="gal form-group">
                            <label class="col-sm-2 control-label">相关参数图片</label>
                            <ul class="gallerys col-sm-10 list-inline">
                                <li class="template hidden">
                                    <div class="gallery text-center">
                                        <img src="" class="img">
                                    </div>
                                    <input type="file" name="file" class="pic" data-type="2">
                                </li>
                                <button type="button" class="addpic btn btn-default" title="继续添加图片" id="addforparam">+</button>
                            </ul>
                        </div>
                        <div class="gal form-group">
                            <label class="col-sm-2 control-label">相关资料图片</label>
                            <ul class="gallerys col-sm-10 list-inline">
                                <li class="template hidden">
                                    <div class="gallery text-center">
                                        <img src="" class="img">
                                    </div>
                                    <input type="file" name="file" class="pic" data-type="3">
                                </li>
                                <button type="button" class="addpic btn btn-default" title="继续添加图片" id="addfordata">+</button>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="activeFlag" value="treegood">
    <!-- /.content-wrapper -->
    <?php echo $__env->make('inc.admin.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
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
