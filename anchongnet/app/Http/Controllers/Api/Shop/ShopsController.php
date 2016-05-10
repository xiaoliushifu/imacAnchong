<?php

namespace App\Http\Controllers\Api\Shop;

use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

/*
*   该控制器包含了商铺模块的操作
*/
class ShopsController extends Controller
{
    /*
    *   商铺查看
    */
    public function goodsshow(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //默认每页数量
        $limit=10;
        //创建ORM模型
        $goods_specifications=new \App\Goods_specifications();
        //定义查询的字段
        $goods_specifications_data=['gid','goods_img','title','goods_price','vip_price','sales','goods_num'];
        $result=$goods_specifications->limitquer($goods_specifications_data,'sid ='.$param['sid'].' and added ='.$param['added'],(($param['page']-1)*$limit),$limit);
        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$result]);
    }

    /*
    *   商铺货品操作
    */
    public function goodsaction(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //判断用户操作
        if($param['action'] == 1){
            //创建ORM模型
            $goods_specifications=new \App\Goods_specifications();
            $result=$goods_specifications->specupdate($param['gid'],['added' => $param['added']]);
            if($result){
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'商品操作成功']]);
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>14,'ResultData'=>['Message'=>'商品操作失败']]);
            }
        }elseif($param['action'] == 2){
            //创建ORM模型
            $goods_specifications=new \App\Goods_specifications();
            $goods_type=new \App\Goods_type();
            $goods_thumb=new \App\Goods_thumb();
            //开启事务处理
            DB::beginTransaction();
            //删除货品表的数据
            $specresult=$goods_specifications->del($param['gid']);
            if($specresult){
                //删除goods_type表的数据
                $typeresult=$goods_type->del($param['gid']);
                if($typeresult){
                    //删除该货品的主图
                    $thumbresult=$goods_thumb->del($param['gid']);
                    if($thumbresult){
                        //假如成功就提交
                        DB::commit();
                        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'删除成功']]);
                    }else{
                        //假如失败就回滚
                        DB::rollback();
                        return response()->json(['serverTime'=>time(),'ServerNo'=>14,'ResultData'=>['Message'=>'商品删除失败']]);
                    }
                }else{
                    //假如失败就回滚
                    DB::rollback();
                    return response()->json(['serverTime'=>time(),'ServerNo'=>14,'ResultData'=>['Message'=>'商品删除失败']]);
                }
            }else{
                //假如失败就回滚
                DB::rollback();
                return response()->json(['serverTime'=>time(),'ServerNo'=>14,'ResultData'=>['Message'=>'商品删除失败']]);
            }
        }
    }

    /*
    *   该方法提供订单查看
    */
    public function shopsorder(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //默认每页数量
        $limit=10;
        //创建ORM模型
        $order=new \App\Order();
        $orderinfo=new \App\Orderinfo();
        //判断用户行为
        switch ($param['state']) {
            //0为全部订单
            case 0:
                $sql='sid ='.$param['sid'];
                break;
            //1为待付款
            case 1:
                $sql='sid ='.$param['sid'].' and state ='.$param['state'];
                break;
            //2为待发货
            case 2:
                $sql='sid ='.$param['sid'].' and state ='.$param['state'];
                break;
            //3为退款
            case 3:
                $sql='sid ='.$param['sid'].' and state in(4,5)';
                break;
            default:
                return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'用户行为异常']]);;
                break;
        }
        //定于查询数据
        $order_data=['order_id','order_num','state','created_at','total_price','name','phone','address','invoice','customer','tname'];
        $orderinfo_data=['goods_name','goods_num','goods_price','goods_type','img'];
        //查询该用户的订单数据
        $order_result=$order->quer($order_data,$sql,(($param['page']-1)*$limit),$limit);
        if($order_result['total'] == 0){
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$order_result]);
        }
        //最终结果
        $result=null;
        //查看该用户订单的详细数据精确到商品
        foreach ($order_result['list'] as $order_results) {
            //根据订单号查到该订单的详细数据
            $orderinfo_result=$orderinfo->quer($orderinfo_data,'order_num ='.$order_results['order_num'])->toArray();
            //将查询结果组成数组
            $order_results['goods']=$orderinfo_result;
            $result[]=$order_results;
            $order_results=null;
        }
        if(!empty($result)){
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['total'=>$order_result['total'],'list'=>$result]]);
        }else{
            response()->json(['serverTime'=>time(),'ServerNo'=>14,'ResultData'=>['Message'=>'订单查询失败']]);
        }
    }
}
