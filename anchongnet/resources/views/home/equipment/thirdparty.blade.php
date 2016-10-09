<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>第三方商城</title>
    <link rel="stylesheet" href="/home/css/thirdparty.css">
    <link rel="stylesheet" href="{{asset('home/css/top.css')}}">
    <script src="{{asset('home/js/jquery-3.1.0.min.js')}}"></script>
</head>
<body>
@include('inc.home.top',['page'=>' <li><div class="shop-ioc">
            <a href="">购物车</a>
            <a href=""><img src="../../home/images/shebei/10.jpg" alt=""  style="width: 16px;height: 40px;margin-top: 0px;margin-left: 2px;"></a>
        </div></li>'])
<div class="header-center">
    <div class="header-main">
        <div class="logo">
            <a href="{{url('/')}}"><img src="{{asset('../home/images/shebei/12.jpg')}}" alt=""></a>
        </div>
        <div class="search">
            <div class="searchbar">
                <input type="text" class="biaodan">
                <button type="button" class="btn">搜索</button>
                <li><a href="">搜本店</a></li>
            </div>

        </div>
    </div>
</div>
<div class="ad">
    <img src="{{asset('../home/images/shebei/41.jpg')}}" alt="">
    <li><a href="">收藏</a></li>
</div>
<div class="nav">
    <div class="navc">
        <div class="navcontent">
            <ul>
                <li><a href="{{url('/equipment')}}">首页</a></li>
                @foreach($navthird as $a)
                    <li><a href="{{url('equipment/list/'.$a->cat_id)}}">{{$a->cat_name}}</a></li>
                @endforeach
            </ul>
        </div>

    </div>

</div>
<div style="clear: both"></div>
<hr class="nav-underline">

<div class="centermain">
    <div class="submain">
         <div class="adress"><p>您的位置：首页>设备选购><span>门禁监控</span></p></div>

        <script>
            $(document).ready(function(){
                $("#flip").click(function(){
                    $("#yy").slideToggle("slow");
                });
            });
        </script>
        <div class="server">
            <hr>
            <ul class="server-type">
                <li class="type-title" style="width:180px;;"><span style="font-size: 18px;">品&nbsp;&nbsp;牌</span></li>
                <li><a href="#">探测监视</a></li>
                <li><a href="#">防护保障</a></li>
                <li><a href="#">探测报警</a></li>
                <li><a href="#">弱电工程</a></li>
                <li><a href="#">呼救器</a></li>
                <li><a href="#">楼宇对讲</a></li>
                <li><a href="#">快速通道</a></li>
                <li class="downmenue" style="width: 80px;height: 40px;float: right;font-size: 14px;color:#606060;"><span  id="flip" >展开 <b class="caret"></b></span> </li>
            </ul>
            <ul class="server-type" id="yy" style="display: none;">
                <li><a href="#">按时打算</a></li>
                <li><a href="#">探测监视</a></li>
                <li><a href="#">防护保障</a></li>
                <li><a href="#">探测报警</a></li>
                <li><a href="#">弱电工程</a></li>
                <li><a href="#">呼救器</a></li>
                <li><a href="#">楼宇对讲</a></li>
                <li ><a href="#">快速通道</a></li>
                <li><a href="#">楼宇对讲</a></li>
                <li ><a href="#">快速通道</a></li>
            </ul>

            <ul class="server-type">
                <li class="type-title-1" style="width: 180px;"><span  style="font-size: 18px;">种&nbsp;&nbsp;类</span></li>
                <li><a href="#">北京市</a></li>
                <li><a href="#">上海市</a></li>
                <li><a href="#">武汉市</a></li>
                <li><a href="#">保定市</a></li>
                <li><a href="#">石家庄市</a></li>
                <li><a href="#">衡水市</a></li>
                <li><a href="#">邢台市</a></li>
                <li class="downmenue" style="width: 80px;height: 40px;float: right;font-size: 14px;color:#606060;"><span  id="show" >展开 <b class="caret"></b></span></li>
            </ul>
            <script>
                $(document).ready(function(){
                    $("#show").click(function(){
                        $("#adress").slideToggle("slow");
                    });
                });
            </script>

            <ul class="server-type" id="adress" style="display: none">
                <li><a href="#">北京市</a></li>
                <li><a href="#">上海市</a></li>
                <li><a href="#">武汉市</a></li>
                <li><a href="#">保定市</a></li>
                <li><a href="#">石家庄市</a></li>
                <li><a href="#">衡水市</a></li>
                <li><a href="#">邢台市</a></li>
                <li><a href="#">北京市</a></li>
                <li><a href="#">上海市</a></li>
                <li><a href="#">武汉市</a></li>
            </ul>
            <ul class="server-type">
                <li class="type-title" style="width:180px;;"><span style="font-size: 18px;">筛&nbsp;&nbsp;选</span></li>
                <li><a href="#">探测监视</a></li>
                <li><a href="#">防护保障</a></li>
                <li><a href="#">探测报警</a></li>
                <li><a href="#">弱电工程</a></li>
                <li><a href="#">呼救器</a></li>
                <li><a href="#">楼宇对讲</a></li>
                <li><a href="#">快速通道</a></li>
                <li class="downmenue" style="width: 80px;height: 40px;float: right;font-size: 14px;color:#606060;"><span  id="" >展开 <b class="caret"></b></span> </li>
            </ul>
        </div>

            <ul class="rank">
                <li class="ranking" style="width: 180px;">排&nbsp;&nbsp;序</li>
                <li><a href="">全部</a></li>
                <li><a href="">销量</a></li>
                <li class="price"><a href="">价格</a><img src="{{asset('../home/images/shebei/upp.png')}}" alt=""><img src="{{asset('../home/images/shebei/don.png')}}" alt=""></li>

                <li style="width: 400px; float: right ;text-align: right;" class="pagmm">
                    <a href="{{$thirdlist->nextPageUrl()}}"><img src="{{asset('../home/images/shebei/下一页.png')}}" alt=""></a>
                    <a href="{{$thirdlist->previousPageUrl()}}"><img src="{{asset('../home/images/shebei/上一页.png')}}" alt=""></a>
                </li>
            </ul>

    </div>
</div>

<div class="maindetail">
    <div class="submaindetail">
        <div class="goodsdetail">
            <ul>
                @foreach($thirdlist as $d)
                <li>
                    <a href="{{url('equipment/show/'.$d->goods_id.'/'.$d->gid)}}"><img src="{{$d->pic}}" alt=""></a>
                    <a href="{{url('equipment/show/'.$d->goods_id.'/'.$d->gid)}}"><nobr><p>{{$d->title}}</p></nobr></a>
                    <span class="vip">会员价：￥{{$d->vip_price}}</span><span class="common">价格：￥{{$d->price}}</span>
                </li>
                @endforeach

            </ul>
        </div>



        <div class="paging" >
            <div class="">
                {{$thirdlist->links()}}

            </div>
            <div class="paging-right">
                <span>共有{{$thirdlist->lastpage()}}页，去第 <input type="text"></span> <button type="submit">确定</button>
            </div>
        </div>
    </div>
</div>


@include('inc.home.footer')

<script src="{{asset('home/js/top.js')}}"></script>
</body>
</html>