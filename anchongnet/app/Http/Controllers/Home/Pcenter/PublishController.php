<?php

namespace App\Http\Controllers\Home\Pcenter;
use App\Business;
use App\Http\Controllers\Home\CommonController;
use App\Users;
use Cache;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
class PublishController extends CommonController
{
    /*
     * 人才自荐
     */
    public function publish()
    {

         $page = Input::get(['page']);
         $pub = Cache::remember('pubpro'.$page,10,function(){
         $user =Users::where('phone',[session('user')])->first();
         return  Business::where(['users_id'=>$user->users_id,'type'=>3])->paginate(6);
        });
        return view('home.pcenter.minepublish.minepublish',['pubpro'=>$pub]);
    }
    /*
     * 我的发布人才
    */
    public function pubtalent()
    {
        $page = Input::get(['page']);
        $pubtalent = Cache::remember('pubtalent'.$page,10,function(){
        $user =Users::where('phone',[session('user')])->first();
        return Business::where(['users_id'=>$user->users_id,'type'=>4])->paginate(6);
        });
        return view('home.pcenter.minepublish.publishtalent',compact('pubtalent'));
    }

    /*
     * 发包工程
     */
    public function work()
    {
        $page = Input::get(['page']);
        $pubwork = Cache::remember('pubwork'.$page,10,function(){
        $user =Users::where('phone',[session('user')])->first();
        return Business::where(['users_id'=>$user->users_id,'type'=>1])->paginate(6);
        });
        return view('home.pcenter.minepublish.contractwork',compact('pubwork'));
    }
    /*
     * 承接工程
    */
    public function continu()
    {

       $page = Input::get(['page']);
       $pubche = Cache::tags('cont')->remember('pubche'.$page,10,function(){
       $user =Users::where('phone',[session('user')])->first();
       return  Business::where(['users_id'=>$user->users_id,'type'=>2])->paginate(6);
       Cache::forget('cont');
    });
        return view('home.pcenter.minepublish.continueproject',compact('pubche'));
    }
    /*
     * 我的找货
     */
    public function myfgoods()
    {
        $page = Input::get(['page']);
        $pubfg = Cache::remember('pubfg'.$page,10,function(){
        $user =Users::where('phone',[session('user')])->first();
        return Business::where(['users_id'=>$user->users_id,'type'=>5])->paginate(6);
        });
        return view('home.pcenter.minepublish.myfindgoods',compact('pubfg'));
    }
}
