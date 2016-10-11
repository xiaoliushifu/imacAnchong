<?php

namespace App\Http\Controllers\Home\Pcenter;
use App\Collection;
use App\Feedback_reply;
use App\Goods_type;
use App\Http\Controllers\Home\CommonController;
use App\Users;
use App\Business;
use Cache;
use Illuminate\Support\Facades\Input;

class IndexController extends CommonController
{
    private $business;
    public function getIndex()
  {
      $pcenter = Cache::remember('pcenter',10,function(){
      $user =Users::where('phone',[session('user')])->first();
      $col = Collection::where(['users_id'=>$user->users_id,'coll_type'=>1])->get(['coll_id'])->toArray();
       return  Goods_type::wherein('gid',$col)->paginate(12);
      });
        return view('home.pcenter.index',compact('pcenter'));
    }
    
    public function getFbgc()
    {
        $this->business = new Business();
        $datas=$this->business->orderBy("created_at","desc")->paginate(8);
        return $datas;
    }
    /*
     * 服务消息
     */
    public function servermsg()
    {
        $serverm = Cache::remember('serverm',10,function(){
        $user =Users::where('phone',[session('user')])->first();
        return  Feedback_reply::where('users_id',$user->users_id)->get();
        });
        return view('home.pcenter.servermsg',compact('serverm'));
    }

    /*
     * 申请商铺
     */
    public function applysp()
    {
        return view('home.pcenter.applyshop');
    }
    /*
     * 基本资料
    */
    public function basics()
    {
        return view('home.pcenter.basics');
    }
    /*
     * 商铺认证
    */
    public function honor()
    {
        return view('home.pcenter.honor');
    }

    /*
     * 上传头像
     */
    public function uphead()
    {
        return view('home.pcenter.head');
    }





}

