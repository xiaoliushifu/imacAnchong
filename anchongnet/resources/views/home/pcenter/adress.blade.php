@extends('inc.home.pcenter.pcenter')
@section('info')
    <title>地址管理</title>
    <link rel="stylesheet" type="text/css" href="{{asset('home/css/adress.css')}}">

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
        @if(count($errors)>0)
            <div class="mark" style="margin-left: 10px;">
                @if(is_object($errors))
                    @foreach($errors->all() as $error)
                        <p style="padding-left: 100px;"> {{$error}}</p>
                    @endforeach
                @else
                    <p>{{$errors}}</p>
                @endif
            </div>
        @endif

        <div class="detail">
                <form action="@if(isset($field)){{url('adress/'.$field->id)}} @else {{url('adress')}} @endif" method="post">
                    @if(isset($field))<input type="hidden"name="_method" value="put"> @endif
                    {{csrf_field()}}
                <li>
                    <span>收货人：</span><input type="text" name="add_name" @if(isset($field)) value="{{$field->add_name}}" @else placeholder="风信子" @endif>
                </li>
                    <li>
                        <span>联系电话：</span><input type="text" name="phone" @if(isset($field)) value="{{$field->phone}}" @else placeholder="13888888888" @endif >
                    </li>
                    <li>
                    <span>所在地区：</span><input type="text" name="region" @if(isset($field)) value="{{$field->region}}" @else placeholder="北京市昌平区沙河镇" @endif >
                        <div class="caret"></div>
                </li>
                    <li>
                        <span>邮政编码：</span><input type="text"@if(isset($field)) value="" @else placeholder="010028" @endif >
                    </li>
                    <li style="height: 90px;">
                        <span>详细地址：</span><input type="text" name="address" @if(isset($field)) value="{{$field->address}}" @else placeholder="于辛庄村天利家园#300" @endif >
                    </li>
                    <div class="install">
                        <label><input type="radio" id="id"   name="isdefault"   @if(isset($field)) value="{{$field->isdefault}}"@else value="1"  @endif><span>设为默认收获地址</span></label>
                        <button type="submit">保存</button>
                    </div>
                        <SCRIPT LANGUAGE="JavaScript">
                            $(document).ready(function(){
                                var old = null; //用来保存原来的对象
                                $("input[name='isdefault']").each(function(){//循环绑定事件
                                    if(this.checked){
                                        old = this; //如果当前对象选中，保存该对象
                                    }
                                    this.onclick = function(){
                                        if(this == old){//如果点击的对象原来是选中的，取消选中
                                            this.checked = false;
                                            old = null;
                                        } else{
                                            old = this;
                                        }
                                    }
                                });
                            });

                        </SCRIPT>
                    @if(isset($field))
                            <script>
                                $("input[name='isdefault'][value='1']").attr("checked",true);
                            </script>
                        @endif
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

                    <th style="text-align: center;">手机</th>
                    <th style="text-align: center;">操作</th>
                    <th  style="text-align: center;">    </th>
                </tr>
                @foreach($addrs as $d)
                <tr>
                    <td class="name">{{$d->add_name}}</td>
                    <td class="badress">{{$d->region}}</td>
                    <td class="xadress">{{$d->address}}</td>

                    <td class="phone">{{$d->phone}}</td>
                    <td class="xiugai"><a href="{{url('adress/'.$d->id.'/edit')}}">修改</a><span>|</span><a href="javascript:;" onclick="delAddress({{$d->id}})">删除</a></td>
                    @if($d->isdefault==1)
                    <td class="moren"><img src="{{asset('home/images/mine/默认.png')}}" alt=""></td>
                        @else
                        <td class="moren"></td>
                        @endif
                </tr>
                @endforeach
                <script>
                    function delAddress(id){

                        if(window.confirm('你确定删除此条地址记录吗？')){
                            $.post("{{url('adress/')}}/"+id,{'_method':'delete','_token':"{{csrf_token()}}"},function(data){
                                if (data.status==0){
                                    alert(data.info)
                                    location.href = location.href
                                }else {
                                    alert(data.info)
                                }
                            });
                        }else{
                            return false;
                        }


                    }
                </script>
            </table>
        </div>

    </div>


    </div>
<div style="clear: both"></div>

@endsection

