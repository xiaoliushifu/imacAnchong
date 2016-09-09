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

        return view('home.business.shangji', compact('bus', 'user', 'hot'));
    }

    public function project($bid)
    {
        $data = Business::find($bid);
        $data->content = str_replace("\n", "<br>", $data->content);
        return view('home.business.gongchengxq', compact('data'));
    }

    public function talent()
    {
        $data = Business::where('type', 1)->orderBy('created_at', 'asc')->paginate(15);

        return view('home.business.talent', compact('data'));
    }

    public function sergoods()
    {
        $data = Business::where('type', 5)->orderBy('created_at', 'desc')->paginate(15);

        return view('home.business.zhaohuo', compact('data'));
    }


    public function orderlist()
    {
        $data = Business::where('type', 3)->orderBy('created_at', 'desc')->paginate(15);

        return view('home.business.orderlist', compact('data'));
    }

    public function ordermain($bid)
    {
        $data = Business::find($bid);
        $data->content = str_replace("\n", "<br>", $data->content);
        return view('home.business.ordermain', compact('data'));
    }

    public function chat()
    {
        return view('home.business.releasechat');
    }


    public function reorder()
    {
        return view('home.business.releaseorder');
    }

    public function releaseeg()
    {
        return view('home.business.releaseeg');
    }

    public function fngoods()
    {
        return view('home.business.releasefngoods');
    }

    public function ancshop()
    {
        return view('home.business.equipshopping');
    }

    public function thirdshop()
    {
        return view('home.business.thirdparty');
    }


}