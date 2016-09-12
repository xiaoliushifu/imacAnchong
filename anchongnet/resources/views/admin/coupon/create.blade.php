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
        #myform label.error 
        {   color:Red; 
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
            <h1>生成优惠券</h1>
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
                            <form role="form" class="form-horizontal" id="myform" action="/coupon" method="post">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="cvalue">券类型</label>
                                    <div class="col-sm-2">
                                        <input type="number" name="shop" id="shop" class="form-control" required value="{{ old('shop') }}"  placeholder=""/>
                                    </div>
                                    <small>0代表通用，其他请填写商铺id</small>
                                </div>
                                <div class="form-group">
                                		<label class="col-sm-2 control-label">子类型</label>
                                		<div class="col-sm-2">
                                    		<select class="form-control" name="type"  id="type" placeholder="选项">
                                        		<option value="1" tit="通用">通用</option>
                                        		<option value="2"  tit="请填写分类ID">分类</option>
                                        		<option value="3"  tit="请填写商品ID">商品</option>
                                        		<option value="4" tit ="填写品牌ID">品牌</option>
                                    		</select>
                                		</div>
                                </div>
                                <div class="form-group">
                                		<label class="col-sm-2 control-label">关联类型</label>
                                    <div class="col-sm-2">
                                    		<input type="text" class="form-control" name="type2"  id="type2"  readonly placeholder="通用" />
                                    </div>
                                    <small>关联类型的值，根据子类型的不同，代表不同的意义</small>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="cvalue">起始使用值</label>
                                    <div class="col-sm-2">
                                        <input type="number" name="target" id="target" class="form-control" required value="{{ old('target') }}" />
                                    </div>
                                    <small>如：满2000减100，就填写2000</small>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="cvalue">优惠券面额</label>
                                    <div class="col-sm-2">
                                        <input type="number" name="cvalue" id="cvalue" class="form-control" required value="{{ old('cvalue') }}" />
                                    </div>
                                    <small>如：满2000减100，就填写100</small>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="title">优惠券标题</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="title" id="title"  readonly class="form-control" required value="{{ old('title') }}" placeholder="如：满2000减100"/>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="beans">虫豆数</label>
                                    <div class="col-sm-2">
                                        <input type="number" name="beans" id="beans" class="form-control"  value="{{ old('beans')?: 0 }}" />
                                    </div>
                                    <small>将来兑换优惠券时的虫豆数，0代表不可兑换</small>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="beans">截止日期</label>
                                    <div class="col-sm-2">
                                        <input type="number" name="endline" id="endline" class="form-control"  value="{{ old('beans')?: 0 }}" />
                                    </div>
                                    <small>只填写日期，如：2017-08-08</small>
                                </div>
                                <div class="form-group text-center">
                                    <label class="col-sm-2 control-label"></label>
                                    <div class="col-sm-3">
                                        <button type="submit" class="btn btn-info">添加</button>
                                    </div>
                                </div>
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
    <input type="hidden" id="activeFlag" value="treecoupon">
    @include('inc.admin.footer')
</div>
<!-- ./wrapper -->
<!-- Bootstrap 3.3.5 -->
<script src="/admin/bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="/admin/dist/js/app.min.js"></script>
<!-- jquery 验证插件 -->
<script src="/admin/plugins/form/jquery.validate.min.js"></script>
<script src="/admin/js/createcoupon.js"></script>
</body>
</html>
