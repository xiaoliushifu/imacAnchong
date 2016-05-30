<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>添加货品</title>
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
        #box{top:7px;}
        li{list-style: none;}
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
            <h1>添加货品</h1>
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
                            <h4 class="text-center">基本信息</h4>
                            <?php
                                if(isset($mes)){
                                    echo "<div class='alert alert-info' role='alert'>$mes</div>";
                                };
                            ?>
                            <form role="form" class="form-horizontal" action="/good" method="post">
                                <input type="hidden" name="sid" id="sid" value="{{$sid}}">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">商品分类</label>
                                    <div class="col-sm-10">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <select class="form-control" id="mainselect" name="mainselect" required>
                                                    <option value="">请选择</option>
                                                </select>
                                            </div>
                                            <div class="col-xs-3">
                                                <select class="form-control" id="midselect" name="midselect" required>
                                                    <option value="">请选择</option>
                                                </select>
                                            </div>
                                        </div><!--end row-->
                                    </div><!--end col-sm-10-->
                                </div><!--end form-group-->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">选择分类标签</label>
                                    <div class="col-sm-3">
                                        <div class="checkbox" id="checks">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="name">选择商品</label>
                                    <div class="col-sm-3">
                                        <select class="form-control" id="name" name="name" required>
                                            <option value="">请选择</option>
                                        </select>
                                        <input type="hidden" name="commodityname" id="commodityname">
                                        <input type="hidden" name="type" id="type">
                                    </div>
                                </div><!--end form-group-->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="keyword">关键字</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="keyword" id="keyword" class="form-control" readonly />
                                    </div>
                                </div><!--end form-group-->
                                <ul class="form-group" id="attrs">
                                </ul>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="marketprice">市场价</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="marketprice" id="marketprice" class="form-control" required value="{{ old('marketprice') }}" />
                                    </div>
                                </div><!--end form-group-->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="costprice">成本价</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="costpirce" id="costprice" class="form-control" value="{{ old('costpirce') }}" />
                                    </div>
                                </div><!--end form-group-->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="viprice">会员价</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="viprice" id="viprice" class="form-control" required value="{{ old('viprice') }}" />
                                    </div>
                                </div><!--end form-group-->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">是否上架</label>
                                    <div class="col-sm-3">
                                        <label class="radio-inline">
                                            <input type="radio" name="status" value="1" checked />上架
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="status" value="0"/>暂不
                                        </label>
                                    </div>
                                </div><!--end form-group-->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="numbering">货品编号</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="numbering" id="numbering" class="form-control" value="{{ old('numbering') }}" required />
                                    </div>
                                </div><!--end form-group-->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">库存</label>
                                    <div class="col-sm-8">
                                        <table class="table text-center">
                                            <thead>
                                            <tr>
                                    <th class="text-center col-sm-1">货位</th>
                                                <th class="text-center col-sm-1">货架</th>

                                                <th class="text-center col-sm-1">库存数</th>
                                                <th class="text-center col-sm-1">操作</th>
                                            </tr>
                                            </thead>
                                            <tbody id="stock">
                                            <tr class="line">
                                                <td>
                                                    <input type="text" name="stock[region][]" class="form-control" required />
                                                </td>
                                                <td>
                                                    <input type="text" name="stock[location][]" class="form-control" required />
                                                </td>
                                                <td>
                                                    <input type="text" name="stock[shelf][]" class="form-control" required />
                                                </td>
                                                <td>
                                                    <input type="number" min="0" name="stock[num][]" class="form-control" required />
                                                </td>
                                                <td>
                                                    <button type="button" class="addcuspro btn-sm btn-link" title="添加">
                                                        <span class="glyphicon glyphicon-plus"></span>
                                                    </button>
                                                    <button type="button" class="delcuspro btn-sm btn-link" title="删除">
                                                        <span class="glyphicon glyphicon-minus"></span>
                                                    </button>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <ul class="form-group hidden" id="img">
                                </ul>
                                <div class="gal form-group">
                                    <label for="pic" class="col-sm-2 control-label text-right">商品图片<br><i>最多可上传五张</i></label>
                                    <div id="box" class="col-sm-10">
                                        <div id="test"></div>
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <label class="col-sm-2 control-label"></label>
                                    <div class="col-sm-3">
                                        <button type="submit" class="btn btn-info" id="sub">保存</button>
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
    <input type="hidden" id="activeFlag" value="treegood">
    @include('inc.admin.footer')
</div>
<!-- ./wrapper -->
<!-- Bootstrap 3.3.5 -->
<script src="/admin/bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="/admin/dist/js/app.min.js"></script>
<script src="/admin/js/webuploader.html5only.min.js"></script>
<script src="/admin/js/diyUpload.js"></script>
<script src="/admin/js/creategood.js"></script>
</body>
</html>
