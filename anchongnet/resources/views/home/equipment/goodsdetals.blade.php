<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>商品详情</title>
    <link rel="stylesheet" href="{{asset('home/css/goodsdetails.css')}}">
    <link rel="stylesheet" href="{{asset('home/css/top.css')}}">
    <script src="{{asset('home/js/jquery-3.1.0.min.js')}}"></script>
    <script src="{{asset('home/org/layer/layer.js')}}"></script>
</head>
<body>
@include('inc.home.top',['page'=>'<li><div class="shop-ioc">
            <a>购物车</a>
            <a><img src="../../../home/images/shebei/10.jpg" alt=""  style="width: 16px;height: 40px;margin-top: 0px;margin-left: 2px;"></a>
        </div></li>'])
<div class="header-center">
    <div class="header-main">
        <div class="logo">
            <a href="{{url('/')}}">
                <img src="{{asset('home/images/logo.jpg')}}"/>
            </a>
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
                @foreach($nav as $a)
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
         <div class="adress"><p>您的位置：首页>设备选购>视频监控</p></div>
        <div class="main">
            <div class="top-main">
                <div class="top-main-left">
                    <div class="mastermap"><img src="{{$img[0]->img_url}}" alt="" id="tail"></div>
                    <ul class="detailmap">
                        @foreach( $img as $i=>$k)
                            <li class="thumb"><img src="{{$k->thumb_url}}" alt=""></li>
                        @endforeach
                    </ul>
                </div>
                <div class="top-main-right">
                    <div class="goodstitle">
                        <h3 class="title">{{$data->title}}</h3>
                        <p>{{$data->desc}}</p>
                    </div>
                    <div class="goodsprice">
                        @if($price[0]->promotion_price == 0)
                        <p>价格：￥<i id="price" class="goods-price">{{$price[0]->market_price}}</i></p>
                        @else
                        <p><span>促销价：￥<i id="pro-price" class="goods-price">{{$price[0]->promotion_price}}</i></span></p>
                        @endif
                        {{--认证会员显示会员价格--}}
                        @if(Auth::user()['user_rank']==2)
                            <p><span>会员价：￥<i id="v-price">{{$price[0]->vip_price}}</i></span></p>
                            @if($price[0]->promotion_price == 0)
                            <script>
                            {{--商品价格类--}}
                                $('#price').removeAttr('class');
                                $('#v-price').attr('class','goods-price');
                            </script>
                            @elseif($price[0]->promotion_price >= $price[0]->vip_price)
                            <script>
                            {{--商品价格类--}}
                                $('#pro-price').removeAttr('class');
                                $('#v-price').attr('class','goods-price');
                            </script>
                            @endif
                        @else
                            <p><span>会员价：请认证后查看</span></p>
                        @endif
                        <div class="store"><a><img src="{{asset('home/images/shebei/clection.png')}}"></a><a>商品收藏</a></div>
                    </div>
                    <div class="goodstype">
                        <p class="yfkd">运费：北京 ∨ 快递:￥0</p>
                        <div class="goods-color">
                            <div class="colorcat"><span>{{$type[0]->name}}：</span></div>
                            <div class="suit">
                                <ul>
                                {{--属性1--}}
                                    @foreach($name as $p)
                                    <nobr><li class="type" style="text-overflow: ellipsis; overflow: hidden;">{{$p}}</li></nobr>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="goods-size">
                        {{--属性2--}}
                            @if(isset($type[1]))
                            <div class="sizecat"><span>{{$type[1]->name}}:</span></div>
                            <div class="sizetype">
                                <ul>
                                    @foreach($size as $b)
                                        @if(count($b))
                                    <li class="model">{{$b}}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </div>
                        {{--OEM--}}
                        @if(isset($oemvalue))
                        <div  class="suit">
                            <div class="nubcat"><span>OEM:</span></div>
                            @foreach($oemvalue as $v)
                            <li class="type oem" style="width: 80px;">{{$v}}</li>
                            @endforeach
                        </div>
                        @endif
                        {{--商品数量控制--}}
                        <div class="goods-nub">
                            <div class="nubcat"><span>数量:</span></div>
                            <div class="nubtype">
                               <img src="{{asset('home/images/shebei/22.jpg')}}" onclick="Minus()"><input id="goodsnum" type="text" value= 1><img src="{{asset('home/images/shebei/21.jpg')}}" onclick="Add()">
                            </div>
                        </div>

                         <div class="submit">
                             <a onclick="Buy()">立即购买</a><a onclick="addCart()">加入购物车</a>
                         </div>
                        <p id="tips">请您勾选你要选择的商品规格</p>
                    </div>
                </div>
            </div>

            <div class="main-down">
                <hr class="lins">
             <div class="recommond">
                 <ul>
                     <li><a href="">推荐产品</a></li>
                     <li><a href="">配套产品</a></li>
                 </ul>
             </div>
                <div class="detailpic">
                    <ul>
                        @foreach($related as $r)
                        <li>
                            <a href="{{url('equipment/show/'.$r->goods_id.'/'.$r->gid)}}">
                            <img src="{{$r->pic}}" alt=""></a>
                            <p>价格:{{$r->price}}</p>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="main-right">
           <div class="flagshop">
               <div class="flagshop-main">
               <div class="shop-title"><h4 class="shopname">{{$shop[0]->name}}</h4><a href="{{url('equipment/thirdshop/'.$shop[0]->sid)}}">进入店铺</a></div>
               <div class="shop-pic"><img src="{{$shop[0]->img}}" alt=""></div>
               <div class="shop-server">
                   <ul>
                   <li class="collect"><a>收藏</a></li>
                   <li style="margin-right: -5px;"><a href="">联系客服</a></li>
                   </ul>
               </div>
               </div>
           </div>
            <div class="see"><div class="seeline"><hr></div><p>看了又看</p><div class="seeline"><hr></div></div>

            <div class="flagpic"><a href="{{url('equipment/show/'.$hot[0]->goods_id.'/'.$hot[0]->gid)}}"><img src="{{$hot[0]->pic}}" alt=""></a>
                <div class="flagpic-price"><p>￥：{{$hot[0]->price}}</p></div>
            </div>
            @if(isset($hot[1]))
            <div class="flagpic" style="margin-top: 20px;"><a href="{{url('equipment/show/'.$hot[1]->goods_id.'/'.$hot[1]->gid)}}"><img src="{{$hot[1]->pic}}" alt=""></a>
                <div class="flagpic-price"><p>￥：{{$hot[1]->price}}</p></div>
            </div>
            @endif
        </div>
       <div style="clear: both"></div>
        <div class="introduction">
            <hr>
            <div class="introduction-list">
                <ul>
                    <li class="mainpic"><button>商品详情</button> </li>
                    <li class="param"><button>规格参数</button></li>
                    <li class="package"><button>相关资料</button></li>
                </ul>
            </div>
        </div>
        <div style="clear: both"></div>
        <hr>
          <div class="introductionpic">
              <img src=" {{$data->images}}" alt="" id="mainpic">
              <div id="param" style="display:none;">{!!$data->param!!}</div>
              <div id="package" style="display: none;"> {!! $data->package !!}</div>
          </div>
    </div>
</div>


@include('inc.home.footer')

<script src="{{asset('home/js/top.js')}}"></script>
<script src="{{asset('home/js/goodsdetail.js')}}"></script>
<script>
$(function () {
	//商品收藏
    $('.store').click(function () {
        var data = {'coll_id':'{{$price[0]->gid}}','coll_type':'1','_token':'{{csrf_token()}}'};
        $.post('/collect',data,function (msg) {
            layer.msg(msg.msg,{icon: 6});
        });
    });
	//商铺收藏
    $('.collect').click(function () {
        var data = {'coll_id':'{{$shop[0]->sid}}','coll_type':'2','_token':'{{csrf_token()}}'};
        $.post('/collect',data,function (msg) {
            layer.msg(msg.msg,{icon: 6});
        });
    })
})
/*
购物车添加
 */
function addCart() {
    var type   = $('#t-selected').attr('id');
    var model  = $('#m-selected').attr('id');
    var select = $('.sizetype ').is(':has(*)');
    //当商品存在属性2时,
    if(select){
        if(type == undefined || model == undefined){
            $('.goodstype').css('border','1px solid #f53745');
            $('#tips').css('display','block');//弹出消息
            return ;
        }else{
            $('.goodstype').css('border','none');
            $('#tips').css('display','none');
            var goods_type = $('#t-selected').text()+ ' ' + $('#m-selected').text();
        }
    }else{
        //当商品只存存在型号，且型号未选中时
        if(type == undefined){
            $('.goodstype').css('border','1px solid #f53745');
            $('#tips').css('display','block');
            return ;
        }else{
            $('.goodstype').css('border','none');
            $('#tips').css('display','none');
            var goods_type= $('#t-selected').text();
        }
    }
    //判断是否是会员价加入购物车的
    var promotion;
    if($('.goods-price').attr('id') == 'pro-price'){
        promotion=1;
    }else{
        promotion=0;
    }
    var goods_name = $('.title').text();
    var goods_num = $('#goodsnum').val();
    var goods_price = $('.goods-price').text();
    var goods_img = $('#tail').attr('src');
    var sid = {{$shop[0]->sid}};
    var sname =$('.shopname').text();
    var goods_id = {{$price[0]->goods_id}} ;
    var gid = {{$price[0]->gid}};
    //判断oem是否存在并赋值
    if($('#oem').attr('id') == undefined){
        var oem = null;
    }else{
        var oem = $('#oem').text();
    }
    var data = {
        'goods_name' :goods_name,
        'goods_num'  :goods_num,
        'goods_price':goods_price,
        'img':goods_img,
        'sid':sid,
        'sname':sname,
        'goods_id':goods_id,
        'promotion':promotion,
        'gid':gid,
        'goods_type':goods_type,
        '_token':'{{csrf_token()}}',
        'oem': oem
    };
    $.post('/cart',data,function (data) {
        layer.msg(data.msg);
    });
}
</script>
</body>
</html>
