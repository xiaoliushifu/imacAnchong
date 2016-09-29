<?php

namespace App\Http\Controllers\Home\Business;

use App\Business;
use App\Http\Controllers\Home\CommonController;
use App\Usermessages;

/*
*   前端商机模块的控制器
*/
class BusinessController extends CommonController
{
    /**
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
//        最新招标
        $bus = Business::where('type', 1)->orderBy('created_at', 'desc')->take(5)->get();
        $user = Usermessages::orderBy('users_id', 'asc')->take(8)->get();
//热门招标
        $hot = Business::where('type', 1)->orderBy('created_at', 'asc')->take(5)->get();
//人才招聘
        $talent = Business::where('type',4)->orderBy('created_at','desc')->take(5)->get();

        return view('home.business.business', compact('bus', 'user', 'hot','talent'));
    }





}