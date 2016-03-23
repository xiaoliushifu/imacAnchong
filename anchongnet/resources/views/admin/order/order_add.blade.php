<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | General Form Elements</title>
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
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="/admin/plugins/colorpicker/bootstrap-colorpicker.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="/admin/plugins/daterangepicker/daterangepicker-bs3.css">
  
    <link rel="stylesheet" href="/admin/plugins/timepicker/bootstrap-timepicker.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="/admin/dist/css/skins/_all-skins.min.css">
   <link rel="stylesheet" href="/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
@include('Inc.admin.mainHead')
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
  @include('Inc.admin.sidebar')
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        添加商品
<!--         <small>Preview</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> 首页</a></li>
        <li><a href="#">订单管理</a></li>
        <li class="active">添加商品</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">请录入商品</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputPassword1">商品名称</label>
                  <input type="goods_name" class="form-control" id="exampleInputPassword1" placeholder="商品名称">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">商品货号</label>
                  <input type="goods_only" class="form-control" id="exampleInputPassword1" placeholder="商品货号">
                </div>
                <div class="form-group">
                  <label>商品分类</label>
                  <select class="form-control">
                    <option>智能一卡通</option>
                    <option>智能门禁</option>
                   
                  </select>
                  <label>智能门禁</label>
                  <select class="form-control">
                    <option>智能门锁</option>
                    <option>智能门禁</option>
                  </select>
                  <label>探测报警</label>
                  <select class="form-control">
                    <option>入侵探测</option>
                 
                  </select>

                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">品牌</label>
                  <input type="brand_id" class="form-control" id="exampleInputPassword1" placeholder="品牌">
                </div>
     
                    <div class="form-group">
                      <label>商品颜色</label>

                      <div class="input-group my-colorpicker2">
                        <input type="text" class="form-control" placeholder="商品颜色">

                        <div class="input-group-addon">
                          <i></i>
                     </div>
 
                    </div>
                    <!-- /.form group -->
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">品牌价格</label>
                  <input type="goods_price" class="form-control" id="exampleInputPassword1" placeholder="品牌价格">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">产品尺寸</label>
                  <input type="goods_size" class="form-control" id="exampleInputPassword1" placeholder="产品尺寸">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">产品数量</label>
                  <input type="goods_number" class="form-control" id="exampleInputPassword1" placeholder="产品数量">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">产品价格</label>
                  <input type="shop_price" class="form-control" id="exampleInputPassword1" placeholder="产品价格">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">市场价格</label>
                  <input type="market_price" class="form-control" id="exampleInputPassword1" placeholder="市场价格">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">商品关键字</label>
                  <input type="keyword" class="form-control" id="exampleInputPassword1" placeholder="商品关键字">
                </div>
                </div>
                <!-- Main content -->
                <section class="content">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="box box-info">
                        <div class="box-header">
                          <h3 class="box-title">CK Editor
                            <small>Advanced and full of features</small>
                          </h3>
                          <!-- tools box -->
                          <div class="pull-right box-tools">
                            <button type="button" class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                              <i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove">
                              <i class="fa fa-times"></i></button>
                          </div>
                          <!-- /. tools -->
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body pad">
                          <form>
                                <textarea id="editor1" name="editor1" rows="10" cols="80">
                                                        This is my textarea to be replaced with CKEditor.
                                </textarea>
                          </form>
                        </div>
                      </div>
                      <!-- /.box -->

                      <div class="box">
                        <div class="box-header">
                          <h3 class="box-title">Bootstrap WYSIHTML5
                            <small>Simple and fast</small>
                          </h3>
                          <!-- tools box -->
                          <div class="pull-right box-tools">
                            <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                              <i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-default btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove">
                              <i class="fa fa-times"></i></button>
                          </div>
                          <!-- /. tools -->
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body pad">
                          <form>
                            <textarea class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                          </form>
                        </div>
                      </div>
                    </div>
                    <!-- /.col-->
                  </div>
                  <!-- ./row -->
                </section>
            
                <div class="form-group">
                  <label for="exampleInputPassword1">商品详情</label>
                  <input type="goods_desc" class="form-control" id="exampleInputPassword1" placeholder="商品详情">
                </div>
                <div class="form-group">
                  <label for="exampleInputFile">上传商品图片</label>
                  <input type="file" id="exampleInputFile">

<!--                   <p class="help-block">Example block-level help text here.</p> -->
                </div>
             
                <div class="checkbox">
                  <label>
                    <input type="checkbox"> 发布
                  </label>
                  <label>
                    <input type="checkbox"> 未发布
                  </label>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">确认</button>
              </div>
            </form>
          </div>
          <!-- /.box -->
          <!-- general form elements disabled -->
               <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 @include('inc.admin.footer')

  <!-- Control Sidebar -->
@include('inc.admin.controlsidebar')
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.0 -->
<script src="/admin/plugins/jQuery/jQuery-2.2.0.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="/admin/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="/admin/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/admin/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/admin/dist/js/demo.js"></script>
<!-- bootstrap color picker -->
<script src="/admin/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<script src="/admin/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="/admin/plugins/daterangepicker/daterangepicker.js"></script>


  <script>
    $(function () {
      //Initialize Select2 Elements
      //Colorpicker
      $(".my-colorpicker1").colorpicker();
      //color picker with addon
      $(".my-colorpicker2").colorpicker();

    });
 </script>
</body>
</html>
