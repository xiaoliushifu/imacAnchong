@extends('inc.home.pcenter.pcenter')
@section('info')
    <title>我的发布</title>
    <link rel="stylesheet" type="text/css" href="home/css/minepublish.css">
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
                     <li><a href="javascript::" class="inactive">我的发布<b class="caret"></b></a>
                         <ul class="ttt" style="display: none">
                             <hr>
                             <li><a href="{{url('/conwork')}}" class="inactive active">发包工程</a></li>
                             <li><a href="{{url('/conwork')}}" class="inactive active">承接工程</a></li>
                             <li><a href="{{url('/reoder')}}" class="inactive active">发布人才</a></li>
                             <li><a href="{{url('/mypublish')}}" class="inactive active">人才自荐</a></li>
                             <li><a href="{{url('/fngoods')}}" class="inactive active">找货</a></li>

                         </ul>

                     </li>
                     <hr>
                     <li><a href="javascript::" class="inactive">我的收藏<b class="caret"></b></a>
                         <ul class="ttt" style="display: none">
                             <hr>
                             <li><a href="{{url('/colgoods')}}" class="inactive active">商品</a></li>
                             <li class="last"><a href="{{url('/colshop')}}">商铺</a></li>
                             <li class="last"><a href="{{url('/colcommunity')}}">社区</a></li>
                         </ul>
                     </li>
                     <hr>
                     <li><a href="javascript::" class="inactive">我的订单<b class="caret"></b></a>
                         <ul class="ttt" style="display: none">
                             <hr>
                             <li><a href="#" class="inactive active">美协机关</a>

                             </li>
                             <li><a href="#" class="inactive active">中国文联美术艺术中心</a>

                         </ul>

                     </li>
                     <hr>
                     <li><a href="#">我的钱袋</a></li>
                     <hr>
                     <li><a href="#">虫虫粉丝</a></li>
                     <hr>
                     <li><a href="{{url('/applysp')}}">商铺申请</a></li>
                     <hr>
                     <li><a href="{{url('/honor')}}">商家认证</a></li>
                     <hr>

                 </ul>
             </div>
         </div>
         <div class="mainrg">
             <div class=" daomain">
                 <ul>
                     <li><a href="#" >发包工程</a></li>
                     <li><a href="#">承接工程</a></li>
                     <li><a href="#" >发布人才</a></li>
                     <li><a href="#" style="color: #1DABD8;font-size: 20px;font-weight: bold;">人才自荐</a></li>
                     <li><a href="#">找货</a></li>


                 </ul>
             </div>

             <div class="centermain">
                 <div class="center-left">
                     <a href=""><img src="home/images/mine/66.jpg" alt=""></a>
                     <p><a href="">周先生</a></p>
                 </div>
                 <div class="center-right">
                     <h4><a href="">发布标题</a></h4>
                     <p>发布内容发布内容发布内容发容发布内容发布内容发布内容发布内容发布内容发布内容发布内容发布内容发布内容发布内容发布内容发布内容发布内容发布内容发布内容发布内容发布内容发布内容发布内容</p>
                 </div>

             </div>

             <div class="centermain">
                 <div class="center-left">
                     <a href=""><img src="home/images/mine/66.jpg" alt=""></a>
                     <p><a href="">周先生</a></p>
                 </div>
                 <div class="center-right">
                     <h4><a href="">发布标题</a></h4>
                     <p>发布内容发布内容发布内容发容发布内容发布内容发布内容发布内容发布内容发布内容发布内容发布内容发布内容发布内容发布内容发布内容发布内容发布内容发布内容发布内容发布内容发布内容发布内容</p>
                 </div>

             </div>


             <div class="centermain">
                 <div class="center-left">
                     <a href=""><img src="home/images/mine/66.jpg" alt=""></a>
                     <p><a href="">周先生</a></p>
                 </div>
                 <div class="center-right">
                     <h4><a href="">发布标题</a></h4>
                     <p>发布内容发布内容发布内容发容发布内容发布内容发布内容发布内容发布内容发布内容发布内容发布内容发布内容发布内容发布内容发布内容发布内容发布内容发布内容发布内容发布内容发布内容发布内容</p>
                 </div>

             </div>





         </div>


     </div>
     <div style="clear: both"></div>
     <script type="text/javascript" src="home/js/navleft.js"></script>

     @endsection
