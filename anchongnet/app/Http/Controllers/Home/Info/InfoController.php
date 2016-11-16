<?php

namespace App\Http\Controllers\Home\Info;

use App\Auth;
use App\Http\Controllers\Home\CommonController;
use App\Information;
use App\Users;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;

class InfoController extends CommonController
{
    /*
     * 资讯主页
     */
    public function index()
    {
        $page = Input::get(['page']);
        $info = Cache::tags('info')->remember('info'.$page,600,function (){
            return Information::orderBy('created_at','desc')->paginate(10);
        });
        //会员是否认证
        if(session('user')) {
            $phone = Users::where('phone', [session('user')])->first();
            $infoauth  = Auth::where("users_id",$phone->users_id)->get(['auth_status']);
        }else{
            $infoauth = [];
        }
        return view('home.info.index',compact('info','infoauth'));
    }
    /*
     * 资讯详情页
     */
    public function show($infor_id)
    {
        $information = Cache::tags('information')->remember('information'.$infor_id,600,function () use($infor_id){
            return Information::find($infor_id);
        });
        return view('home.info.info',compact('information'));
    }
    /*
     *
     */
    public function create()
    {
        return view('home.info.upload');
    }

    /*
     *
     */
    public function store()
    {

    }
    /*
     *
     */
    public function edit()
    {
        
    }
    /*
     *
     */
    public function save()
    {
        
    }
    /*
     *
     */
    public function destroy()
    {
        
    }
}
