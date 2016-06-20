<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>发布资讯</title>
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
    <link rel="stylesheet" href="/admin/css/diyUpload.css">
    <link rel="stylesheet" href="/admin/css/webuploader.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        *{margin: 0;padding: 0;}
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
            <h1>发布资讯</h1>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <?php if(count($errors) > 0): ?>
                                <div class="alert alert-danger">
                                    <ul>
                                        <?php foreach($errors->all() as $error): ?>
                                            <li><?php echo e($error); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            <?php
                                if(isset($mes)){
                                    echo "<div class='alert alert-info' role='alert'>$mes</div>";
                                };
                            ?>
                            <form role="form" class="form-horizontal" action="/business" method="post">
                                <input type="hidden" name="uid" value="<?php echo e(Auth::user()['users_id']); ?>">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label glyphicon " for="title">标题</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="title" id="title" class="form-control" required value="<?php echo e(old('title')); ?>"/>
                                    </div>
                                </div><!--end form-group-->
                                  <div class="form-group">
                                    <label class="col-sm-2 control-label" for="content">内容</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" rows="5" id="content" required value="<?php echo e(old('content')); ?>" name="content"></textarea>
                                    </div>
                                </div><!--end form-group-->
                                <ul class="form-group hidden" id="img">
                                </ul>
                                <div class="gal form-group">
                                    <label class="col-sm-2 control-label text-right">资讯详情图片<br></label>
                                    <div id="detailbox" class="col-sm-10">
                                        <div id="detail"></div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-group text-center">
                                    <label class="col-sm-3 control-label"></label>
                                    <div class="col-sm-3">
                                        <button type="submit" class="btn btn-info">保存</button>
                                    </div>
                                </div><!--end form-group text-center-->
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
    <input type="hidden" id="activeFlag" value="treebusiness">
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
<script src="/admin/js/webuploader.html5only.min.js"></script>
<script src="/admin/js/diyUpload.js"></script>
<script src="/admin/js/createbusiness.js"></script>
</body>
</html>
