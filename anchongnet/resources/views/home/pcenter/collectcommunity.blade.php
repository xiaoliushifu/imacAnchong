<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>社区</title>
    <link rel="stylesheet" type="text/css" href="home/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="home/css/collectcommunity.css">
    <script type="text/javascript" src="home/js/jquery-3.0.0.min.js"></script>
     <script type="text/javascript" src="home/js/bootstrap.js"></script>
</head>
<body>
<div class="topt">
    <div class="topt-1">
        <div class="topt-2"><p>安虫首页</p></div>
        <div class="topt-3">
            <ul class="nav navbar-nav">
                <li>邮箱：www.@anchong.net</li>
                <li>垂询电话:0317-8155026</li>
                <li><img src="home/images/collect/6.jpg" alt=""></li>
                <li style="padding-left: 10px;"><a href="#" class="dropdown-toggle " data-toggle="dropdown">风信子<b class="caret"></b></a>
                <ul class="dropdown-menu depth_0">
                        <li><a href="#">网页特效</a></li>
                        <li><a href="#">音效下载</a></li>
                        <li><a href="#">网页模板</a></li>
                        <li><a href="#">flash动画</a></li>
                    </ul>


                </li>
            </ul>
        </div>
    </div>
</div>
<div class="topone">
    <div class="topone-1">
        <div class="topone-2">
            <img src="home/images/collect/60.jpg" alt="">
        </div>
        <div class="topone-3">
            <ul>
                <li  class="ppp"><a href="#" >首页</a><img src="home/images/collect/up.png" alt=""> </li>
                <li  class="ppp"><a href="#" >个人资料</a><img src="home/images/collect/up.png" alt=""> </li>
                <li  class="ppp"><a href="#" >消息</a><img src="home/images/collect/up.png" alt=""> </li>
            </ul>
        </div>
    </div>
