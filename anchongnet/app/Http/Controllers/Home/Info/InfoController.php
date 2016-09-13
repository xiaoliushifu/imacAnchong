<?php

namespace App\Http\Controllers\Home\Info;

use App\Information;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class InfoController extends Controller
{
//    资讯主页
    public function index()
    {
        $info = Information::orderBy('created_at','desc')->paginate(10);
        return view('home.info.index',compact('info'));
    }
//  资讯详情页
    public function info($infor_id)
    {
        $info = Information::find($infor_id);
        return view('home.info.info',compact('info'));
    }
//  干货上传
    public function upload()
    {
        return view('home.info.upload');
    }
    
//    干货上传验证
    public function uploadify()
    {

    }
    
}
