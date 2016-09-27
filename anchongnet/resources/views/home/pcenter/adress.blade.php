@extends('inc.home.pcenter.pcenter')
@section('info')
    <title>地址管理</title>
    <link rel="stylesheet" type="text/css" href="home/css/adress.css">

    @section('content')
<div class="main">
    <div class="mainlf">
        <div class="topll">
            <img src="{{$msg->headpic}}" alt="">
            <p>{{$msg->nickname}}</p>
            <p>QQ：{{$msg->qq}}</p>
            <p>邮箱：{{$msg->email}}</p>
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
@endsection

