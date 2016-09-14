<?php

namespace App\Http\Controllers\Home\Findgoods;

use App\Business;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class FindgoodsController extends Controller
{
//    找货列表
    public function index()
    {

        $data = Business::where('type', 5)->orderBy('created_at', 'desc')->paginate(15);

        return view('home.business.findgoods', compact('data'));
    }
//新建发布列表表单
    public function create()
    {
        return view('home.release.releasefngoods');
    }
//    提交数据到数据库
    public function store()
    {

    }
//    显示对应ID的内容
    public function show()
    {

    }
}
