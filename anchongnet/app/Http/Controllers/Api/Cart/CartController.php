<?php

namespace App\Http\Controllers\Api\Cart;

//use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Request;
use Validator;
use DB;
use Cache;

/*
*   操作购物车的控制器
*/
class CartController extends Controller
{
    /*
    *   购物车添加
    */
    public function cartadd(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //创建购物车的ORM模型
            $cart=new \App\Cart();
            //判断商品是否在购物车
            $gid_num=$cart->quer(['goods_num','cart_id'],'users_id = '.$data['guid'].' and gid ='.$param['gid'])->toArray();
            //看是否有数据如果存在就合并
            if(!empty($gid_num)){
                //商品数量
                $goodsnum=[
                    'goods_num' => $param['goods_num']+$gid_num[0]['goods_num'],
                    'oem' => $param['oem'],
                    'goods_price' => $param['goods_price'],
                    'promotion' => $param['promotion'],
                ];
                //更新商品数量
                $result=$cart->cartupdate($gid_num[0]['cart_id'],$goodsnum);
            }else{
                try{
                    //用户传过来的数据
                    $cart_data=[
                        'users_id' => $data['guid'],
                        'goods_name' => $param['goods_name'],
                        'goods_num' => $param['goods_num'],
                        'goods_price' => $param['goods_price'],
                        'goods_type' => $param['goods_type'],
                        'img' => $param['img'],
                        'gid' => $param['gid'],
                        'created_at' => date('Y-m-d H:i:s',$data['time']),
                        'sid' => $param['sid'],
                        'sname' => $param['sname'],
                        'goods_id' => $param['goods_id'],
                        'oem' => $param['oem'],
                        'promotion' => $param['promotion']
                    ];
                }catch (\Exception $e) {
                    //用户传过来的数据
                    $cart_data=[
                        'users_id' => $data['guid'],
                        'goods_name' => $param['goods_name'],
                        'goods_num' => $param['goods_num'],
                        'goods_price' => $param['goods_price'],
                        'goods_type' => $param['goods_type'],
                        'img' => $param['img'],
                        'gid' => $param['gid'],
                        'created_at' => date('Y-m-d H:i:s',$data['time']),
                        'sid' => $param['sid'],
                        'sname' => $param['sname'],
                        'goods_id' => $param['goods_id'],
                        'oem' => $param['oem']
                    ];
                }
                $result=$cart->add($cart_data);
            }
            //看是否插入成功
            if($result){
                //如果成功就返回添加购物车成功
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'购物车添加成功！']]);
            }else{
                //如果失败就返回错误信息
                return response()->json(['serverTime'=>time(),'ServerNo'=>11,'ResultData'=>['Message'=>'购物车添加失败！']]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   购物车查看
    */
    public function cartinfo(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //创建购物车和商铺的ORM模型
            $shop=new \App\Shop();
            $cart=new \App\Cart();
            //定义查询的数组
            $cart_data=['cart_id','goods_name','goods_num','goods_price','img','goods_type','gid','sid','sname','goods_id','oem','promotion'];
            //得到结果
            $results=$cart->quer($cart_data,'users_id = '.$data['guid'])->toArray();
            //假如购物车无数据
            if(empty($results)){
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$results]);
            }
            //下面装商铺的数组
            $shoparr=null;
            //下面装商品的数组
            $goodsarr=null;
            //下面装购物车详情的数组
            $cartarr=null;
            //通过下列一系列的方法将数据格式转换成特定的格式，详见接口文档
            foreach ($results as $result) {
                $shoparr[$result['sname']]=$result['sid'];
            }
            foreach ($shoparr as $sname => $sid) {
                foreach ($results as $goods) {
                    if($goods['sid'] == $sid){
                        $goodsarr[]=$goods;
                    }
                }
                //查出运费和需要运费的价格
                $freight=$shop->quer(['free_price','freight'],'sid ='.$sid)->toArray();
                //将数据拼装到一个数组中
                $cartarr[]=['sid'=>$sid,'free_price'=>$freight[0]['free_price'],'freight'=>$freight[0]['freight'],'sname' => $sname,'goods'=>$goodsarr];
                $goodsarr=null;
            }
            if(!empty($cartarr)){
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$cartarr]);
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>11,'ResultData'=>['Message'=>'购物车查询失败']]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   购物车数量加减
    */
    public function cartnum(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //创建ORM模型
            $cart=new \App\Cart();
            //传过来的现在的数量
            $cart_data=[
                'goods_num'=>$param['goods_num'],
            ];
            //更新数据
            $result=$cart->cartupdate($param['cart_id'],$cart_data);
            if($result){
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'商品数量加减成功']]);
            }else {
                return response()->json(['serverTime'=>time(),'ServerNo'=>11,'ResultData'=>['Message'=>'商品数量加减失败']]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   对购物车物品做删除
    */
    public function cartdel(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //创建ORM模型
            $cart=new \App\Cart();
            //进行购物车删除
            $result=$cart->cartdel($param['cart_id']);
            //判断是否删除成功
            if($result){
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'商品删除成功']]);
            }else {
                return response()->json(['serverTime'=>time(),'ServerNo'=>11,'ResultData'=>['Message'=>'商品删除失败']]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   购物车数量统计
    */
    public function cartamount(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //创建ORM模型
            $cart=new \App\Cart();
            $amount=$cart->cartamount('goods_num','users_id ='.$data['guid'])->toArray();
            $cartnum=0;
            foreach($amount as $goods_num) {
                $cartnum += $goods_num['goods_num'];
            }
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['cartamount'=>$cartnum]]);
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   购物车分享
    */
    public function cartshare(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $shareId=md5($data['param']);
        //判断是否已被分享
        $share_cache=Cache::get('cartshare:'.$shareId);
        //如果被分享了那么直接返回
        if($share_cache){
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['url'=>'http://www.anchong.net/cartshare/'.$shareId]]);
        }
        $param=json_decode($data['param'],true);
        //创建购物车的ORM模型
        $cart=new \App\Cart();
        //判断是否为空
        if(!$param['cart']){
            return response()->json(['serverTime'=>time(),'ServerNo'=>11,'ResultData'=>['Message'=>'未选中任何商品']]);
        }
        $cartdata=$cart->Cart()->select('goods_name','goods_price','img','goods_type','gid','sid','sname','goods_id','oem','goods_num','promotion')->whereIn('cart_id',$param['cart'])->get()->toArray();
        //将查询结果加入缓存
        $result=Cache::add('cartshare:'.$shareId, $cartdata, 10080);
        if($result){
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['url'=>'http://www.anchong.net/cartshare/'.$shareId]]);
        }else {
            return response()->json(['serverTime'=>time(),'ServerNo'=>11,'ResultData'=>['Message'=>'分享失败']]);
        }
    }
}
