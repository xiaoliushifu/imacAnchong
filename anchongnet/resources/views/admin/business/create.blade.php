<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>发布商机</title>
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
            <h1>发布商机</h1>
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
                            <?php
                                if(isset($mes)){
                                    echo "<div class='alert alert-info' role='alert'>$mes</div>";
                                };
                            ?>
                            <form role="form" class="form-horizontal" action="/business" method="post">
                                <input type="hidden" name="uid" value="{{Auth::user()['users_id']}}">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="title">标题</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="title" id="title" class="form-control" required value="{{ old('title') }}"/>
                                    </div>
                                </div><!--end form-group-->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="content">内容</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" rows="5" id="content" required value="{{ old('content') }}" name="content"></textarea>
                                    </div>
                                </div><!--end form-group-->
                                <ul class="form-group hidden" id="img">
                                </ul>
                                <div class="gal form-group">
                                    <label class="col-sm-2 control-label text-right">商机详情图片<br></label>
                                    <div id="detailbox" class="col-sm-10">
                                        <div id="detail"></div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="tag">标签</label>
                                    <div class="col-sm-9">
                                        <select name="tag" id="tag" class="form-control" required>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="contact">联系人</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="contact" name="contact" value="{{ old('contact') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="phone">电话</label>
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control" id="phone" name="phone" required value="{{ old('phone') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="etype">类型</label>
                                    <div class="col-sm-9">
                                        <select name="type" class="form-control" id="etype" required>
                                            <option value="1">发布工程</option>
                                            <option value="2">承接工程</option>
                                            <option value="3">发布人才</option>
                                            <option value="4">招聘人才</option>
                                            <option value="5">找商品</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="area">区域</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="area" class="form-control" name="area" required value="{{ old('area') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="area">工程结束时间</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="endtime" class="form-control" name="endtime" value="{{ old('endtime') }}">
                                    </div>
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
<script src="/admin/js/webuploader.html5only.min.js"></script>
<script src="/admin/js/diyUpload.js"></script>
<script src="/admin/js/createbusiness.js"></script>
</body>
</html>
