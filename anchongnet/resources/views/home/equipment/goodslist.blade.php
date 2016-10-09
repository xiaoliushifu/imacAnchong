<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>商品列表</title>
    <link rel="stylesheet" href="{{asset('home/css/goodslist.css')}}">
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
            <a href="{{url('/')}}"><img src="{{asset('home/images/shebei/12.jpg')}}" alt=""></a>
        </div>
        <div class="search">
            <div class="searchbar">
                <input type="text" class="biaodan">
                <button type="button" class="btn">搜索</button>

            </div>

        </div>

    </div>
</div>
<div class="nav">
    <div class="navc">
        <div class="navcontent">
            <ul>
                <li><a href="{{url('/equipment')}}">首页</a></li>
                @foreach($navll as $a)
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
         <div class="adress"><p>您的位置：首页>设备选购><span>{{$eqlistaddress->cat_name}}</span></p></div>

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
        <div class="afterserver">
           <ul class="afterserver-list">
               <li class="promise" style="width: 180px;">安虫承诺</li>
               <li><a href=""><img src="{{asset('home/images/shebei/保.png')}}" alt="">正品保证</a></li>
               <li><img src="{{asset('home/images/shebei/正.png')}}" alt=""><a href="">正规发票</a></li>
               <li><img src="{{asset('home/images/shebei/定.png')}}" alt=""><a href="">定时送货</a></li>
               <li><img src="{{asset('home/images/shebei/退.png')}}" alt=""><a href="">退换无忧</a></li>
           </ul>
        </div>

            <ul class="rank">
                <li class="ranking" style="width: 180px;">排&nbsp;&nbsp;序</li>
                <li><a href="">全部</a></li>
                <li><a href="">销量</a></li>
                <li class="price"><a href="">价格</a><img src="{{asset('home/images/shebei/upp.png')}}" alt=""><img src="{{asset('home/images/shebei/don.png')}}" alt=""></li>

                <li style="width: 400px; float: right ;text-align: right;" class="pagmm">
                    <a href="
                    @if(isset($eqlistmain))
                    {{$eqlistmain->nextPageUrl()}}
                            @endif
                            @if(isset($det))
                    {{$det->nextPageUrl()}}
                            @endif
                            "><img src="{{asset('home/images/shebei/下一页.png')}}" alt=""></a>
                    <a href="
                    @if(isset($eqlistmain))
                    {{$eqlistmain->previousPageUrl()}}
                            @endif
                            @if(isset($det))
                    {{$det->previousPageUrl()}}
                            @endif
                            "><img src="{{asset('home/images/shebei/上一页.png')}}" alt=""></a>
                </li>
            </ul>

    </div>
</div>

<div class="maindetail">
    <div class="submaindetail">
        <div class="goodsdetail">
            <ul>
                 @if(isset($eqlistmain))
                @foreach( $eqlistmain as $t)
                <li>
                    <a href="{{url('equipment/show/'.$t->goods_id.'/'.$t->gid)}}"><img src="{{$t->pic}}" alt=""></a>
                    <nobr><p><a href="{{url('equipment/show/'.$t->goods_id.'/'.$t->gid)}}">{{$t->title}}</a></p></nobr>
                    <span class="vip">会员价：{{$t->vip_price}}</span><span class="common">价格：￥{{$t->price}}</span>
                </li>
                @endforeach
                @endif
                     @if(isset($det))
                    @foreach( $det as $d)
                        <li>
                            <a href="{{url('equipment/show/'.$d->goods_id.'/'.$d->gid)}}"><img src="{{$d->pic}}" alt=""></a>
                            <nobr><p><a href="{{url('equipment/show/'.$d->goods_id.'/'.$d->gid)}}">{{$d->title}}</a></p></nobr>
                            <span class="vip">会员价：{{$d->vip_price}}</span><span class="common">价格：￥{{$d->price}}</span>
                        </li>
                    @endforeach
                         @endif

            </ul>
        </div>



        <div class="paging" >
            <div class="">
                     @if(isset($eqlistmain))
                {{$eqlistmain->links()}}
                     @endif
                @if(isset($det))
                {{$det->links()}}
                @endif

                {{--&lt;<a href="#">下一页</a> <span>2</span><span>3</span><span>4</span><span>5</span><span>6</span><a href="#">上一页</a>&gt;--}}
            </div>
            <div class="paging-right">
                <form action="{{url('gopage/eqpage/'.$cat_id)}}" method="post">
                    {{csrf_field()}}
                <span>共有
                    @if(isset($eqlistmain))
                        {{$eqlistmain->lastpage()}}
                    @endif
                    @if(isset($det))
                        {{$det->lastpage()}}
                    @endif

                    页，去第 <input type="text" name="page"></span> <button type="submit">确定</button>
                </form>
            </div>
        </div>
    </div>
</div>


@include('inc.home.footer')
<script src="{{asset('home/js/top.js')}}"></script>

</body>
</html>