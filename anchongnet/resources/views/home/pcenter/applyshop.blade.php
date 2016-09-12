@extends('inc.home.pcenter.pcenter')
@section('info')
    <title>商铺申请</title>
    <link rel="stylesheet" type="text/css" href="home/css/applyshop.css">
    @endsection
    @section('content')

<div class="main">
    <div class="mainlf">
        <div class="topll">
            <img src="home/images/mine/61.jpg" alt="">
            <p>风信子</p>
            <p>QQ：888888888888</p>
            <p>邮箱：88888888888@qq.com</p>
        </div>
        <div class="toppp">
            <ul>
                <hr>
                <li><a href="{{url('/adress')}}">地址管理</a></li>
                <hr>
                <li><a href="{{url('/applysp')}}">商铺申请</a></li>
                <hr>
                <li><a href="{{url('/honor')}}">商家认证</a></li>
                <hr>

            </ul>
        </div>
    </div>
    <div class="mainrg">
        <form action="" method="">
        <div class=" daomain">
           <h4>商家认证</h4>
        </div>
            <div class="detail">
                <div class="papers">
                    <span>上传证件：</span><div class="papers-title"><img src="home/images/mine/35.jpg" alt=""></div>
                </div>
                <li>
                    <span>店铺名称：</span><input type="text" value="叶子的店" onfocus="javascript:if(this.value=='叶子的店')this.value='';">
                </li>
                    <li>
                        <span>店铺介绍：</span><input type="text" value="请输入店铺名字" onfocus="javascript:if(this.value=='请输入店铺名字')this.value='';">
                    </li>
                    <li>
                    <span>店铺介绍：</span><input type="text" value="一家专治心病的店"onfocus="javascript:if(this.value=='一家专治心病的店')this.value='';">
                </li>
            </div>
                <div class="brandlist">
                    <span>主营品牌：</span>
                    <ul>
                        <li><img src="home/images/mine/check.png" alt=""> 中控科技</li>
                        <li><img src="home/images/mine/check.png" alt="">多瑞电子</li>
                        <li><img src="home/images/mine/check.png" alt="">中控科技</li>
                        <li><img src="home/images/mine/check.png" alt="">兰德华</li>
                        <li><img src="home/images/mine/check.png" alt="">京华兴</li>
                        <li><img src="home/images/mine/check.png" alt="">君顺</li>
                        <li><img src="home/images/mine/check.png" alt="">露台交通</li>
                        <li><img src="home/images/mine/check.png" alt="">中控科技</li>
                        <li><img src="home/images/mine/check.png" alt="">多瑞电子</li>
                        <li><img src="home/images/mine/check.png" alt="">中控科技</li>
                        <li><img src="home/images/mine/check.png" alt="">兰德华</li>
                        <li><img src="home/images/mine/check.png" alt="">京华兴</li>
                        <li><img src="home/images/mine/check.png" alt="">君顺</li>
                        <li><img src="home/images/mine/check.png" alt="">露台交通</li><li><img src="home/images/mine/check.png" alt="">中控科技</li>
                        <li><img src="home/images/mine/check.png" alt="">多瑞电子</li>
                        <li><img src="home/images/mine/check.png" alt="">中控科技</li>
                        <li><img src="home/images/mine/check.png" alt="">兰德华</li>
                        <li><img src="home/images/mine/check.png" alt="">京华兴</li>
                        <li><img src="home/images/mine/check.png" alt="">君顺</li>
                        <li><img src="home/images/mine/check.png" alt="">露台交通</li>
                    </ul>
                </div>
            <div class="brandlist" style="height: 40px;">
                <span>主营类别：</span>
                <ul>
                    <li><img src="home/images/mine/check.png" alt="">智能门禁</li>
                    <li><img src="home/images/mine/check.png" alt="">视频监控</li>
                    <li><img src="home/images/mine/check.png" alt="">探测报警</li>
                    <li><img src="home/images/mine/check.png" alt="">巡更巡检</li>
                    <li><img src="home/images/mine/check.png" alt="">停车管理</li>
                    <li><img src="home/images/mine/check.png" alt="">智能消费</li>
                    <li><img src="home/images/mine/check.png" alt="">安防配套</li>

                </ul>
            </div>
            <div class="detail" style="margin-top: 0px;">
                <li>
                    <span>经营地点：</span><input type="text" value="山西省大同市"onfocus="javascript:if(this.value=='山西省大同市')this.value='';"><div class="caret"></div>
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
