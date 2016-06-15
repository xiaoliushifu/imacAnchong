<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>货品列表</title>
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
            <h1>货品列表</h1>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <form action="/good" method="get" class="form-horizontal form-inline f-ib">
                                <input type="text" name="keyName" value="{{$datacol['args']['keyName']}}" class="form-control" placeholder="货品名称">
                                <button type="submit" class="btn btn-primary btn-sm" id="filter">筛选</button>
                            </form>
                            <a href="/good" class="btn btn-default btn-sm unplay f-ib" role="button">取消筛选</a>
                            <table id="example1" class="table table-bordered table-striped">
                                <tr>
                                    <th>货品名称</th>
                                    <th>市场价</th>
                                    <th>会员价</th>
                                    <th>货品编号</th>
                                    <th>操作</th>
                                </tr>
                                @foreach ($datacol['datas'] as $data)
                                    <tr>
                                        <td align="center">{{$data['goods_name']}}</td>
                                        <td align="center">{{$data['market_price']}}</td>
                                        <td align="center">{{$data['vip_price']}}</td>
                                        <td align="center">{{$data['goods_numbering']}}</td>
                                        <td align="center">
                                            <button type="button" class="view f-ib btn btn-primary btn-xs" data-id="{{$data['gid']}}" data-cid="{{$data['cat_id']}}" data-gid="{{$data['goods_id']}}" data-toggle="modal" data-target="#myView" data-name="{{$data['goods_name']}}">查看详情</button>
                                            <button type='button' class='edit f-ib btn btn-primary btn-xs' data-id="{{$data['gid']}}" data-cid="{{$data['cid']}}" data-gid="{{$data['goods_id']}}" data-toggle="modal" data-target="#myModal">编辑</button>
                                            <button type="button" class="del f-ib btn btn-danger btn-xs" data-id="{{$data['gid']}}">删除</button>
                                            <button type="button" class="advert f-ib btn btn-warning btn-xs" data-id="{{$data['gid']}}" data-gid="{{$data['goods_id']}}" data-toggle="modal">广告</button>

                                            <!-- Split button -->
                                            <!-- <div class="btn-group">
                                              <button type="button" class="btn btn-warning btn-xs" data-id="{{$data['gid']}}" data-gid="{{$data['goods_id']}}">广告</button>
                                              <button type="button" class="btn btn-warning dropdown-toggle btn-xs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-id="{{$data['gid']}}" data-gid="{{$data['goods_id']}}">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                              </button>
                                              <ul class="dropdown-menu">
                                                <li><a href="#">广告推送</a></li>
                                                <li role="separator" class="divider"></li>
                                                <li><a href="#">Separated link</a></li>
                                              </ul>
                                            </div> -->

                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="5" align="center">
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
                    <table class="table">
                        <tr>
                            <td align="right" width="25%">货品标签</td>
                            <td align="left" id="goodname"></td>
                        </tr>
                        <tr>
                            <td align="right">所属分类</td>
                            <td align="left" id="cat"></td>
                        </tr>
                        <tr>
                            <td align="right">所属商品</td>
                            <td align="left" id="good"></td>
                        </tr>
                        <tr>
                            <td align="right">市场价格</td>
                            <td align="left" id="market"></td>
                        </tr>
                        <tr>
                            <td align="right">进价</td>
                            <td align="left" id="cost"></td>
                        </tr>
                        <tr>
                            <td align="right">会员价</td>
                            <td align="left" id="vip"></td>
                        </tr>
                        <tr>
                            <td align="right">描述</td>
                            <td align="left" id="desc"></td>
                        </tr>
                        <tr>
                            <td align="right">产品图片</td>
                            <td align="left">
                                <a href="" id="goodpic" target="_blank">
                                    <img src="" width="100">
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">上架时间</td>
                            <td align="left" id="added"></td>
                        </tr>
                        <tr>
                            <td align="right">库存</td>
                            <td align="left" id="stock">
                            </td>
                        </tr>
                        <tr>
                            <td align="right">商品编号</td>
                            <td align="left" id="goodsnumbering"></td>
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
                    <h4 class="modal-title" id="myModalLabel">货品编辑</h4>
                </div>
                <div class="modal-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <h5 class="text-center">基本信息</h5>
                    <form role="form" class="form-horizontal" action="" method="post" id="updateform">
                        <input type="hidden" name="sid" id="sid" value="{{$sid}}">
                        <input type="hidden" name="_method" value="PUT">
                        <div class="form-group" id="goodscat">
                            <label class="col-sm-2 control-label">商品分类</label>
                            <!-- <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <select class="form-control" id="mainselect" name="mainselect" required>
                                        </select>
                                    </div>
                                    <div class="col-xs-4">
                                        <select class="form-control" id="midselect" name="midselect" required>
                                        </select>
                                        <input type="hidden" name="midhidden" id="midhidden" value="">
                                    </div>
                                </div>
                            </div>-->
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="name">商品名称</label>
                            <div class="col-sm-6">
                                <select class="form-control" id="name" name="name" required>
                                </select>
                            </div>
                        </div><!--end form-group-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="spetag">货品标签</label>
                            <div class="col-sm-6">
                                <input type="text" name="spetag" id="spetag" class="form-control" required placeholder="如：黄色32码" value="{{ old('spetag') }}"/>
                            </div>
                        </div><!--end form-group-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="marketprice">市场价</label>
                            <div class="col-sm-6">
                                <input type="text" name="marketprice" id="marketprice" class="form-control" required value="{{ old('marketprice') }}" />
                            </div>
                        </div><!--end form-group-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="costprice">成本价</label>
                            <div class="col-sm-6">
                                <input type="text" name="costpirce" id="costprice" class="form-control" value="{{ old('costpirce') }}" />
                            </div>
                        </div><!--end form-group-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="viprice">会员价</label>
                            <div class="col-sm-6">
                                <input type="text" name="viprice" id="viprice" class="form-control" required value="{{ old('viprice') }}" />
                            </div>
                        </div><!--end form-group-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="description">描述</label>
                            <div class="col-sm-6">
                                <textarea name="description" id="description" class="form-control" rows="5">{{ old('description') }}</textarea>
                            </div>
                        </div><!--end form-group-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">是否上架</label>
                            <div class="col-sm-6">
                                <label class="radio-inline">
                                    <input type="radio" name="status" value="1" id="onsale" />上架
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="status" value="0" id="notonsale" />暂不
                                </label>
                            </div>
                        </div><!--end form-group-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="numbering">商品编号</label>
                            <div class="col-sm-6">
                                <input type="text" name="numbering" id="numbering" class="form-control" value="{{ old('numbering') }}" required />
                            </div>
                        </div><!--end form-group-->
                        <div class="form-group text-center">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-3">
                                <button type="submit" class="btn btn-info">保存</button>
                            </div>
                        </div><!--end form-group text-center-->
                    </form>
                    <hr>
                    <h5 class="text-center">库存信息</h5>
                    <form>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <table class="table text-center">
                                    <thead>
                                    <tr>
                                        <th class="text-center col-sm-1">区域</th>
                                        <th class="text-center col-sm-1">货位</th>
                                        <th class="text-center col-sm-1">货架</th>
                                        <th class="text-center col-sm-1">库存数</th>
                                        <th class="text-center col-sm-1">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody id="stocktr">
                                    </tbody>
                                </table>
                            </div>
                            <div style="clear:both"></div>
                        </div>
                    </form>
                    <hr>
                    <h5 class="text-center">商品图片信息</h5>
                    <form role="form" class="form-horizontal" action="" id="formToUpdate" method="post" enctype="multipart/form-data">
                        <div id="method"></div>
                        <input type="hidden" name="gid" id="gid">
                        <div class="gal form-group">
                            <label for="pic" class="col-sm-2 control-label">商品图片<br><i>最多可上传五张</i></label>
                            <ul class="gallerys col-sm-10 list-inline">
                                <li class="template hidden">
                                    <div class="gallery text-center">
                                        <img src="" class="img">
                                    </div>
                                    <input type="file" name="file" class="pic">
                                </li>
                                <button type="button" class="goodpic addpic btn btn-default" title="继续添加图片" id="addforgood">+</button>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="activeFlag" value="treegood">
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
<script src="/admin/js/good.js"></script>
</body>
</html>
