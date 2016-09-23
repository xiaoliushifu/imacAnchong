<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>商品详情</title>
    <link rel="stylesheet" href="{{asset('home/css/goodsdetails.css')}}">
    <script src="{{asset('home/js/jquery-3.1.0.min.js')}}"></script>
    <script src="{{asset('home/js/goodsdetail.js')}}"></script>
</head>
<body>
<div class="nav-top">
    <div class="centerbar">

        <div class="navmain">
            <ul>
                <li>邮箱：www.@anchong.net</li>
                <li><div class="shop-ioc">
                    <a href="">购物车</a>
                    <a href=""><img src="{{asset('home/images/shebei/10.jpg')}}" alt=""  style="width: 16px;height: 40px;margin-top: 0px;margin-left: 2px;"></a>
                </div></li>
                <li>垂询电话:0317-8155026</li>
                <li><img src="{{asset('home/images/shebei/6.jpg')}}" alt=""></li>
                <li style="padding-left: 10px;"><a href="#">风信子<b class="caret"></b></a></li>
            </ul>
        </div>
    </div>
</div>
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
                        <h3>{{$data->title}}.</h3>
                        <p>{{$data->desc}}</p>
                    </div>
                    <div class="goodsprice">
                        <p>价格：￥{{$price[0]->price}}</p>
                        <p><span>会员价：￥{{$price[0]->vip_price}}</span></p>
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
                                    <li><span>{{$p}}</span></li>
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
                                    <li><span>{{$b}}</span></li>
                                    @endforeach

                                </ul>
                            </div>
                            @endif
                        </div>
                        <div class="goods-nub">
                            <div class="nubcat"><span>数量:</span></div>
                            <div class="nubtype">
                               <img src="{{asset('home/images/shebei/22.jpg')}}" alt=""><input type="text"><img src="{{asset('home/images/shebei/21.jpg')}}" alt="">

                            </div>
                        </div>
                         <div class="submit">
                             <button type="submit">立即购买</button><button type="submit">加入购物车</button>
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
               <div class="shop-title"><h4>{{$shop[0]->name}}</h4><a href="{{url('equipment/thirdshop/'.$shop[0]->sid)}}">进入店铺</a></div>
               <div class="shop-pic"><img src="{{$shop[0]->img}}" alt=""></div>

               <div class="shop-server">
                   <ul>
                   <li><a href="">收藏</a></li>
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














<div class="foottop">
    <div class="foottop-1">
        <div class="foottoplf">
            <div class="link"><h4>友情链接</h4>
                <hr>
            </div>
            <ul>
                <li>
                    <p><a href="#">中国安防行业网</a></p>
                    <p><a href="#">华强安防网</a></p>
                    <p><a href="#">中国安防展览网</a></p>
                    <p><a href="#">安防英才网</a></p>
                </li>
                <li>
                    <p><a href="#">智能交通网</a></p>
                    <p><a href="#">中国智能化</a></p>
                    <p><a href="#">中关村在线</a></p>
                    <p><a href="#">教育装备采购网</a></p>
                </li>
                <li>
                    <p><a href="#">中国贸易网</a></p>
                    <p><a href="#">华强电子网</a></p>
                    <p><a href="#">研究报告中国测控网</a></p>
                    <p><a href="#">五金机电网</a></p>
                </li>
                <li>
                    <p><a href="#">中国安防展览网</a></p>
                    <p><a href="#">民营企业网</a></p>
                    <p><a href="#">中国航空新闻网</a></p>
                    <p><a href="#">北极星电力网</a></p>
                </li>
            </ul>

        </div>
        <div class="foottoprg">
            <div class="rqcode-app" >
                <h4>下载安虫app客户端</h4>
                <img src="{{asset('home/images/shebei/1.jpg')}}">
            </div>
            <div class="rqcode-wx">
                <h4>安虫微信订阅号</h4>
                <img src="{{asset('home/images/shebei/2.jpg')}}">
            </div>

        </div>
    </div>
</div>
<hr class="downline">

<div class="footdown">
    <div class="footdown-1">


        <div class="about">
            <p><a href="#">关于安虫</a><span>|</span>
                <a href="#">联系我们</a><span>|</span>
                <a href="#">帮助中心</a><span>|</span>
                <a href="#">服务网点</a><span>|</span>
                <a href="#">法律声明</a><span>|</span>
                客服热线：400-888-888

            </p>
            <p>Copyright©&nbsp;北京安虫版权所有&nbsp;anchong.net</p>
            <p>京ICP备111111号&nbsp;<span>|</span>&nbsp;出版物经营许可证</p>

        </div>

    </div>
</div>



</body>
</html>
