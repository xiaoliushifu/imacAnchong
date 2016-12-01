<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="wwwcctv" content="{{ csrf_token() }}">
    <title>商品列表</title>
    <link rel="stylesheet" href="{{asset('home/css/goodslist.css')}}">
    <link rel="stylesheet" href="{{asset('home/css/top.css')}}">
    <link rel="stylesheet" type="text/css" href="/home/css/suggestion.css">
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
        <form action="/equipment/gs">
        <div class="search">
            <div class="searchbar">
                <input type="text" class="biaodan" name="q" id="gover_search_key">
                <button type="submit" class="btn">搜索</button>
            </div>
            {{--提示框--}}
            <div class="search_suggest"  id="gov_search_suggest"><ul></ul></div>
        </div>
        </form>
    </div>
</div>
<div class="nav">
    <div class="navc">
        <div class="navcontent">
            <ul>
                <li><a href="{{url('/equipment')}}">首页</a></li>
                {{--八大类--}}
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
        <div class="server">
            <hr>
            <ul class="server-type">
                <li class="type-title" style="width:180px;"><span style="font-size: 18px;">品&nbsp;&nbsp;牌</span></li>
                <li><a href="#">探测监视</a></li>
                <li><a href="#">防护保障</a></li>
                <li><a href="#">探测报警</a></li>
                <li><a href="#">弱电工程</a></li>
                <li><a href="#">呼救器</a></li>
                <li><a href="#">楼宇对讲</a></li>
                <li><a href="#">快速通道</a></li>
                <li class="downmenue" style="width: 80px;height: 40px;float: right;font-size: 14px;color:#606060;"><span >展开<b class="caret"></b></span> </li>
            </ul>
            <ul class="server-type" style="display: none;">
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
                <li class="downmenue" style="width: 80px;height: 40px;float: right;font-size: 14px;color:#606060;"><span >展开<b class="caret"></b></span></li>
            </ul>
            <ul class="server-type" style="display: none">
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
                <li class="downmenue" style="width: 80px;height: 40px;float: right;font-size: 14px;color:#606060;"><span >展开<b class="caret"></b></span></li>
            </ul>
            <ul class="server-type" style="display: none">
                <li><a href="#">探测监视</a></li>
                <li><a href="#">防护保障</a></li>
                <li><a href="#">探测报警</a></li>
                <li><a href="#">弱电工程</a></li>
                <li><a href="#">呼救器</a></li>
                <li><a href="#">楼宇对讲</a></li>
                <li><a href="#">快速通道</a></li>
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
                    <a href="{{isset($eqlistmain)?$eqlistmain->nextPageUrl():''}}"><img src="{{asset('home/images/shebei/下一页.png')}}" alt=""></a>
                    <a href="{{isset($eqlistmain)?$eqlistmain->previousPageUrl():''}}"><img src="{{asset('home/images/shebei/上一页.png')}}" alt=""></a>
                </li>
            </ul>
    </div>
</div>
<div class="maindetail">
    <div class="submaindetail">
        <div class="goodsdetail">
            <ul>
            			{{--货品列表--}}
                    @foreach($eqlistmain as $t)
                    <li>
                        <a href="{{url('equipment/show/'.$t->goods_id.'/'.$t->gid)}}"><img src="{{$t->pic}}" alt=""></a>
                        <nobr><p><a href="{{url('equipment/show/'.$t->goods_id.'/'.$t->gid)}}">{{$t->title}}</a></p></nobr>
                        @if(isset($user) && $user->certification == "3")
                            <span class="vip">会员价：{{$t->vip_price}}</span>
                            <span class="common">价格：￥{{$t->price}}</span>
                        @else
                            <span class="common">会员价：请认证后查看</span>
                            <span class="vip">价格：￥{{$t->price}}</span>
                        @endif
                    </li>
                    @endforeach
            </ul>
        </div>
        <div class="paging" >
            <div class="">{{$eqlistmain->appends(['q'=>$eqlistaddress->cat_name])->links()}}</div>
            <div class="paging-right">
                <form action="{{url('gopage/eqpage/'.$cat_id)}}" method="post">
                {{csrf_field()}}
                <span>共有{{$eqlistmain->lastpage()}}页，去第 <input type="text" name="page"></span> <button type="submit">确定</button>
                </form>
            </div>
        </div>
    </div>
</div>
@include('inc.home.footer')
<script src="{{asset('home/js/top.js')}}"></script>
{{--搜索--}}
<script src="/home/js/search.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	//展开
    $(".caret").click(function(){
        $(this).parents('ul').next().slideToggle("slow");
    });
});
</script>
</body>
</html>