<?php

namespace App\Http\Controllers\Api\Shop;

use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

/*
*   该控制器包含了商铺模块的操作
*/
class ShopsController extends Controller
{
    /*
    *   商铺查看
    */
    public function shopsshow(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        
    }
}
