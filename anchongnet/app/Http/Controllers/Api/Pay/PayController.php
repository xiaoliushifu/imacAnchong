<?php

namespace App\Http\Controllers\\Api\Pay;

use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

/*
*   支付控制器
*/
class PayController extends Controller
{
    /*
    *   该方法是支付宝的支付接口
    */
    public function alipayindex(Request $request)
    {
        $data=$request::all();
        $param=json_decode($data,true);
        //分页限制
        $limit=20;
        //创建ORM模型
        $Auth=new Auth();
        $auth_data=['action','price','goods_name','img','detail','pic'];
        $result=$Auth->quer($auth_data,$sql,$limit);
        if($result){
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$result]);
        }elseif($result['action']){
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$result['action']]);
        }elseif($result['list']){
            return response()->json(['serverTime'=>time(),'ServerNo'=>16,'ResultData'=>['Message'=>"支付失败"]])
        }
        $list=trim($this->request);
        $list += $limit * $param['page'] - 1;
        $foreach=[
            'price' => $param['price'],
            'goods_name' => $param['goods_name'],
            'goods_id' => $param['goods_id'],
            'gid' => $param['gid'],
            'title' => $param['title'],
            'img' => $param['img']
        ];
        $results=$Auth->add($foreach);
    }
}
