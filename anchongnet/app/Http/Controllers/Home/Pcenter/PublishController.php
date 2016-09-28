<?php

namespace App\Http\Controllers\Home\Pcenter;

use App\Business;
use App\Http\Controllers\Home\CommonController;
use App\Users;
use Illuminate\Http\Request;

use App\Http\Requests;


class PublishController extends CommonController
{
    //     人才自荐
    public function publish()
    {
        $user =Users::where('phone',[session('user')])->first();
        $pro = Business::where(['users_id'=>$user->users_id,'type'=>3])->paginate(6);
        return view('home.pcenter.minepublish.minepublish',compact('pro'));
    }
    //     我的发布人才
    public function pubtalent()
    {
        $user =Users::where('phone',[session('user')])->first();
        $pro = Business::where(['users_id'=>$user->users_id,'type'=>4])->paginate(6);

        return view('home.pcenter.minepublish.publishtalent',compact('pro'));
    }
    //        发包工程
    public function work()
    {
        $user =Users::where('phone',[session('user')])->first();
        $pro = Business::where(['users_id'=>$user->users_id,'type'=>1])->paginate(8);

        return view('home.pcenter.minepublish.contractwork',compact('pro'));
    }
    //        承接工程
    public function continu()
    {
        $user =Users::where('phone',[session('user')])->first();
        $pro = Business::where(['users_id'=>$user->users_id,'type'=>2])->paginate(8);

        return view('home.pcenter.minepublish.continueproject',compact('pro'));
    }
    //       我的找货
    public function myfgoods()
    {
        $user =Users::where('phone',[session('user')])->first();
        $pro = Business::where(['users_id'=>$user->users_id,'type'=>5])->paginate(8);

        return view('home.pcenter.minepublish.myfindgoods',compact('pro'));
    }
}
