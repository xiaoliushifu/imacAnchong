<?php

namespace App\Http\Controllers\Home\Equipment;
use App\Brand;
use App\Category;
use App\Goods;
use App\Goods_attribute;
use App\Goods_thumb;
use App\Goods_type;
use App\Http\Controllers\Home\CommonController;
use App\Shop;
use App\Http\Requests;
use Cache;
use Illuminate\Support\Facades\Input;
class EquipmentController extends CommonController
{
    public function getIndex()
    {

//金牌店铺
        $brand = Cache::remember('brand',10,function(){
            return Brand::orderBy('brand_id','asc')->take(4)->get();
        });
//住导航
        $nav = Cache::remember('nav',10,function(){
           return  Category::orderBy('cat_id','asc')->take(8)->get();
        });

//取出所有符合数据
        $all = Cache::remember('alll',10,function(){
          return Category::where('parent_id','!=',0)->where('is_show','=',1)->get();


        });
//1f导航
        $one = $all->where('parent_id',1);
        $nav1 = $all->where('parent_id',1)->take(7);
//2f导航
        $two =  $all->where('parent_id',2);
        $nav2 =$two->take(6);
//3f 导航
        $three = $all->where('parent_id',3);
        $nav3 = $three->take(5);
//4f 导航
        $four =  $all->where('parent_id',4);
        $nav4 = $four->take(4);
//5f 导航
        $five =  $all->where('parent_id',5);
        $nav5 = $five->take(6);
//6f 导航
        $six =  $all->where('parent_id',6);
        $nav6 =  $six->take(7);
//7f 导航
        $seven =  $all->where('parent_id',7);
        $nav7 = $seven->take(7);
//8f 导航
        $eight =  $all->where('parent_id',8);
        $nav8 = $eight->take(7);

        return view('home.equipment.equipshopping',compact('brand','nav','one',
            'nav1','nav2','two','nav3','three','nav4','four','nav5','five','nav6','six','nav7','seven','nav8','eight','test','all'));
   }

    public function getList($cat_id)
   {
//住导航
        $navll = Cache::remember('nav',10,function(){
            return  Category::orderBy('cat_id','asc')->take(8)->get();
        });
//所在位置
        $eqlistaddress = Cache::remember('eqlistaddress',10,function() use($cat_id){
            return   Category::find($cat_id);
        });
        $eqlist = Input::get(['page']);
      if($cat_id<9){

             $eqlistmain = Cache::remember('eqlistmain'.$cat_id.$eqlist,10,function() use($cat_id){
                 return  Goods_type::where('other_id',$cat_id)->orderBy('cat_id','desc')->paginate(16);
             });

      }else{

          $aa = bin2hex($cat_id);
          $det = Cache::remember('det'.$cat_id.$eqlist,10,function() use($aa){
              return Goods_type::whereRaw("match(`cid`)against(?)",[$aa])->paginate(16);
          });
      }
     return view('home.equipment.goodslist',compact('eqlistmain','navll','eqlistaddress','det','cat_id'));
    }
    public function getShow($goods_id,$gid)
    {
//住导航
        $nav = Cache::remember('nav',10,function(){
            return  Category::orderBy('cat_id','asc')->take(8)->get();
        });
//通过goods_id商品详情
        $data = Cache::remember('goodsdetail'.$goods_id,10,function() use($goods_id){
            return Goods::find($goods_id);
        });
//通过$gid找到缩略图
        $img = Cache::remember('goodsimg'.$gid,10,function() use($gid){
        return  Goods_thumb::where('gid',$gid)->get();
    });
 //通过sid找到哪家商铺
        $shop = Cache::remember('goodshop'.$gid,10,function() use($data){
           return  Shop::where('sid',$data->sid)->get();
        });

//商品规格分类
        $type = Cache::remember('goodstp'.$goods_id,10,function() use($goods_id){
            return  Goods_attribute::where('goods_id',$goods_id)->get();
        });
        $name = explode(' ',$type[0]->value);
        if(isset($type[1])){

            $size = explode(' ',$type[1]->value);
        }
//得到商品价格
        $price = Cache::remember('goodsprice'.$gid,10,function() use($goods_id,$gid){
           return  Goods_type::where(['goods_id'=>$goods_id,'gid'=>$gid])->get();
        });
//推荐部分
        $related = Cache::remember('goodsre'.$gid,10,function() use($price){
           return   Goods_type::where('cid',$price[0]->cid)->take(5)->orderBy('updated_at','desc')->get();
        });
//看了又看
        $hot = Cache::remember('goodshot'.$gid,10,function() use($price){
           return   Goods_type::where('cid',$price[0]->cid)->take(2)->orderBy('updated_at','asc')->get();
        });

        return view('home.equipment.goodsdetals',compact('data','img','shop','price','related','hot','nav','adress','name','size','type'));
    }
    public function getThirdshop($sid)
    {
//住导航
        $navthird = Cache::remember('navthird',10,function(){
           return Category::orderBy('cat_id','asc')->take(8)->get();
        });
        $page = Input::get(['page']);
          $thirdlist = Cache::remember('thirdlist'.$page,10,function() use ($sid){
         return  Goods_type::where('sid',$sid)->orderBy('updated_at','desc')->paginate(16);
       });
        return view('home.equipment.thirdparty',compact('thirdlist','navthird','sid'));
    }
}
