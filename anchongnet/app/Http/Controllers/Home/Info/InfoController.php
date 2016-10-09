<?php

namespace App\Http\Controllers\Home\Info;

use App\Http\Controllers\Home\CommonController;
use App\Information;
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
        $info = Cache::remember('info'.$page,'600',function (){
            return Information::orderBy('created_at','desc')->paginate(10);
        });
        return view('home.info.index',compact('info'));
    }
    /*
     * 资讯详情页
     */
    public function show($infor_id)
    {
        $info = Information::find($infor_id);
        return view('home.info.info',compact('info'));
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
