<?php

namespace App\Http\Controllers\Home\Equipment;


use App\Category;
use App\Goods_brand;
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
        $nav = Category::orderBy('cat_id','asc')->take(8)->get();
//       1f 图片下导航
        $one = Category::where(['is_show'=>1,'parent_id'=>1])->get();
//        1f导航
         $nav1 = Category::where('parent_id',1)->take(7)->get();
//        2f导航
        $nav2 = Category::where('parent_id',2)->take(6)->get();
        //2f 图片下导航
        $two = Category::where(['is_show'=>1,'parent_id'=>2])->get();
        //3f 导航
        $nav3 = Category::where(['is_show'=>1,'parent_id'=>3])->take(5)->get();
        //3f 图片下的导航
        $three = Category::where(['is_show'=>1,'parent_id'=>3])->get();
        //4f daohang
        $nav4 = Category::where(['is_show'=>1,'parent_id'=>4])->take(4)->get();
        $four = Category::where(['is_show'=>1,'parent_id'=>4])->get();
        $nav5 = Category::where(['is_show'=>1,'parent_id'=>5])->take(6)->get();
        $five = Category::where(['is_show'=>1,'parent_id'=>5])->get();
        $nav6 = Category::where(['is_show'=>1,'parent_id'=>6])->take(7)->get();
        $six = Category::where(['is_show'=>1,'parent_id'=>6])->get();
        $nav7 = Category::where(['is_show'=>1,'parent_id'=>7])->take(7)->get();
        $seven = Category::where(['is_show'=>1,'parent_id'=>7])->get();
        $nav8 = Category::where(['is_show'=>1,'parent_id'=>8])->take(7)->get();
        $eight = Category::where(['is_show'=>1,'parent_id'=>8])->get();
        return view('home.equipment.equipshopping',compact('brand','nav','one',
            'nav1','nav2','two','nav3','three','nav4','four','nav5','five','nav6','six','nav7','seven','nav8','eight'));
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
