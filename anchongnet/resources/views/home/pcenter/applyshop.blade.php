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
        <div class=" daomain">
           <h4>商家认证</h4>
        </div>
            <div class="detail">
                <div class="papers">
                    <span>上传证件：</span><div class="papers-title"><img src="home/images/mine/35.jpg" alt=""></div>
                </div>
                <li>
                    <span>店铺名称：</span><input type="text" value="" placeholder="叶子的店" name="name">
                </li>
                    <li>
                        <span>店铺介绍：</span><input type="text" value="" placeholder="请输入店铺名字" name="introduction">
                    </li>

            </div>
                <div class="brandlist">
                    <span>主营品牌：</span>
                    <ul>
                        @foreach($brand as $b)
                       <nobr> <li style="overflow: hidden;text-overflow: ellipsis;width: 90px;"><input type="checkbox" name="brand[]" value="{{$b->brand_id}}" onclick="jqchk()"> {{$b->brand_name}}</li></nobr>
                        @endforeach
                    </ul>

                </div>
            <div class="brandlist" >
                <span>主营类别：</span>
                <ul>
                    @foreach($category as $c)
                    <li><input type="checkbox" value="{{$c->cat_id}}" style="margin-top: 10px;" name="cate[]" onclick="jqchk()">{{$c->cat_name}}</li>
                    @endforeach

                </ul>
            </div>
            <div class="detail" style="margin-top: 0px;">
                <li>
                    <span>经营地点：</span><input name="premises" type="text" value=""placeholder="山西省大同市" ><div class="caret"></div>
                </li>
            </div>


            <div style="clear: both;"></div>
        <hr style="margin-left: 10px; margin-top: 60px;">

            <div class="tijiao"><button type="submit">提交</button></div>
        </form>
        </div>

    </div>


    </div>
<div style="clear: both"></div>
@endsection
