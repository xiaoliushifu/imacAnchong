@extends('inc.home.pcenter.pcenter')
@section('info')
    <title>地址管理</title>
    <link rel="stylesheet" type="text/css" href="home/css/adress.css">

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
        <div class=" daomain">
           <h4>地址管理</h4>
        </div>

          <div class="newadress"><p>新增收货地址</p></div>
            <div class="detail">
                <form action="" method="">
                <li>
                    <span>收货人：</span><input type="text" value="风信子" onfocus="javascript:if(this.value=='风信子')this.value='';">
                </li>
                    <li>
                        <span>联系电话：</span><input type="text" value="13888888888" onfocus="javascript:if(this.value=='13888888888')this.value='';">
                    </li>
                    <li>
                    <span>所在地区：</span><input type="text" value="北京市昌平区沙河镇"onfocus="javascript:if(this.value=='北京市昌平区沙河镇')this.value='';">
                        <div class="caret"></div>
                </li>
                    <li>
                        <span>邮政编码：</span><input type="text" value="010028"onfocus="javascript:if(this.value=='010028')this.value='';">
                    </li>
                    <li style="height: 90px;">
                        <span>详细地址：</span><input type="text" value="于辛庄村天利家园#300"onfocus="javascript:if(this.value=='于辛庄村天利家园#300')this.value='';">
                    </li>
                    <div class="install">
                        <img src="home/images/mine/选择.png" alt=""><button type="submit">设为默认收获地址</button>
                    </div>
                </form>
            </div>
        <hr style="margin-left: 10px;">
        <div class="notes">
            <p>已保存3条地址，还能保存7条</p>
        </div>
        <div class="noteslist">
            <table>
                <tr>
                    <th class="name">收货人</th>
                    <th  class="badress">所在地区</th>
                    <th class="xadress">详细地址</th>
                    <th>邮政编码</th>
                    <th>手机</th>
                    <th>操作</th>
                    <th>    </th>
                </tr>
                <tr>
                    <td class="name">风信子</td>
                    <td class="badress">北京市昌平区回龙观</td>
                    <td class="xadress">沙河镇天利家园#300</td>
                    <td class="nub">000000</td>
                    <td class="phone">13888888888</td>
                    <td class="xiugai"><a href="">修改</a><span>|</span><a href="">删除</a></td>
                    <td class="moren"><img src="home/images/mine/默认.png" alt=""></td>
                </tr>
                <tr>
                    <td class="name">风信子</td>
                    <td class="badress">北京市昌平区回龙观</td>
                    <td class="xadress">沙河镇天利家园#300</td>
                    <td class="nub">000000</td>
                    <td  class="phone">13888888888</td>
                    <td class="xiugai"><a href="">修改</a><span>|</span><a href="">删除</a></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="name">风信子</td>
                    <td class="badress">北京市昌平区回龙观</td>
                    <td class="xadress">沙河镇天利家园#300</td>
                    <td class="nub">000000</td>
                    <td class="phone">13888888888</td>
                    <td class="xiugai"><a href="">修改</a><span>|</span><a href="">删除</a></td>
                    <td></td>
                </tr>
            </table>
        </div>

    </div>


    </div>
<div style="clear: both"></div>
<<<<<<< HEAD
@endsection
=======
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
                <img src="home/images/mine/1.jpg">
            </div>
            <div class="mmm">
                <h4>安虫微信订阅号</h4>
                <img src="home/images/mine/2.jpg">
            </div>

        </div>
    </div>
</div>
<hr class="fff">

<div class="footdown">
    <div class="footdown-1">
        <div class="ddd">
            <p>
                <a href="#">关于安虫</a><span>|</span>
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
>>>>>>> 1d36002ef5ee52e91ef5a9bc3725df772d72248f
