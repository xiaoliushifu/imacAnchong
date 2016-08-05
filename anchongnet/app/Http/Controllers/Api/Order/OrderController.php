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
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            $true=false;
            //开启事务处理
            DB::beginTransaction();
            //支付单号
            $paynum=rand(100000,999999).time();
            //支付总价
            $total_price=0;
            //支付详细信息描述
            $body="";
            //遍历传过来的订单数据
            foreach ($param['list'] as $orderarr) {
                //查出该订单生成的联系人姓名
                $usermessages=new \App\Usermessages();
                $name=$usermessages->quer('contact',['users_id'=>$data['guid']]);
                if(empty($name[0]['contact'])){
                    //假如失败就回滚
                    DB::rollback();
                    return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'请先填写个人资料里面的联系人']]);
                }
                //查出该店铺客服联系方式
                $customer=new \App\Shop();
                $customers=$customer->quer('customer',"sid =".$orderarr['sid'])->toArray();
                //如果店铺客服为空，则指定一个值不能让他报错
                if(empty($customers)){
                    //假如失败就回滚
                    DB::rollback();
                    return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'订单生成失败']]);
                }
                $order_num=rand(10000,99999).substr($data['guid'],0,1).time();
                $total_price += $orderarr['total_price'];
                $order_data=[
                    'order_num' => $order_num,
                    'users_id' => $data['guid'],
                    'sid' => $orderarr['sid'],
                    'sname' => $orderarr['sname'],
                    'address' => $param['address'],
                    'name' => $param['name'],
                    'phone' => $param['phone'],
                    'total_price' => $orderarr['total_price'],
                    'created_at' => date('Y-m-d H:i:s',$data['time']),
                    'freight' => $orderarr['freight'],
                    'invoice' => $param['invoice'],
                    'customer' => $customers[0]['customer'],
                    'tname' => $name[0]['contact']
                ];
                //创建订单的ORM模型
                $order=new \App\Order();
                $cart=new \App\Cart();
                $pay=new \App\Pay();
                //插入数据
                $result=$order->add($order_data);
                //如果成功
                if($result){
                    $payresult=$pay->add(['paynum'=>$paynum,'order_id'=>$result,'total_price'=>$orderarr['total_price']]);
                    if($payresult){
                        foreach ($orderarr['goods'] as $goodsinfo) {
                            //创建货品表的ORM模型来查询货品数量
                            $goods_specifications=new \App\Goods_specifications();
                            $goods_num=$goods_specifications->quer(['title','goods_num','added','goods_numbering'],'gid ='.$goodsinfo['gid'])->toArray();
                            //判断商品是否以删除
                            if(empty($goods_num)){
                                //假如失败就回滚
                                DB::rollback();
                                return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>$goodsinfo['goods_name'].'商品已下架']]);
                            }
                            //判断商品是否下架
                            if($goods_num[0]['added'] == 1){
                            //判断总库存是否足够
                                if($goods_num[0]['goods_num'] >= $goodsinfo['goods_num']){
                                    $goodsnum=$goods_num[0]['goods_num']-$goodsinfo['goods_num'];
                                    //订单生产时更新库存
                                    $goodsnum_result=$goods_specifications->specupdate($goodsinfo['gid'],['goods_num' => $goodsnum]);
                                    DB::table('anchong_goods_stock')->where('gid','=',$goodsinfo['gid'])->decrement('region_num',$goodsinfo['goods_num']);
                                    if($goodsnum_result){
                                        $orderinfo_data=[
                                            'order_num' =>$order_num,
                                            'goods_name' => $goodsinfo['goods_name'],
                                            'goods_num' => $goodsinfo['goods_num'],
                                            'goods_price' => $goodsinfo['goods_price'],
                                            'goods_type' => $goodsinfo['goods_type'],
                                            'img' => $goodsinfo['img'],
                                            'goods_numbering' =>$goods_num[0]['goods_numbering'],
                                            'gid' => $goodsinfo['gid'],
                                        ];
                                        $body .=$goodsinfo['goods_name'].",";
                                        //创建购物车的ORM模型
                                        $orderinfo=new \App\Orderinfo();
                                        //插入数据
                                        $order_result=$orderinfo->add($orderinfo_data);
                                        if($order_result){
                                            $true=true;
                                            //同时删除购物车
                                            $resultdel=$cart->cartdel($goodsinfo['cart_id']);
                                            if($resultdel){
                                                $true=true;
                                            }else{
                                                $true=false;
                                            }
                                        }else{
                                            //假如失败就回滚
                                            DB::rollback();
                                            return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'订单生成失败']]);
                                        }
                                    }else{
                                        //假如失败就回滚
                                        DB::rollback();
                                        return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'订单生成失败']]);
                                    }
                                }else{
                                    //假如失败就回滚
                                    DB::rollback();
                                    return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>$goods_num[0]['title'].'库存不足，剩余库存'.$goods_num[0]['goods_num']]]);
                                }
                            }else{
                                //假如失败就回滚
                                DB::rollback();
                                return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>$goods_num[0]['title'].'已下架']]);
                            }
                        }
                    }else{
                        //假如失败就回滚
                        DB::rollback();
                        return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'订单生成失败']]);
                    }
                }else{
                    //假如失败就回滚
                    DB::rollback();
                    return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'订单生成失败']]);
                }
            }
            if($true && $total_price>0){
                //假如成功就提交
                DB::commit();
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['outTradeNo'=>$paynum,'totalFee'=>$total_price,'body'=>$body,'subject'=>"安虫商城订单支付",'notifyURLAlipay'=>'http://pay.anchong.net/pay/mobilenotify']]);
            }else{
                //假如失败就回滚
                DB::rollback();
                return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'订单生成失败']]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   该方法提供订单查看
    */
    public function orderinfo(Request $request)
    {
        try{
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
                //3为待收货
                case 3:
                    $sql='users_id ='.$data['guid'].' and state ='.$param['state'];
                    break;
                //4为退款
                case 4:
                    $sql='users_id ='.$data['guid'].' and state in(4,5)';
                    break;
                default:
                    return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'用户行为异常']]);;
                    break;
            }
            //定于查询数据
            $order_data=['order_id','order_num','sid','sname','state','created_at','total_price','name','phone','address','freight','invoice','customer'];
            $orderinfo_data=['goods_name','goods_num','goods_price','goods_type','img'];
            //查询该用户的订单数据
            $order_result=$order->quer($order_data,$sql,(($param['page']-1)*$limit),$limit);
            if($order_result['total'] == 0){
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$order_result]);
            }
            //最终结果
            $result=null;
            $body=null;
            //查看该用户订单的详细数据精确到商品
            foreach ($order_result['list'] as $order_results) {
                //根据订单号查到该订单的详细数据
                $orderinfo_result=$orderinfo->quer($orderinfo_data,'order_num ='.$order_results['order_num'])->toArray();
                //为取支付宝订单名
                foreach ($orderinfo_result as $orderinfo_goodsname) {
                    $body .=$orderinfo_goodsname['goods_name'];
                }
                //将查询结果组成数组
                $order_results['body']=$body;
                $order_results['goods']=$orderinfo_result;
                $result[]=$order_results;
                $order_results=null;
            }
            if(!empty($result)){
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['total'=>$order_result['total'],'list'=>$result]]);
            }else{
                response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'订单查询失败']]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   该方法提供订单操作
    */
    public function orderoperation(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //创建ORM模型
            $order=new \App\Order();
            //开启事务处理
            DB::beginTransaction();
            if($param['action'] == 8){
                //进行订单删除,web段的话需要确认订单状态
                $results=$order->orderdel($param['order_id']);
                if($results){
                    //创建ORM模型
                    $orderinfo=new \App\Orderinfo();
                    $result=$orderinfo->orderinfodel($param['order_num']);
                }else{
                    //假如失败就回滚
                    DB::rollback();
                    return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'删除订单失败']]);
                }
            }elseif($param['action'] == 6){
                //进行订单取消操作
                //获取订单句柄
                $order_handle=$order->find($param['order_id']);
                //判断是否已确认收货，防止无限刷库存
                if($order_handle->state == 6){
                    //假如失败就回滚
                    DB::rollback();
                    return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'操作失败']]);
                }else{
                    //更改订单状态
                    $order_handle->state=6;
                    $results=$order_handle->save();
                }
                if($results){
                    //创建ORM模型
                    $orderinfo=new \App\Orderinfo();
                    $order_gid=$orderinfo->quer(['gid','goods_num'],'order_num ='.$param['order_num'])->toArray();
                    foreach ($order_gid as $gid) {
                        $result=DB::table('anchong_goods_specifications')->where('gid','=',$gid['gid'])->increment('goods_num',$gid['goods_num']);
                        if($result){
                            DB::table('anchong_goods_stock')->where('gid','=',$gid['gid'])->increment('region_num',$gid['goods_num']);
                        }else{
                            //假如失败就回滚
                            DB::rollback();
                            return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'操作失败']]);
                        }
                    }
                }else{
                    //假如失败就回滚
                    DB::rollback();
                    return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'操作失败']]);
                }
            }elseif($param['action'] == 7){
                //确认收货操作
                //获取订单句柄
                $order_handle=$order->find($param['order_id']);
                //判断是否已确认收货，防止无限刷销量
                if($order_handle->state == 7){
                    //假如失败就回滚
                    DB::rollback();
                    return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'操作失败']]);
                }else{
                    //更改订单状态
                    $order_handle->state=7;
                    $results=$order_handle->save();
                }
                if($results){
                    //创建ORM模型
                    $orderinfo=new \App\Orderinfo();
                    $order_gid=$orderinfo->quer(['gid','goods_num'],'order_num ='.$param['order_num'])->toArray();
                    foreach ($order_gid as $gid) {
                        $result=DB::table('anchong_goods_specifications')->where('gid','=',$gid['gid'])->increment('sales',$gid['goods_num']);
                        if($result){
                            $result=DB::table('anchong_goods_type')->where('gid','=',$gid['gid'])->increment('sales',$gid['goods_num']);
                        }else{
                            //假如失败就回滚
                            DB::rollback();
                            return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'操作失败']]);
                        }
                    }
                }else{
                    //假如失败就回滚
                    DB::rollback();
                    return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'操作失败']]);
                }
            }else{
                //假如失败就回滚
                DB::rollback();
                return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'操作失败']]);
            }
            if($result){
                //假如成功就提交
                DB::commit();
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'操作成功']]);
            }else{
                //假如失败就回滚
                DB::rollback();
                return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'操作失败']]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   该方法提供订单支付
    */
    public function orderpay(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //创建ORM模型
            $pay=new \App\Pay();
            //支付单号
            $paynum=rand(100000,999999).time();
            $payresult=$pay->add(['paynum'=>$paynum,'order_id'=>$param['order_id'],'total_price'=>$param['total_price']]);
            if($payresult){
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['outTradeNo'=>$paynum,'totalFee'=>$param['total_price'],'body'=>$param['body'],'subject'=>"安虫商城订单支付"]]);
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'付款失败']]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }
}
