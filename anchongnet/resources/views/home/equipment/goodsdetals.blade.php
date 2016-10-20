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
@include('inc.home.top',['page'=>' <li><div class="shop-ioc">
            <a href="">购物车</a>
            <a href=""><img src="../../../home/images/shebei/10.jpg" alt=""  style="width: 16px;height: 40px;margin-top: 0px;margin-left: 2px;"></a>
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
                            <li class="thumb{{$i}}"><img src="{{$k->thumb_url}}" alt=""></li>
                            <script type="text/javascript">
                                $(document).ready(function(){
                                    var i = " .thumb{{$i}}";
                                    $(i).click(function(){
                                        $("#tail").attr("src","{{$k->thumb_url}}");
                                    });
                                });
                            </script>
                        @endforeach
                    </ul>
                </div>
                <div class="top-main-right">
                    <div class="goodstitle">
                        <h3 class="title">{{$data->title}}</h3>
                        <p>{{$data->desc}}</p>
                    </div>
                    <div class="goodsprice">
                        <p>价格：￥<i id="price" class="goods-price">{{$price[0]->price}}</i></p>
                        {{--认证会员显示会员价格--}}
                        @if(count($goodsauth) == 0)
                        <p><span>会员价：请认证后查看</span></p>
                        @else
                            @for($i=0;$i<count($goodsauth);$i++)
                                @if($goodsauth[$i]->auth_status == "3")
                                    <p><span>会员价：￥<i id="v-price">{{$price[0]->vip_price}}</i></span></p>
                                    <script>
                                        $('#price').removeAttr('class');
                                        $('#v-price').attr('class','goods-price');
                                    </script>
                                    @else
                                    <p><span>会员价：请认证后查看</span></p>
                                @endif
                            @endfor
                        @endif
                        <div class="store"><a href=""><img src="{{asset('home/images/shebei/clection.png')}}" alt=""></a><a href="">商品收藏</a></div>
                    </div>
                    <form action="" method="">
                    <div class="goodstype">
                        <p class="yfkd">运费：北京 ∨ 快递:￥0</p>
                        <div class="goods-color">
                            <div class="colorcat"><span>{{$type[0]->name}}：</span></div>
                            <div class="suit">
                                <ul>
                                    @foreach($name as $p)
                                    <nobr><li class="type" style="text-overflow: ellipsis;overflow: hidden;">{{$p}}</li></nobr>
                                    @endforeach

                                </ul>
                            </div>
                        </div>
                        <div class="goods-size">
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
                        @if(isset($oemvalue))
                        <div  class="suit">
                            <div class="nubcat"><span>OEM:</span></div>
                            @foreach($oemvalue as $v)
                            <li class="type" style="width: 80px;">{{$v}}</li>
                                @endforeach
                        </div>
                        @endif
                        <div class="goods-nub">
                            <div class="nubcat"><span>数量:</span></div>
                            <div class="nubtype">
                               <img src="{{asset('home/images/shebei/22.jpg')}}" onclick="Minus()"><input id="goodsnum" type="text" value= 1><img src="{{asset('home/images/shebei/21.jpg')}}" onclick="Add()">
                            </div>
                        </div>

                         <div class="submit">
                             <a onclick="Buy()">立即购买</a><a onclick="addCart()">加入购物车</a>
                         </div>
                    </div>
                    </form>
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
                   <li><a class="collect">收藏</a></li>
                       @if(isset($msg))
                           {{--店铺收藏--}}
                           <script>
                               $(function () {
                                   $('.collect').click(function () {
                                       var data = {'users_id':'{{$msg->users_id}}','coll_id':'{{$shop[0]->sid}}','coll_type':'2','_token':'{{csrf_token()}}'};
                                       $.post('/collecehop',data,function (msg) {
                                           layer.msg(msg.msg,{icon: 6});
                                       });
                                   })
                               })
                           </script>
                           @else
                           <script>
                               $('.collect').click(function () {
                                   layer.msg('登陆后才可以收藏哦',{icon: 5})
                               });
                           </script>
                       @endif
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
    /*
    购物车添加
     */
    function addCart() {
        //获取数据
        var goods_name = $('.title').text();
        var goods_num = $('#goodsnum').val();
        var goods_price = $('.goods-price').text();
        var goods_img = $('#tail').attr('src');
        var sid = {{$shop[0]->sid}};
        var sname =$('.shopname').text();
        var goods_id = {{$price[0]->goods_id}} ;
        var gid = {{$price[0]->gid}};
        //判断是否选取类型及样式
        var classname = $('.ac-selected').attr('class');
    }
</script>
</body>
</html>
