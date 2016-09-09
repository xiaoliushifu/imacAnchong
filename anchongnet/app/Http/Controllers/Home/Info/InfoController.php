<?php

namespace App\Http\Controllers\Home\Info;

use App\Information;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class InfoController extends Controller
{
    public function index()
    {
        $info = Information::paginate(10);
        return view('home.info.index',compact('info'));
    }

    public function info($infor_id)
    {
        $info = Information::find($infor_id);
        return view('home.info.info',compact('info'));
    }

    public function upload()
    {
        return view('home.info.upload');
    }
}
