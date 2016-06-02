<?php

namespace App\Http\Controllers\Api\Advert;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/*
*   该控制器包含了广告模块的操作
*/
class AdvertController extends Controller
{

    /*
    *   该方法是商品广告轮播图
    */
    public function businessadvert(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //创建ORM模型
        
    }
}
