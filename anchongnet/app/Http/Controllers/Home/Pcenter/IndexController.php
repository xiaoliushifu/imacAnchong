<?php

namespace App\Http\Controllers\Home\Pcenter;

use App\Address;
use App\Collection;
use App\Feedback_reply;
use App\Goods_type;
use App\Http\Controllers\Home\CommonController;
use App\Usermessages;
use App\Users;
use Illuminate\Http\Request;
use App\Business;

class IndexController extends CommonController
{
    private $business;
    public function getIndex()
  {
     $user =Users::where('phone',[session('user')])->first();
    $msg = Usermessages::where('users_id',$user->users_id)->first();
      $col = Collection::where(['users_id'=>$user->users_id,'coll_type'=>1])->get(['coll_id'])->toArray();


      $colg= Goods_type::wherein('gid',$col)->paginate(12);

        return view('home.pcenter.index',compact('msg','colg'));
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
        $user =Users::where('phone',[session('user')])->first();
        $messages = Feedback_reply::where('users_id',$user->users_id)->get();

        return view('home.pcenter.servermsg',compact('messages'));
    }
//        地址管理
    public function adress()
    {
        $user =Users::where('phone',[session('user')])->first();
        $adress = Address::where('users_id',$user->users_id)->get();
//           dd($adress);
        return view('home.pcenter.adress',compact('adress'));
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

//        上传头像
    public function uphead()
    {
        return view('home.pcenter.head');
    }





}

