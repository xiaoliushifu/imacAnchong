<?php

namespace App\Http\Controllers\Home\Findgoods;
use App\Business;
use App\Http\Controllers\Home\CommonController;
use Cache;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class FindgoodsController extends CommonController
{
    /*
     * 找货列表
    */
    public function index()
    {
         $page= Input::get(['page']);
        $fglist = Cache::remember('fglist'.$page,10,function(){
            return  Business::where('type', 5)->orderBy('created_at', 'desc')->paginate(15);
        });


        return view('home.business.findgoods', compact('fglist'));
    }
    /*
     * 新建发布列表表单
    */
    public function create()
    {
        return view('home.release.releasefngoods');
    }
    /*
     * 提交数据到数据库
    */
    public function store()
    {

    }
    /*
     * 显示对应ID的内容
    */
    public function show()
    {

    }


}
