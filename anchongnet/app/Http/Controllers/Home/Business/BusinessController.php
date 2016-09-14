<?php

namespace App\Http\Controllers\Home\Business;

use App\Business;
use App\Usermessages;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/*
*   前端商机模块的控制器
*/
class BusinessController extends Controller
{
    public function index()
    {
//        最新招标
        $bus = Business::where('type', 1)->orderBy('created_at', 'desc')->take(5)->get();
        $user = Usermessages::orderBy('users_id', 'asc')->take(8)->get();
//热门招标
        $hot = Business::where('type', 1)->orderBy('created_at', 'asc')->take(5)->get();

        return view('home.business.business', compact('bus', 'user', 'hot'));
    }






    public function chat()
    {
        return view('home.release.releasechat');
    }


    public function reorder()
    {
        return view('home.release.releaseorder');
    }

    public function releaseeg()
    {
        return view('home.release.releaseeg');
    }

    public function fngoods()
    {
        return view('home.release.releasefngoods');
    }

    public function ancshop()
    {
        return view('home.business.equipshopping');
    }

    public function thirdshop()
    {
        return view('home.business.thirdparty');
    }

    public function goodslist()
    {
        return view('home.business.goodslist');
    }

    public function shenme()
    {
        return view('home.business.project-desc');
    }
}