<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>添加发布</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="/admin/bootstrap/css/bootstrap.min.css">

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
        .add,.minus,.addsup,.minusup{margin-top:4px;}
        /*************************
	      * 自定义validate插件的验证错误时的样式
	   ************************/
	   #myform label.error 
        { 
            color:Red; 
            font-size:13px; 
            margin-left:5px; 
            padding-left:16px; 
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
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>添加发布</h1>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <form action="/release" method="post" id="myform">
                                <input type="hidden" name="uid" value="{{Auth::user()['users_id']}}">
                                <input type="hidden" name="name" value="{{Auth::user()['username']}}">
                                <input type="hidden" name="headpic" value="{{Auth::user()['headpic']}}">
                                <div class="form-group">
                                    <label for="type">标签类型：</label>
                                    <select class="form-control" name="tag" required>
                                        <option value="">请选择</option>
                                        <option value="闲聊">闲聊</option>
                                        <option value="问问">问问</option>
                                        <option value="活动">活动</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="title">标题：</label>
                                    <input type="text" name="title" class="form-control" id="title" placeholder="标题" required>
                                </div>
                                <ul class="form-group hidden" id="img">
                                </ul>
                                <div class="gal form-group">
                                    <div id="detailbox">
                                        <div id="detail"></div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-group">
                                    <label for="conent">内容：</label>
                                    <textarea class="form-control" name="content" id="content" rows="5" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-default" id="add">添加</button>
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
    <input type="hidden" id="activeFlag" value="treerelease">
    @include('inc.admin.footer')
</div>
<!-- ./wrapper -->
<!-- Bootstrap 3.3.5 -->
<script src="/admin/bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="/admin/dist/js/app.min.js"></script>
{{--引入jquery插件验证表单--}}
<script src="/admin/plugins/form/jquery.validate.min.js"></script>
{{--引入jquery插件ajax提交表单--}}
<script src="/admin/js/jquery.form.js"></script>
<script src="/admin/js/webuploader.html5only.min.js"></script>
<script src="/admin/js/diyUpload.js"></script>
<script src="/admin/js/createrelease.js"></script>
</body>
</html>
