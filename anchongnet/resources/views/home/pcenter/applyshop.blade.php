@extends('inc.home.pcenter.pcenter')
@section('info')
    <title>商铺申请</title>
    <link rel="stylesheet" type="text/css" href="home/css/applyshop.css">
    @endsection
    @section('content')

<div class="main">
    <div class="mainlf">
        <div class="topll">
            <img src="{{$msg->headpic}}" alt="">
            <p>{{$msg->nickname}}</p>
            <p>QQ：{{$msg->qq}}</p>
            <p>邮箱：{{$msg->email}}</p>
        </div>
        <div class="toppp">
            <ul>
                <hr>
                <li><a href="{{url('/adress')}}">地址管理</a></li>
                <hr>
                <li><a href="{{url('/applysp')}}">商铺申请</a></li>
                <hr>
                <li><a href="{{url('/honor')}}">会员认证</a></li>
                <hr>

            </ul>
        </div>
    </div>
    <div class="mainrg">
        <form action="{{url('/applysp/store')}}" method="post">
            {{csrf_field()}}
        <div class="daomain">
           <h4>商铺申请</h4>
        </div>
            @if(session('sucsses'))
                <div style="color: #f53745;font-size: 14px;margin-left: 100px;">{{session('sucsses')}}</div>
            @endif
            @if(count($errors)>0)
                <div class="mark" style="margin-left: 10px;">
                    @if(is_object($errors))
                        @foreach($errors->all() as $error)
                            <p style="padding-left: 100px;"> {{$error}}</p>
                        @endforeach
                    @else
                        <p>{{$errors}}</p>
                    @endif
                </div>
            @endif

            <div class="detail">
                <div id="container">
                		<div id="ossfile" style="display:none;width:300px"></div>
    					<span>店铺头像：</span><div id="selectfiles"><img width="140px" height="140px" src="/home/images/chat/logo_01.jpg"></div>
    					<a id="postfiles" href="javascript:void(0);" class='btn'>开始上传</a>
    					<input type="hidden" name="img" id="hhh">
    				</div>
    				<div id="container2">
                		<div id="ossfile2" style="display:none;width:300px"></div>
    					<span>品牌授权书：</span><div id="selectfiles2"><img width="140px" height="140px" src="/home/images/chat/logo_01.jpg"></div>
    					<a id="postfiles2" href="javascript:void(0);" class='btn'>开始上传</a>
    					<pre id="console"></pre>
    					<input type="hidden" name="authorization" id="hhh2">
    				</div>
                <li>
                    <span>店铺名称：</span><input type="text" required placeholder="老张的店" name="name">
                </li>
                <li>
                    <span>店铺介绍：</span><input type="text" required name="introduction">
                </li>
            </div>
            <div class="brandlist">
                <span>主营品牌：</span>
                <ul>
                    @foreach($brand as $b)
                   <nobr> <li style="overflow: hidden;text-overflow: ellipsis;width: 90px;"><input type="checkbox" name="brand[]" value="{{$b->brand_id}}hhh{{$b->brand_name}}"> {{$b->brand_name}}</li></nobr>
                    @endforeach
                </ul>
            </div>
            <div class="brandlist" >
                <span>主营类别：</span>
                <ul>
                    @foreach($category as $c)
                    <li><input type="checkbox" value="{{$c->cat_id}}hhh{{$c->cat_name}}" style="margin-top: 10px;" name="cate[]">{{$c->cat_name}}</li>
                    @endforeach
                </ul>
            </div>
            <div class="detail" style="margin-top: 0px;">
                <li>
                    <span>经营地点：</span><input name="premises" required type="text" value=""placeholder="北京 北京市 顺义区" >
                </li>
            </div>
            <div class="detail" style="margin-top: 0px;">
                <li>
                    <span>包邮价：</span><input name="free-price" required type="number" placeholder="5000" >
                </li>
            </div>
            <div class="detail" style="margin-top: 0px;">
                <li>
                    <span>运费：</span><input name="freight"  required type="number" placeholder="100" >
                </li>
            </div>
            <div class="detail" style="margin-top: 0px;">
                <li>
                    <span>客服：</span><input name="customer"  required type="number" placeholder="400400400" >
                </li>
            </div>
            <div style="clear: both;"></div>
        		<hr style="margin-left: 10px; margin-top: 30px;">
            <div class="tijiao"><button type="submit">提交</button></div>
        </form>
        </div>
    </div>
<div style="clear: both"></div>
<script type="text/javascript" src="/home/ossdirect/lib/plupload-2.1.2/js/plupload.full.min.js"></script>
<script type="text/javascript" src="/home/ossdirect/lib/plupload-2.1.2/js/i18n/zh_CN.js"></script>
<script type="text/javascript" src="/home/ossdirect/upload.js"></script>
<script type="text/javascript" src="/home/ossdirect/upload2.js"></script>
@endsection