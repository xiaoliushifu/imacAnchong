<?php

namespace App\Http\Controllers\Api\Collect;

use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

/*
*   该控制器包含了收藏模块
*/
class CollectController extends Controller
{
    /*
    *   收藏
    */
    public function addcollect(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //创建ORM模型
        $collection=new \App\Collection();
        $collection_data=[
            "users_id" => $data['guid'],
            "coll_id" => $param['coll_id'],
            "created_at" => date('Y-m-d H:i:s',$data['time']),
            "coll_type" => $param['coll_type']
        ];
        $result=$collection->add($collection_data);
        if($result) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'收藏成功']]);
        }else {
            return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'收藏失败']]);
        }
    }

    /*
    *   取消收藏
    */
    public function delcollect(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //创建ORM模型
        $collection=new \App\Collection();
        $result=$collection->del('users_id='.$data['guid'].' and coll_id ='.$param['coll_id'].' and coll_type='.$param['coll_type']);
        if($result) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'取消成功']]);
        }else {
            return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'取消失败']]);
        }
    }
}
