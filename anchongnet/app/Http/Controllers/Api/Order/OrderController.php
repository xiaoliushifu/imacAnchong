<?php

namespace App\Http\Controllers\Api\Order;

//use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Request;
use Validator;
use DB;

/*
*   该控制器包含了订单模块的操作
*/
class OrderController extends Controller
{
    /*
    *   该方法提供了订单生成的功能
    */
    public function ordercreate(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        $true=false;
        //开启事务处理
        DB::beginTransaction();
        //遍历传过来的订单数据
        foreach ($param['list'] as $orderarr) {
            $order_num=rand(00,99).substr($data['guid'],0,1).time();
            $order_data=[
                'order_num' => $order_num,
                'users_id' => $data['guid'],
                'sid' => $orderarr['sid'],
                'sname' => $orderarr['sname'],
                'created_at' => date('Y-m-d H:i:s',$data['time'])
            ];
            //创建购物车的ORM模型
            $order=new \App\Order();
            //插入数据
            $result=$order->add($order_data);
            //如果成功
            if($result){
                foreach ($orderarr['goods'] as $goodsinfo) {
                    $orderinfo_data=[
                        'order_num' =>$order_num,
                        'goods_name' => $goodsinfo['goods_name'],
                        'goods_num' => $goodsinfo['goods_num'],
                        'goods_price' => $goodsinfo['goods_price'],
                        'goods_type' => $goodsinfo['goods_type'],
                        'pic' => $goodsinfo['pic']
                    ];
                    //创建购物车的ORM模型
                    $orderinfo=new \App\Orderinfo();
                    //插入数据
                    $order_result=$orderinfo->add($orderinfo_data);
                    if($order_result){
                        $true=true;
                    }else{
                        //假如失败就回滚
                        DB::rollback();
                        return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'订单生成失败']]);
                    }
                }
            }else{
                //假如失败就回滚
                DB::rollback();
                return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'订单生成失败']]);
            }
        }
        if($true){
            //假如成功就提交
            DB::commit();
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'订单生成成功']]);
        }else{
            //假如失败就回滚
            DB::rollback();
            return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'订单生成失败']]);
        }
    }

    /*
    *   该方法提供订单查看
    */
    public function orderinfo(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //创建ORM模型
        $order=new \App\Order();
        $orderinfo=new \App\Orderinfo();
        //判断用户行为
        switch ($param['state']) {
            //0为全部订单
            case 0:
                $sql='users_id ='.$data['guid'];
                break;
            //1为待付款
            case 1:
                $sql='users_id ='.$data['guid'].' and state ='.$param['state'];
                break;
            //2为待发货
            case 2:
                $sql='users_id ='.$data['guid'].' and state ='.$param['state'];
                break;
            //3为退款
            case 3:
                $sql=$sql='users_id ='.$data['guid'].' and state in(4,5)';
                break;
            default:
                return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'用户行为异常']]);;
                break;
        }
        //定于查询数据
        $order_data=['order_id','order_num','sid','sname','state','created_at'];
        $orderinfo_data=['goods_name','goods_num','goods_price','goods_type','pic'];
        //查询该用户的订单数据
        $order_result=$order->quer($order_data,$sql)->toArray();
        if(empty($order_result)){
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$order_result]);
        }
        //最终结果
        $result=null;
        //查看该用户订单的详细数据精确到商品
        foreach ($order_result as $order_results) {
            //根据订单号查到该订单的详细数据
            $orderinfo_result=$orderinfo->quer($orderinfo_data,'order_num ='.$order_results['order_num'])->toArray();
            //将查询结果组成数组
            $order_results['goods']=$orderinfo_result;
            $result[]=$order_results;
            $order_results=null;
        }
        if(!empty($result)){
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$result]);
        }else{
            response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>"订单查询失败"]);
        }
    }
}
