<?php

namespace App\Http\Controllers\Home;

use App\Business;
use App\Community_release;
use App\Information;
use App\Usermessages;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/*
 * 前端首页控制器
 */
class IndexController extends Controller
{
//    前端页面
    public function index(){
        $hot = Business::where('type', 1)->orderBy('created_at', 'desc')->take(5)->get();
        $talent = Business::where('type',3)->orderBy('created_at','desc')->take(5)->get();
        $info = Information::orderBy('created_at','desc')->take(2)->get();
        $userinfo = Usermessages::take(8)->orderBy('updated_at','desc')->get();
        $community = Community_release::take(3)->orderBy('created_at','desc')->get();
        return view('home.index',compact('hot','info','talent','userinfo','community'));
    }
}

