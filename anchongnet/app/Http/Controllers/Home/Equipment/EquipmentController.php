<?php

namespace App\Http\Controllers\Home\Equipment;
use Auth;
use App\Ad;
use App\Category;
use App\Goods;
use App\Goods_attribute;
use App\Goods_oem;
use App\Goods_thumb;
use App\Goods_type;
use App\Goods_specifications;
use App\Http\Controllers\Home\CommonController;
use App\Shop;
use Cache;
use DB;
use Request;
use Illuminate\Support\Facades\Input;
class EquipmentController extends CommonController
{
    public function getIndex()
    {
        //金牌店铺
        $goldshops = Cache::remember('goldshops',1440,function(){
            return Ad::whereIn('ad_id',[17,18,19,26])->get(['ad_code','ad_link']);
        });
        //热卖单品
        $hotlist = Cache::remember('hotlist',1440,function(){
            return Ad::whereIn('ad_id',[22,23,24,25])->get(['ad_code','ad_link','ad_name']);
        });
        //最新上架
        $newgoods = Cache::remember('newgoods',1440,function(){
            return Ad::whereIn('ad_id',[13,14,15,16])->get(['ad_code','ad_link','ad_name']);
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
        return view('home.equipment.equipshopping',compact('goldshops','hotlist','newgoods','nav','one',
            'nav1','nav2','two','nav3','three','nav4','four','nav5','five','nav6','six','nav7','seven','nav8','eight','test','all'));
   }

   /**
    * 排序s
    * 分页p
    * 查询q(略)
    * @param unknown $cat_id
    */
   public function getList($cat_id)
   {
        //所在位置
        $eqlistaddress = Cache::remember('eqlistaddress'.$cat_id,10,function() use($cat_id){
            return   Category::find($cat_id);
        });
        if (!$eqlistaddress) {
            abort(404);
        }
        //8大类导航
        $navll = Cache::remember('nav',1440,function() {
            return  Category::orderBy('cat_id','asc')->take(8)->get();
        });
        $p = Input::get(['page']);
        $s = Input::get(['s']);
        $orderby=['a'=>['cat_id','desc'],'s'=>['sales','desc'],'pu'=>['price','asc'],'pd'=>['price','desc']];
        if (!in_array($s,array_keys($orderby))) {
            $s='a';
        }
        $eqlistaddress->s=$s;
       //8大类
      if ($cat_id<9) {
          $eqlistmain = Cache::remember('eqlistmain'.$cat_id.$p.$s,10,function() use($cat_id, $orderby,$s) {
              return  Goods_type::where('other_id',$cat_id)->orderBy($orderby[$s][0],$orderby[$s][1])->paginate(16);
          });
      //非8大类
      } else {
          $eqlistmain = Cache::remember('det'.$cat_id.$p.$s,10,function() use($cat_id,  $orderby,$s) {
              return Goods_type::whereRaw("match(`cid`) against(?)",[bin2hex($cat_id)])->orderBy($orderby[$s][0],$orderby[$s][1])->paginate(16);
          });
      }
     return view('home.equipment.goodslist',compact('eqlistmain','navll','eqlistaddress','cat_id'));
    }

    /**
     * PC搜索处理
     *关键处理 {para}
     *page分页
     *q 查询字符串
     *s 排序
     */
    public function getGs(Request $req)
    {
        //所在位置
        $cat_id =mt_rand(1,8);
        $page = $req::get('page');
        $eqlistaddress = Cache::remember('eqlistaddress'.$cat_id,10,function() use($cat_id){
            return   Category::find($cat_id);
        });
        //8大类导航
        $navll = Cache::remember('nav',1440,function(){
            return  Category::orderBy('cat_id','asc')->take(8)->get();
        });
        //整理查询参数
        $at = preg_split('#\s#',strtoupper($req::input('q')),-1,PREG_SPLIT_NO_EMPTY);
        $oristr = implode(' ',$at);
        $sp = bin2hex($oristr);
        $eqlistaddress->cat_name=$oristr;
        
        //排序处理
        $s = Input::get(['s']);
        $orderby=['a'=>['cat_id','desc'],'s'=>['sales','desc'],'pu'=>['price','asc'],'pd'=>['price','desc']];
        if (!in_array($s,array_keys($orderby))) {
            $s='a';
        }
        $eqlistaddress->s=$s;
        //缓存失效否？
        if (!$eqlistmain = Cache::tags('s')->get("PCsearch@$page".$sp.$s)) {//页+搜索词+排序
            \Log::info($oristr,["PCsearch@$page".$sp]);//统计
            $where="match(`keyword`) against('".str_replace('20',' ',$sp)."')";
            $tmp=DB::table('anchong_goods_keyword')->whereRaw($where)->pluck('cat_id');
            //var_dump($tmp,DB::getQueryLog());
            if (!$tmp) {
                //for no，using random cat_id search
                $eqlistmain = Cache::remember('eqlistmain'.$cat_id,10,function()  use($cat_id, $orderby,$s){
                    return  Goods_type::where('other_id',$cat_id)->orderBy($orderby[$s][0],$orderby[$s][1])->paginate(16);
                });
                return view('home.equipment.goodslist',compact('eqlistmain','navll','eqlistaddress','cat_id'));
            }
            //要查询的字段
            //$goods_data=['gid','title','price','sname','pic','vip_price','goods_id'];
            //已上架added=1
            $eqlistmain = DB::table('anchong_goods_type')->whereIn('cat_id',$tmp)->where('added',1)->orderBy($orderby[$s][0],$orderby[$s][1])->orderBy('gid','desc')->paginate(16);
            //无结果
            if (!$eqlistmain) {
                //无结果说明索引已失效，删除之
                DB::table("anchong_goods_keyword")->whereIn('cat_id',$tmp)->delete();
                //for no2，using random cat_id search
                $eqlistmain = Cache::remember('eqlistmain'.$cat_id,10,function()  use($cat_id, $orderby, $s){
                    return  Goods_type::where('other_id',$cat_id)->orderBy($orderby[$s][0],$orderby[$s][1])->paginate(16);
                });
                return view('home.equipment.goodslist',compact('eqlistmain','navll','eqlistaddress','cat_id'));
            }
            \Log::info($eqlistmain->total(),["PCsearch@$page".$oristr.$s]);//统计
            //有结果，缓存之
            Cache::tags('s')->add("PCsearch@$page".$sp.$s,$eqlistmain,'60');
        }
        return view('home.equipment.goodslist',compact('eqlistmain','navll','eqlistaddress','cat_id'));
    }
    
    
    //商品详情查看
    public function getShow($goods_id=null,$gid=null)
    {
        if (is_null($goods_id) || is_null($gid)) {
            abort(404);
        }
        //通过goods_id商品详情
        $data = Cache::remember('goodsdetail'.$goods_id,10,function() use($goods_id){
            return Goods::find($goods_id);
        });
        if (!$data) {
            abort(404);
        }
        //oem 选择
        $oem = Cache::remember('oem'.$goods_id,10, function() use($goods_id){
            return Goods_oem::where('goods_id',$goods_id)->first();
        });
        if(!empty($oem)){
            $oemvalue = explode(' ',$oem->value);
        }
        //商品属性
        $attrs = Cache::remember('goodstp'.$goods_id,10,function() use($goods_id){
            return  Goods_attribute::where('goods_id',$goods_id)->get();
        });
        //通过$gid找到缩略图
        $img = Cache::remember('goodsimg'.$gid,10,function() use($gid){
            return  Goods_thumb::where('gid',$gid)->get();
        });
        //通过sid找到哪家商铺
        $shop = Cache::remember('goodshop'.$gid,10,function() use($data){
            return  Shop::where('sid',$data->sid)->get();
        });
        //得到商品价格
        $price = Cache::remember('goodsprice'.$gid,10,function() use($goods_id,$gid){
            return  Goods_specifications::where(['goods_id'=>$goods_id,'gid'=>$gid])->get();
        });
        if($price->isEmpty()) {
            abort(404);
        }
        //主导航
        $nav = Cache::remember('nav',10,function(){
            return  Category::orderBy('cat_id','asc')->take(8)->get();
        });
        //推荐部分
        $related = Cache::remember('goodsre'.$gid.$goods_id,10,function() use($price){
            return   Goods_type::where('cid',$price[0]->cid)->take(5)->orderBy('updated_at','desc')->get();
        });
        //看了又看
        $hot = Cache::remember('goodshot'.$gid.$goods_id,10,function() use($price){
           return   Goods_type::where('cid',$price[0]->cid)->take(2)->orderBy('updated_at','asc')->get();
        });
        return view('home.equipment.goodsdetals',compact('data','img','shop','price','related','hot','nav','adress','attrs','type','goodsauth','oemvalue'));
    }
    
    /**
     * 
     * @param unknown $sid
     */
    public function getThirdshop($sid=null)
    {
        if (is_null($sid)) {
            abort(404);
        }
        //住导航
        $navthird = Cache::remember('navthird',10,function() {
           return Category::orderBy('cat_id','asc')->take(8)->get();
        });
        $page = Input::get(['page']);
          $thirdlist = Cache::remember('thirdlist'.$sid.$page,10,function() use ($sid){
         return  Goods_type::where('sid',$sid)->orderBy('updated_at','desc')->paginate(16);
       });
        return view('home.equipment.thirdparty',compact('thirdlist','navthird','sid'));
    }
    
    /**
     * 用于切换商品属性时，实时更新详情页数据
     * @param Request $req
     */
    public function getGoodspe(Request $req)
    {
        $user = Auth::user();
        if (!$user) {
            return ['msg'=>'请登录后再添加购物车'];
        }
        if(!$req::ajax()){
            return ['msg'=>'请登录后再添加购物车'];
        }
        $param = $req::all();
        $goods_specifications=new \App\Goods_specifications();
        $goods_specifications_data=['gid','goods_img','goods_name','market_price','vip_price','promotion_price','title'];
        //该商品下的所有货品
        $results=$goods_specifications->quer($goods_specifications_data,'goods_id = '.$param['goodid'])->toArray();
        //规格匹配
        foreach ($results as $value) {
            if(strstr($value['goods_name'],trim($param['gn']))){
                //thumb暂不
                //是否认证
                $value['ur']=$user['user_rank'];
                return $value;
            }
        }
        return ['msg'=>'商品无库存，请选择其他规格商品'];
    }
    
}
