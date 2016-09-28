<?php

namespace App\Http\Controllers\Home;

use App\Business;
use App\Category;
use App\Community_release;
use App\Information;
use App\Usermessages;
use EasyWeChat\Staff\Session;
use App\Http\Requests;
/*
 * 前端首页控制器
 */
class IndexController extends CommonController
{
//    前端页面
    public function index(){
        $hot = Business::where('type', 1)->orderBy('created_at', 'desc')->take(5)->get();
        $talent = Business::where('type',3)->orderBy('created_at','desc')->take(5)->get();
        $info = Information::orderBy('created_at','desc')->take(2)->get();
        $userinfo = Usermessages::take(8)->orderBy('updated_at','desc')->get();
        $community = Community_release::take(3)->orderBy('created_at','desc')->get();
        $nav = Category::orderBy('cat_id','asc')->take(8)->get();
        return view('home.index',compact('hot','info','talent','userinfo','community','nav'));
    }
}
