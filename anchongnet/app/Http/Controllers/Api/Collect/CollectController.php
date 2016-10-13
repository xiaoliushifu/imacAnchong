<?php

namespace App\Http\Controllers\Api\Collect;

use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

/*
*   该控制器包含了收藏模块
*/
class CollectController extends Controller
{
    /*
    *   收藏商品或商铺
    */
    public function addcollect(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //创建ORM模型
            $collection=new \App\Collection();
            //判断是否已收藏
            $num=$collection->quer('users_id = '.$data['guid'].' and coll_id ='.$param['coll_id'].' and coll_type='.$param['coll_type']);
            if($num > 0){
                return response()->json(['serverTime'=>time(),'ServerNo'=>15,'ResultData'=>['Message'=>'非法操作']]);
            }
            $collection_data=[
                "users_id" => $data['guid'],
                "coll_id" => $param['coll_id'],
                "created_at" => date('Y-m-d H:i:s',$data['time']),
                "coll_type" => $param['coll_type']
            ];
            $result=$collection->add($collection_data);
            if($result) {
                if($param['coll_type']==2){
                    DB::table('anchong_shops')->where('sid','=',$param['coll_id'])->increment('collect',1);
                }
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'收藏成功']]);
            }else {
                return response()->json(['serverTime'=>time(),'ServerNo'=>15,'ResultData'=>['Message'=>'收藏失败']]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   取消收藏商品或商铺
    */
    public function delcollect(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //创建ORM模型
            $collection=new \App\Collection();
            $result=$collection->del('users_id='.$data['guid'].' and coll_id ='.$param['coll_id'].' and coll_type='.$param['coll_type']);
            if($result) {
                if($param['coll_type']==2){
                    DB::table('anchong_shops')->where('sid','=',$param['coll_id'])->decrement('collect',1);
                }
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'取消成功']]);
            }else {
                return response()->json(['serverTime'=>time(),'ServerNo'=>15,'ResultData'=>['Message'=>'取消失败']]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   收藏商品显示
    */
    public function goodscollect(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //创建ORM模型
            $collection=new \App\Collection();
            $goods_specifications=new \App\Goods_specifications();
            //先查询该用户收藏的商品ID
            $result=$collection->querinfo('coll_id','users_id ='.$data['guid'].' and coll_type=1')->toArray();
            if(empty($result)){
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>[]]);
            }
            //定义结果数组
            $results=null;
            //通过遍历取出所有收藏商品的信息
            foreach ($result as $resultarr) {
                $goodsresult=$goods_specifications->quer(['gid','title','goods_img','market_price','goods_id'],'gid ='.$resultarr['coll_id'])->toArray();
                //假如货品没有被删除
                if(!empty($goodsresult)){
                    $results[]=$goodsresult[0];
                }
            }
            if(!empty($results)){
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$results]);
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>[]]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   收藏的商铺显示
    */
    public function shopscollect(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //创建ORM模型
            $collection=new \App\Collection();
            $shop=new \App\Shop();
            //先查询该用户收藏的商品ID
            $result=$collection->querinfo('coll_id','users_id ='.$data['guid'].' and coll_type=2')->toArray();
            if(empty($result)){
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>[]]);
            }
            //定义结果数组
            $results=null;
            //通过遍历取出所有收藏商品的信息
            foreach ($result as $resultarr) {
                $shopsresult=$shop->quer(['sid','name','img','collect'],'sid ='.$resultarr['coll_id'])->toArray();
                //将商铺信息插入数组
                $results[]=$shopsresult[0];
            }
            if(!empty($results)){
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$results]);
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>15,'ResultData'=>['Message'=>'查询失败，请刷新']]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }
}
