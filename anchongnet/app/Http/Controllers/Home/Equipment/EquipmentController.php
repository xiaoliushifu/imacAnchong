<?php

namespace App\Http\Controllers\Home\Equipment;


use App\Goods_brand;
use App\Goods_cat;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class EquipmentController extends Controller
{
    public function getIndex()
    {
//        金牌店铺
        $brand = Goods_brand::orderBy('brand_id','asc')->take(4)->get();
//住导航
        $nav = Goods_cat::orderBy('cat_id','asc')->take(8)->get();
//       if 图片下导航
        $one = Goods_cat::where(['is_show'=>1,'parent_id'=>1])->get();
//        1f导航
         $nav1 = Goods_cat::where('parent_id',1)->take(7)->get();
//        2f导航
        $nav2 = Goods_cat::where('parent_id',2)->take(6)->get();
        return view('home.equipment.equipshopping',compact('brand','nav','one','nav1','nav2'));
   }

    public function getList()
    {
        return view('home.equipment.goodslist');
    }
    public function getShow()
    {
        return view('home.equipment.goodsdetals');
    }
    public function getThirdshop()
    {
        return view('home.equipment.thirdparty');
    }
}
