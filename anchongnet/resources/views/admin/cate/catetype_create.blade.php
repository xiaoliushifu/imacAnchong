<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>添加商品分类</title>
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
        .f-ib{display:inline-block;}
        .pic{position: relative; top: 7px; visibility: hidden;}
        .gal{margin-top: 20px;}
        .gallery{width: 100px; height: 100px; background: url("/admin/image/catetypecreate/add.jpg") center center no-repeat; border: solid #ddd 1px;  cursor: pointer; display:table-cell; vertical-align: middle;}
        .gallery img{width:100%;}
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
            <h1>添加商品分类</h1>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <form role="form" class="form-horizontal" action="/goodcatetype" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">分类名称</label>
                                    <div class="col-sm-5">
                                        <input type="text" name="catname" class="form-control" required />
                                    </div>
                                </div><!--end form-group-->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">关键字</label>
                                    <div class="col-sm-5">
                                        <input type="text" name="keyword" class="form-control" placeholder="多个关键字之间请用逗号隔开" />
                                    </div>
                                </div><!--end form-group-->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">分类描述</label>
                                    <div class="col-sm-5">
                                        <textarea name="description" class="form-control" rows="5"></textarea>
                                    </div>
                                </div><!--end form-group-->
                                <div class="form-group" id="par">
                                    <label for="parent" class="col-sm-2 control-label">父级分类</label>
                                    <div class="col-sm-2 f-ib">
                                        <select class="form-control" name="parent" id="par0">
                                        </select>
                                    </div>
                                    <div class="col-sm-2 f-ib">
                                        <select class="form-control" name="parent1" id="par1">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="parent" class="col-sm-2 control-label">是否显示</label>
                                    <div class="col-sm-5">
                                        <label class="radio-inline">
                                            <input type="radio" name="ishow" id="show0" value="0" checked>不显示
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="ishow" id="show1"  value="1">显示
                                        </label>
                                    </div>
                                </div>
                                <div class="gal form-group">
                                    <label for="pic" class="col-sm-2 control-label">分类图片</label>
                                    <div class="col-sm-5">
                                        <div class="gallery text-center">
                                            <img src="" id="img0">
                                        </div>
                                        <input type="file" id="pic" name="pic" class="pic">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"></label>
                                    <div class="col-sm-5">
                                        <button type="submit" class="btn btn-info">添加</button>
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
   <input type="hidden" id="activeFlag" value="treecate">
    @include('inc.admin.footer')
</div>
<!-- ./wrapper -->
<!-- Bootstrap 3.3.5 -->
<script src="/admin/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="/admin/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/admin/dist/js/app.min.js"></script>
<script src="/admin/js/createcatetype.js"></script>
</body>
</html>
