<?php

namespace App\Http\Controllers\Home\Equipment;


use App\Category;
use App\Goods;
use App\Goods_attribute;
use App\Goods_brand;
use App\Goods_specifications;
use App\Goods_thumb;
use App\Goods_type;
use App\Shop;
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
            'nav1','nav2','two','nav3','three','nav4','four','nav5','five','nav6','six','nav7','seven','nav8','eight','test'));
   }

    public function getList($cat_id)
    {
        //住导航
        $nav = Category::orderBy('cat_id','asc')->take(8)->get();
        //所在位置
       $adress = Category::find($cat_id);

    $test = Goods_type::where('other_id',$cat_id)->orderBy('cat_id','desc')->paginate(16);

     return view('home.equipment.goodslist',compact('test','nav','adress'));
    }
    public function getShow($goods_id,$gid)
    {
        //住导航
        $nav = Category::orderBy('cat_id','asc')->take(8)->get();
//        通过goods_id商品详情

        $data = Goods::find($goods_id);
//        通过$gid找到缩略图
       $img = Goods_thumb::where('gid',$gid)->get();
        //通过sid找到哪家商铺
         $shop = Shop::where('sid',$data->sid)->get();
//        商品规格分类
         $type = Goods_attribute::where('goods_id',$goods_id)->get();
        $name = explode(' ',$type[0]->value);
        if(isset($type[1])){
            $size = explode(' ',$type[1]->value);
        }
//        dd($type);
//        得到商品价格
          $price = Goods_type::where(['goods_id'=>$goods_id,'gid'=>$gid])->get();
        //推荐部分
         $related = Goods_type::where('cid',$price[0]->cid)->take(5)->orderBy('updated_at','desc')->get();
//        看了又看
        $hot = Goods_type::where('cid',$price[0]->cid)->take(2)->orderBy('updated_at','asc')->get();
//
        return view('home.equipment.goodsdetals',compact('data','img','shop','price','related','hot','nav','adress','name','size','type'));
    }
    public function getThirdshop()
    {
        return view('home.equipment.thirdparty');
    }
}