</div>
<div class="main">
    <div class="mainlf">
        <div class="topll">
            <img src="home/images/collect/61.jpg" alt="">
            <p>风信子</p>
            <p>QQ：888888888888</p>
            <p>邮箱：88888888888@qq.com</p>
        </div>
        <div class="toppp">
            <ul>

                <script type="text/javascript">
                    $(document).ready(function() {
                        $('.inactive').click(function(){
                            if($(this).siblings('ul').css('display')=='none'){
                                $(this).parent('li').siblings('li').removeClass('inactives');
                                $(this).addClass('inactives');
                                $(this).siblings('ul').slideDown(100).children('li');
                                if($(this).parents('li').siblings('li').children('ul').css('display')=='block'){
                                    $(this).parents('li').siblings('li').children('ul').parent('li').children('a').removeClass('inactives');
                                    $(this).parents('li').siblings('li').children('ul').slideUp(100);

                                }
                            }else{
                                //控制自身变成+号
                                $(this).removeClass('inactives');
                                //控制自身菜单下子菜单隐藏
                                $(this).siblings('ul').slideUp(100);
                                //控制自身子菜单变成+号
                                $(this).siblings('ul').children('li').children('ul').parent('li').children('a').addClass('inactives');
                                //控制自身菜单下子菜单隐藏
                                $(this).siblings('ul').children('li').children('ul').slideUp(100);

                                //控制同级菜单只保持一个是展开的（-号显示）
                                $(this).siblings('ul').children('li').children('a').removeClass('inactives');
                            }
                        })
                    });
                </script>


                <li><a href="javascript::" class="inactive">我的发布<b class="caret"></b></a>
                    <ul class="ttt" style="display: none">
                        <hr>
                        <li><a href="#" class="inactive active">美协机关</a>

                        </li>
                        <li><a href="#" class="inactive active">中国文联美术艺术中心</a>

                    </ul>

                </li>
                <hr>
                <li><a href="javascript::" class="inactive">我的收藏<b class="caret"></b></a>
                    <ul class="ttt" style="display: none">
                        <hr>
                        <li><a href="#" class="inactive active">商品</a></li>
                        <li class="last"><a href="#">商铺</a></li>
                        <li class="last"><a href="#">社区</a></li>
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
                <li><a href="#">商铺申请</a></li>
                <hr>
                <li><a href="#">商家认证</a></li>
                <hr>

            </ul>
        </div>
    </div>
    <div class="mainrg">
        <div class=" daomain">
            <ul>
                <li><a href="#">商品</a></li>
                <li><a href="#">商铺</a></li>
                <li><a href="#" style="font-weight: bold;color: #1DACD8;">社区</a></li>


            </ul>
        </div>
        <div class="pingll">
            <div class="grrq">
                <img src="home/images/collect/37.jpg">
                <p class="mingzi"><a href="#" >风信子</a></p>
                <p> <span class="rqzt">18/</span>6</p>
            </div>
            <div class="pgl">
                <h5>萨科技大阿达</h5>
                
                    <div class="jiao"><img src="home/images/collect/42.jpg"></div>
                    <div class="shuxie">
                     <p>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaasdasdaasdsadadadaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                    </p>
                    </div>
                    <div class=" fenx"><a href=""><img src="home/images/collect/32.jpg" alt=""></a><span>28</span></div>
                    <div class=" kongx"><a href=""><img src="home/images/collect/35.jpg" alt=""></a></div>
              
            </div>
        </div> 
          <div class="pingll">
            <div class="grrq">
                <img src="home/images/collect/36.jpg">
                <p class="mingzi"><a href="#" >风信子</a></p>
                <p> <span class="rqzt">18/</span>6</p>
            </div>
            <div class="pgl">
                <h5>萨科技大阿达</h5>
                
                    <div class="jiao"><img src="home/images/collect/42.jpg"></div>
                    <div class="shuxie">
                     <p>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaasdasdaasdsadadadaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                    </p>
                    </div>
                    <div class=" fenx"><a href=""><img src="home/images/collect/32.jpg" alt=""></a><span>28</span></div>
                    <div class=" kongx"><a href=""><img src="home/images/collect/35.jpg" alt=""></a></div>
              
            </div>
        </div>       
          <div class="pingll">
            <div class="grrq">
                <img src="home/images/collect/61.jpg">
                <p class="mingzi"><a href="#" >风信子</a></p>
                <p> <span class="rqzt">18/</span>6</p>
            </div>
            <div class="pgl">
                <h5>萨科技大阿达</h5>
                
                    <div class="jiao"><img src="home/images/collect/42.jpg"></div>
                    <div class="shuxie">
                     <p>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaasdasdaasdsadadadaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                    </p>
                    </div>
                    <div class=" fenx"><a href=""><img src="home/images/collect/32.jpg" alt=""></a><span>28</span></div>
                    <div class=" kongx"><a href=""><img src="home/images/collect/35.jpg" alt=""></a></div>
              
            </div>
        </div>       
          <div class="pingll">
            <div class="grrq">
                <img src="home/images/collect/38.jpg">
                <p class="mingzi"><a href="#" >风信子</a></p>
                <p> <span class="rqzt">18/</span>6</p>
            </div>
            <div class="pgl">
                <h5>萨科技大阿达</h5>
                
                    <div class="jiao"><img src="home/images/collect/42.jpg"></div>
                    <div class="shuxie">
                     <p>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaasdasdaasdsadadadaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                    </p>
                    </div>
                    <div class=" fenx"><a href=""><img src="home/images/collect/32.jpg" alt=""></a><span>28</span></div>
                    <div class=" kongx"><a href=""><img src="home/images/collect/35.jpg" alt=""></a></div>
              
            </div>
        </div>       
          <div class="pingll">
            <div class="grrq">
                <img src="home/images/collect/37.jpg">
                <p class="mingzi"><a href="#" >风信子</a></p>
                <p> <span class="rqzt">18/</span>6</p>
            </div>
            <div class="pgl">
                <h5>萨科技大阿达</h5>
                
                    <div class="jiao"><img src="home/images/collect/42.jpg"></div>
                    <div class="shuxie">
                     <p>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaasdasdaasdsadadadaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                    </p>
                    </div>
                    <div class=" fenx"><a href=""><img src="home/images/collect/32.jpg" alt=""></a><span>28</span></div>
                    <div class=" kongx"><a href=""><img src="home/images/collect/35.jpg" alt=""></a></div>
              
            </div>
        </div>       
          <div class="pingll">
            <div class="grrq">
                <img src="home/images/collect/36.jpg">
                <p class="mingzi"><a href="#" >风信子</a></p>
                <p> <span class="rqzt">18/</span>6</p>
            </div>
            <div class="pgl">
                <h5>萨科技大阿达</h5>
                
                    <div class="jiao"><img src="home/images/collect/42.jpg"></div>
                    <div class="shuxie">
                     <p>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaasdasdaasdsadadadaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                    </p>
                    </div>
                    <div class=" fenx"><a href=""><img src="home/images/collect/32.jpg" alt=""></a><span>28</span></div>
                    <div class=" kongx"><a href=""><img src="home/images/collect/35.jpg" alt=""></a></div>
              
            </div>
        </div>             
    </div>


    </div>
<div style="clear: both"></div>
<div class="foottop">
    <div class="foottop-1">
        <div class="foottoplf">
            <div class="yqlg"><h4>友情链接</h4>
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
            <div class="erwm" >
                <h4>下载安虫app客户端</h4>
                <img src="home/images/collect/1.jpg">
            </div>
            <div class="mmm">
                <h4>安虫微信订阅号</h4>
                <img src="home/images/collect/2.jpg">
            </div>

        </div>
    </div>
</div>
<hr class="fff">

<div class="footdown">
    <div class="footdown-1">


                 <div class="ddd">
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