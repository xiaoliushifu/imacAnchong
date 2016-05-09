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
            <h1>添加货品</h1>
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
                            <form role="form" class="form-horizontal" action="/good" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="sid" id="sid" value="<?php echo e($sid); ?>">
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
                                            <div class="col-xs-3">
                                                <select class="form-control" id="backselect" name="backselect" required>
                                                    <option value="">请选择</option>
                                                </select>
                                            </div>
                                        </div><!--end row-->
                                    </div><!--end col-sm-10-->
                                </div><!--end form-group-->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="name">选择商品</label>
                                    <div class="col-sm-3">
                                        <select class="form-control" id="name" name="name" required>
                                            <option value="">请选择</option>
                                        </select>
                                        <input type="hidden" name="goodname" id="goodname" value="">
                                    </div>
                                </div><!--end form-group-->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="spetag">货品标签</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="spetag" id="spetag" class="form-control" required placeholder="如：黄色32码" value="<?php echo e(old('spetag')); ?>" />
                                    </div>
                                </div><!--end form-group-->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="marketprice">市场价</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="marketprice" id="marketprice" class="form-control" required value="<?php echo e(old('marketprice')); ?>" />
                                    </div>
                                </div><!--end form-group-->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="costprice">成本价</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="costpirce" id="costprice" class="form-control" value="<?php echo e(old('costpirce')); ?>" />
                                    </div>
                                </div><!--end form-group-->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="viprice">会员价</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="viprice" id="viprice" class="form-control" required value="<?php echo e(old('viprice')); ?>" />
                                    </div>
                                </div><!--end form-group-->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="description">描述</label>
                                    <div class="col-sm-3">
                                        <textarea name="description" id="description" class="form-control" rows="5"><?php echo e(old('description')); ?></textarea>
                                    </div>
                                </div><!--end form-group-->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="keyword">关键字</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="keyword" id="keyword" class="form-control" placeholder="多个关键字之间请用空格隔开" value="<?php echo e(old('keyword')); ?>" />
                                    </div>
                                </div><!--end form-group-->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">是否上架</label>
                                    <div class="col-sm-3">
                                        <label class="radio-inline">
                                            <input type="radio" name="status" value="1" />上架
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="status" value="0" checked />暂不
                                        </label>
                                    </div>
                                </div><!--end form-group-->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">库存</label>
                                    <div class="col-sm-10">
                                        <table class="table text-center">
                                            <thead>
                                            <tr>
                                                <th class="text-center col-sm-1">区域</th>
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
                                <div class="gal form-group">
                                    <label for="pic" class="col-sm-2 control-label">商品图片<br><i>最多可上传五张</i></label>
                                    <ul class="gallerys col-sm-10 list-inline">
                                        <li class="template hidden">
                                            <div class="gallery text-center">
                                                <img src="" class="img">
                                            </div>
                                            <input type="file" name="pic[]" class="pic">
                                        </li>
                                        <li class="first">
                                            <div class="gallery text-center">
                                                <img src="" class="img">
                                            </div>
                                            <input type="file" name="pic[]" class="pic" required>
                                        </li>
                                        <button type="button" class="goodpic addpic btn btn-default" title="继续添加图片">+</button>
                                    </ul>
                                </div>
                                <div class="gal form-group">
                                    <label for="pic" class="col-sm-2 control-label">详情图片<br><i>至少上传一张</i></label>
                                    <ul class="gallerys col-sm-10 list-inline">
                                        <li class="template hidden">
                                            <div class="gallery text-center">
                                                <img src="" class="img">
                                            </div>
                                            <input type="file" name="detailpic[]" class="pic">
                                        </li>
                                        <li class="first">
                                            <div class="gallery text-center">
                                                <img src="" class="img">
                                            </div>
                                            <input type="file" name="detailpic[]" class="pic" required>
                                        </li>
                                        <button type="button" class="addpic btn btn-default" title="继续添加图片">+</button>
                                    </ul>
                                </div>
                                <div class="gal form-group">
                                    <label for="pic" class="col-sm-2 control-label">相关参数图片<br><i>至少上传一张</i></label>
                                    <ul class="gallerys col-sm-10 list-inline">
                                        <li class="template hidden">
                                            <div class="gallery text-center">
                                                <img src="" class="img">
                                            </div>
                                            <input type="file" name="parampic[]" class="pic">
                                        </li>
                                        <li class="first">
                                            <div class="gallery text-center">
                                                <img src="" class="img">
                                            </div>
                                            <input type="file" name="parampic[]" class="pic" required>
                                        </li>
                                        <button type="button" class="addpic btn btn-default" title="继续添加图片">+</button>
                                    </ul>
                                </div>
                                <div class="gal form-group">
                                    <label for="pic" class="col-sm-2 control-label">相关资料图片<br><i>至少上传一张</i></label>
                                    <ul class="gallerys col-sm-10 list-inline">
                                        <li class="template hidden">
                                            <div class="gallery text-center">
                                                <img src="" class="img">
                                            </div>
                                            <input type="file" name="datapic[]" class="pic">
                                        </li>
                                        <li class="first">
                                            <div class="gallery text-center">
                                                <img src="" class="img">
                                            </div>
                                            <input type="file" name="datapic[]" class="pic" required>
                                        </li>
                                        <button type="button" class="addpic btn btn-default" title="继续添加图片">+</button>
                                    </ul>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="numbering">商品编号</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="numbering" id="numbering" class="form-control" value="<?php echo e(old('numbering')); ?>" required />
                                    </div>
                                </div><!--end form-group-->
                                <div class="form-group text-center">
                                    <label class="col-sm-2 control-label"></label>
                                    <div class="col-sm-3">
                                        <button type="submit" class="btn btn-info" id="sub">添加货品</button>
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
    <input type="hidden" id="activeFlag" value="treegood">
    <!-- /.content-wrapper -->
    <?php echo $__env->make('inc.admin.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>
<!-- Bootstrap 3.3.5 -->
<script src="/admin/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="/admin/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/admin/dist/js/app.min.js"></script>
<script src="/admin/js/creategood.js"></script>
</body>
</html>
