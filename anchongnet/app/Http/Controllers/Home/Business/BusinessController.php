<?php

namespace App\Http\Controllers\Home\Business;
use App\Business;
use App\Http\Controllers\Home\CommonController;
use App\Usermessages;
use Cache;

/**
 * 仅供商机首页
 * @author liumingwei
 *
 */
class BusinessController extends CommonController
{
    /**
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //安虫名人榜
        $users = Cache::remember('bus-user',10,function() {
            return Usermessages::take(8)->get(['headpic','nickname']);
        });
        
        $value = Cache::remember('bus-invit',30,function() {
            return  Business::where('type', 1)->orderBy('created_at', 'desc')->take(10)->get(['bid','content','img','title']);
        });
        //最新招标工程
        $new = $value->take(5);
        //热门招标
        $hot = $value->slice(5)->values();//values方法用于重置下标
        
        //人才招聘
        $talent = Cache::remember('bus-talent',10,function() {
            return Business::where('type',4)->orderBy('created_at','desc')->take(5)->get(['tag','tags']);
        });
        return view('home.business.business', ['businvit'=>$new,'bushot'=>$hot,'bustalent'=>$talent,'bususer'=>$users]);
    }
}
