<?php

namespace App\Http\Controllers\Home;

use App\Business;
use App\Category;
use App\Community_release;
use App\Information;
use App\Usermessages;
use Illuminate\Support\Facades\Cache;

/*
 * 前端首页控制器
 */
class IndexController extends CommonController
{
    //前端页面
    public function index(){
        $hot = Cache::tags('ihot')->remember('indexhot',600,function (){
            return Business::where('type', 1)->orderBy('created_at', 'desc')->take(5)->get();
        });
        $talent = Cache::tags('italent')->remember('indextalent',600,function(){
            return Business::where('type',3)->orderBy('created_at','desc')->take(5)->get();
        });
        $info = Cache::tags('iinfo')->remember('indexinfo',600,function(){
           return Information::orderBy('created_at','desc')->take(2)->get();
        });
        $userinfo = Cache::tags('iuserinfo')->remember('indexuserinfo',600,function (){
            return Usermessages::take(8)->orderBy('updated_at','desc')->get();
        });
        $community = Cache::tags('icommunity')->remember('indexcommunity',600,function (){
            return Community_release::take(3)->orderBy('created_at','desc')->get();
        });
        $nav = Cache::tags('inav')->remember('indexnav',600,function (){
           return Category::orderBy('cat_id','asc')->take(8)->get();
        });
        $activity = Cache::tags('iactivity')->remember('indexactivity',600,function (){
           return Community_release::where('tags','活动')->orderBy('created_at','desc')->take(4)->get();
        });
        return view('home.index',['ihot'=>$hot,'italent'=>$talent,'iinfo'=>$info,'iuserinfo'=>$userinfo,'icommunity'=>$community,'inav'=>$nav,'inactivity'=>$activity]);

    }
}
