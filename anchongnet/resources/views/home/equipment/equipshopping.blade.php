<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="wwwcctv" content="{{ csrf_token() }}">
    <title>设备选购</title>
    <link rel="stylesheet" href="home/css/equipshopping.css">
    <link rel="stylesheet" href="home/css/top.css">
    <link rel="stylesheet" type="text/css" href="home/css/suggestion.css">
</head>
<body>
@include('inc.home.top',['page'=>' <li><div class="shop-ioc">
            <a href="">购物车</a>
            <a href=""><img src="home/images/shebei/10.jpg" alt=""  style="width: 16px;height: 40px;margin-top: 0px;margin-left: 2px;"></a>
        </div></li>'])

<div class="header-center">
    <div class="header-main">
        <div class="logo">
            <a href="{{url('/')}}">
                <img src="home/images/logo.jpg"/>
            </a>
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
                <li><a href="#">首页</a></li>
                @foreach($nav as $a)
                    <li><a href="{{url('equipment/list/'.$a->cat_id)}}">{{$a->cat_name}}</a></li>
                @endforeach
                {{--<li><a href="#">视频监控</a></li>--}}
                {{--<li><a href="#">探测报告</a></li>--}}
                {{--<li><a href="#">巡更巡检</a></li>--}}
                {{--<li><a href="#">停车管理</a></li>--}}
                {{--<li><a href="#">楼宇对讲</a></li>--}}
                {{--<li><a href="#">智能消费</a></li>--}}
                {{--<li><a href="#">安防配套</a></li>--}}
            </ul>
        </div>

    </div>

</div>
<div style="clear: both"></div>
<hr class="nav-underline">

<div class="centermain">
    <div class="submain">

        <div class="main">
            <div class="main-left">
                <a href=""><img src="home/images/shebei/42.jpg" alt=""></a>
            </div>
            <div class="main-right">
               <ul>
                   <li>
                       <a href=""><img src="home/images/shebei/43.jpg" alt=""></a>
                   </li>
                   <li>
                       <a href=""><img src="home/images/shebei/44.jpg" alt=""></a>
                   </li>
                   <li>
                       <a href=""><img src="home/images/shebei/45.jpg" alt=""></a>
                   </li>
               </ul>
            </div>
        </div>
           <div class="goldshop">
                <p>金牌店铺</p>
           </div>
        <div class="goldshoplist">
            @foreach($brand as $b)
            <li><a href=""><img src="{{$b->brand_logo}}" alt=""></a></li>
            @endforeach
            {{--<li><a href=""><img src="home/images/shebei/48.jpg" alt=""></a></li>--}}
            {{--<li><a href=""><img src="home/images/shebei/49.jpg" alt=""></a></li>--}}
            {{--<li style="border-right: 1px #9b9b9b solid;"><a href=""><img src="home/images/shebei/50.jpg" alt=""></a></li>--}}
        </div>
        <div style="clear:both;"></div>
        <div class="hotgoods">
            <p>热卖单品</p>
        </div>
          <div class="hotlist">
              <ul class="hotlist0">
                  <li class="hotlist1"><a href=""><img src="home/images/shebei/51.jpg" alt=""></a></li>
                  <li class="hotlist2">
                      <a href=""><img src="home/images/shebei/53.jpg" alt=""></a>
                      <a href=""><img src="home/images/shebei/53.jpg" alt="" style="margin-top: 10px;"></a>
                  </li>
                  <li class="hotlist3"><a href=""><img src="home/images/shebei/52.jpg" alt=""></a></li>
                  <li class="hotlist4">
                      <a href=""><img src="home/images/shebei/53.jpg" alt=""></a>
                      <a href=""><img src="home/images/shebei/53.jpg" alt=""  style="margin-top: 10px;"></a>
                  </li>
              </ul>
          </div>

        <div class="adcenter">
            <a href=""><img src="home/images/shebei/54.jpg" alt=""></a>
        </div>
        <div class="newgoods">
            <p>最新上架</p>
        </div>
        <div class="newpic">
            <li><a href=""><img src="home/images/shebei/55.jpg" alt=""></a></li>
            <li><a href=""><img src="home/images/shebei/56.jpg" alt=""></a></li>
            <li><a href=""><img src="home/images/shebei/57.jpg" alt=""></a></li>
            <li><a href=""><img src="home/images/shebei/58.jpg" alt=""></a></li>
        </div>
        <div class="maingoods">
            <div class="submaingoods">
                <div class="maingoods-title"><span>F1</span><h3>智能门禁</h3></div>
                <div class="maingoods-nav">
                    <ul>
                        @foreach($nav1 as $q)
                        <li><a href="{{url('equipment/list/'.$q->cat_id)}}">{{$q->cat_name}}</a></li>
                        @endforeach

                        <li><a href="">更多</a></li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="maingoods-list">
                <div class="maingoods-one">
                    <img src="" alt="">
                    <p>
                        @foreach($one as $o)
                        <a href="{{url('equipment/list/'.$o->cat_id)}}">{{$o->cat_name}}</a><span>|</span>
                        @endforeach
                    </p>

                </div>
                <div class="maingoods-two"><img src="home/images/shebei/60.jpg" alt=""></div>
                <div class="maingoods-three">
                    <img src="home/images/shebei/61.jpg" alt="" style=" box-shadow: 0px 0px 10px 5px #d8d8d8;">
                    <img src="home/images/shebei/61.jpg" alt="">

                </div>
            </div>
        </div>

        <div class="centergoods">
            <div class="subcentergoods">
                <div class="centergoods-title"><span>F2</span><h3>视频监控</h3></div>
                <div class="centergoods-nav">
                    <ul>
                        @foreach($nav2 as $w)
                        <li><a href="{{url('equipment/list/'.$w->cat_id)}}">{{$w->cat_name}}</a></li>
                        @endforeach


                        <li><a href="">更多</a></li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="centergoods-list">
                <div class="centerlist-one">
                    <a href=""><img src="home/images/shebei/62.jpg" alt=""></a>
                    <div class="centerlist-title">
                        <p>
                            @foreach($two as $e)
                            <a href="{{url('equipment/list/'.$e->cat_id)}}">{{$e->cat_name}}</a><span>|</span>
                            @endforeach
                        </p>
                    </div>
                </div>
                <div class="centerlist-two">
                    <a href=""><img src="home/images/shebei/63.jpg" alt=""></a>
                    <a href=""><img src="home/images/shebei/64.jpg" alt="" style="margin-top: 10px;  box-shadow: 0px -5px 5px 5px #d8d8d8;"></a>
                </div>
                <div class="centerlist-three">
                    <a href=""><img src="home/images/shebei/65.jpg" alt=""></a>
                </div>
                <div class="centerlist-four">
                    <a href=""><img src="home/images/shebei/66.jpg" alt=""></a>
                    <a href=""><img src="home/images/shebei/67.jpg" alt=""></a>
                </div>
            </div>
        </div>

        <div class="maingoods">
            <div class="submaingoods">
                <div class="maingoods-title"><span>F3</span><h3>探测报警</h3></div>
                <div class="maingoods-nav"style="width: 480px;">
                    <ul>
                        @foreach($nav3 as $r)
                        <li><a href="{{url('equipment/list/'.$r->cat_id)}}">{{$r->cat_name}}</a></li>
                        @endforeach

                        <li><a href="">更多</a></li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="maingoods-list">
                <div class="maingoods-one">
                    <img src="home/images/shebei/59.jpg" alt="">
                    <p>
                        @foreach($three as $t)
						<a href="{{url('equipment/list/'.$t->cat_id)}}">{{$t->cat_name}}</a><span>|</span>
                        @endforeach
                    </p>
                </div>
                <div class="maingoods-two"><img src="home/images/shebei/60.jpg" alt=""></div>
                <div class="maingoods-three">
                    <img src="home/images/shebei/61.jpg" alt="" style=" box-shadow: 0px 0px 10px 5px #d8d8d8;">
                    <img src="home/images/shebei/61.jpg" alt="">

                </div>
            </div>
        </div>

        <div class="centergoods">
            <div class="subcentergoods">
                <div class="centergoods-title"><span>F4</span><h3>巡更巡检</h3></div>
                <div class="centergoods-nav" style="width: 300px;">
                    <ul>
                        @foreach($nav4 as $u)
                            <li><a href="{{url('equipment/list/'.$u->cat_id)}}">{{$u->cat_name}}</a></li>
                        @endforeach

                        <li><a href="">更多</a></li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="centergoods-list">
                <div class="centerlist-one">
                    <a href=""><img src="home/images/shebei/62.jpg" alt=""></a>
                    <div class="centerlist-title">
                        <p>
                            @foreach($four as $i)
                                <a href="{{url('equipment/list/'.$i->cat_id)}}">{{$i->cat_name}}</a><span>|</span>
                            @endforeach
                            {{--<a href="">摄像机</a><span>|</span><a href="">监控器</a><span>|</span><a href="">硬盘</a><span>|</span><a--}}
                                {{--href="">矩阵</a><span>|</span><a href="">画面处理</a><span>|</span><a href="">操作台</a>--}}
                        </p>
                    </div>
                </div>
                <div class="centerlist-two">
                    <a href=""><img src="home/images/shebei/63.jpg" alt=""></a>
                    <a href=""><img src="home/images/shebei/64.jpg" alt="" style="margin-top: 10px;  box-shadow: 0px -5px 5px 5px #d8d8d8;"></a>
                </div>
                <div class="centerlist-three">
                    <a href=""><img src="home/images/shebei/65.jpg" alt=""></a>
                </div>
                <div class="centerlist-four">
                    <a href=""><img src="home/images/shebei/66.jpg" alt=""></a>
                    <a href=""><img src="home/images/shebei/67.jpg" alt=""></a>
                </div>
            </div>
        </div>

        <div class="maingoods">
            <div class="submaingoods">
                <div class="maingoods-title"><span>F5</span><h3>停车管理</h3></div>
                <div class="maingoods-nav" style="width: 580px;">
                    <ul>
                        @foreach($nav5 as $m)
                            <li><a href="{{url('equipment/list/'.$m->cat_id)}}">{{$m->cat_name}}</a></li>
                        @endforeach

                        <li><a href="">更多</a></li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="maingoods-list">
                <div class="maingoods-one">
                    <img src="home/images/shebei/59.jpg" alt="">
                    <p>
                        @foreach($five as $p)
                            <a href="{{url('equipment/list/'.$p->cat_id)}}">{{$p->cat_name}}</a><span>|</span>
                        @endforeach
                    </p>
                </div>
                <div class="maingoods-two"><img src="home/images/shebei/60.jpg" alt=""></div>
                <div class="maingoods-three">
                    <img src="home/images/shebei/61.jpg" alt="" style=" box-shadow: 0px 0px 10px 5px #d8d8d8;">
                    <img src="home/images/shebei/61.jpg" alt="">

                </div>
            </div>
        </div>

        <div class="centergoods">
            <div class="subcentergoods">
                <div class="centergoods-title"><span>F6</span><h3>楼宇对讲</h3></div>
                <div class="centergoods-nav" style="width: 680px;">
                    <ul>
                        @foreach($nav6 as $s)
                            <li><a href="{{url('equipment/list/'.$s->cat_id)}}">{{$s->cat_name}}</a></li>
                        @endforeach


                        <li><a href="">更多</a></li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="centergoods-list">
                <div class="centerlist-one">
                    <a href=""><img src="home/images/shebei/62.jpg" alt=""></a>
                    <div class="centerlist-title">
                        <p>
                            @foreach($six as $a)
                                <a href="{{url('equipment/list/'.$a->cat_id)}}">{{$a->cat_name}}</a><span>|</span>
                            @endforeach

                        </p>
                    </div>
                </div>
                <div class="centerlist-two">
                    <a href=""><img src="/home/images/shebei/63.jpg" alt=""></a>
                    <a href=""><img src="/home/images/shebei/64.jpg" alt="" style="margin-top: 10px;  box-shadow: 0px -5px 5px 5px #d8d8d8;"></a>
                </div>
                <div class="centerlist-three">
                    <a href=""><img src="/home/images/shebei/65.jpg" alt=""></a>
                </div>
                <div class="centerlist-four">
                    <a href=""><img src="/home/images/shebei/66.jpg" alt=""></a>
                    <a href=""><img src="/home/images/shebei/67.jpg" alt=""></a>
                </div>
            </div>
        </div>


        <div class="maingoods">
            <div class="submaingoods">
                <div class="maingoods-title"><span>F7</span><h3>智能消费</h3></div>
                <div class="maingoods-nav" style="width: 180px;">
                    <ul>
                        @foreach($nav7 as $d)
                            <li><a href="{{url('equipment/list/'.$d->cat_id)}}">{{$d->cat_name}}</a></li>
                        @endforeach

                        <li><a href="">更多</a></li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="maingoods-list">
                <div class="maingoods-one">
                    <img src="/home/images/shebei/59.jpg" alt="">
                    <p>
                        @foreach($seven as $f)
                            <a href="{{url('equipment/list/'.$f->cat_id)}}">{{$f->cat_name}}</a><span>|</span>
                        @endforeach

                    </p>
                </div>
                <div class="maingoods-two"><img src="/home/images/shebei/60.jpg" alt=""></div>
                <div class="maingoods-three">
                    <img src="/home/images/shebei/61.jpg" alt="" style=" box-shadow: 0px 0px 10px 5px #d8d8d8;">
                    <img src="/home/images/shebei/61.jpg" alt="">

                </div>
            </div>
        </div>

        <div class="centergoods">
            <div class="subcentergoods">
                <div class="centergoods-title"><span>F8</span><h3>安防配套</h3></div>
                <div class="centergoods-nav" style="width: 500px;">
                    <ul>
                        @foreach($nav8 as $g)
                            <li><a href="{{url('equipment/list/'.$g->cat_id)}}">{{$g->cat_name}}</a></li>
                        @endforeach

                        <li><a href="">更多</a></li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="centergoods-list">
                <div class="centerlist-one">
                    <a href=""><img src="/home/images/shebei/62.jpg" alt=""></a>
                    <div class="centerlist-title">
                        <p>
                            @foreach($eight as $h)
                                <a href="{{url('equipment/list/'.$h->cat_id)}}">{{$h->cat_name}}</a><span>|</span>
                            @endforeach

                        </p>
                    </div>
                </div>
                <div class="centerlist-two">
                    <a href=""><img src="/home/images/shebei/63.jpg" alt=""></a>
                    <a href=""><img src="/home/images/shebei/64.jpg" alt="" style="margin-top: 10px;  box-shadow: 0px -5px 5px 5px #d8d8d8;"></a>
                </div>
                <div class="centerlist-three">
                    <a href=""><img src="/home/images/shebei/65.jpg" alt=""></a>
                </div>
                <div class="centerlist-four">
                    <a href=""><img src="/home/images/shebei/66.jpg" alt=""></a>
                    <a href=""><img src="/home/images/shebei/67.jpg" alt=""></a>
                </div>
            </div>
        </div>

    </div>
</div>

@include('inc.home.footer')
<script src="home/js/jquery-3.1.0.min.js"></script>
<script src="home/js/top.js"></script>
{{--搜索--}}
<script src="home/js/search.js"></script>
</body>
</html>
