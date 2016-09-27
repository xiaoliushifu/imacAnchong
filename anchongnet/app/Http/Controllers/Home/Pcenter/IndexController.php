<?php

namespace App\Http\Controllers\Home\Pcenter;

use App\Usermessages;
use App\Users;
use Illuminate\Http\Request;
use App\Business;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    private $business;
    public function getIndex()
  {
     $user =Users::where('phone',[session('user')])->first();

    $msg = Usermessages::where('users_id',$user->users_id)->first();

        return view('home.pcenter.index',compact('msg'));
    }
    
    public function getFbgc()
    {
        $this->business = new Business();
        $datas=$this->business->orderBy("created_at","desc")->paginate(8);
        return $datas;
    }

    //        服务消息
    public function servermsg()
    {
        return view('home.pcenter.servermsg');
    }
//        地址管理
    public function adress()
    {
        return view('home.pcenter.adress');
    }
    //        申请商铺
    public function applysp()
    {
        return view('home.pcenter.applyshop');
    }
    //        基本资料
    public function basics()
    {
        return view('home.pcenter.basics');
    }
    //        商铺认证
    public function honor()
    {
        return view('home.pcenter.honor');
    }
    //        我的发布
    public function publish()
    {
        return view('home.pcenter.minepublish');
    }
    //        发包工程
    public function work()
    {
        return view('home.pcenter.contractwork');
    }
//        上传头像
    public function uphead()
    {
        return view('home.pcenter.head');
    }





}

