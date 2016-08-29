<?php

namespace App\Http\Controllers\Api\Purse;

use Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/*
*   该控制器包含了钱袋模块的操作
*/
class PurseController extends Controller
{
    //定义变量
    private $users;
    private $coupon;
    private $coupon_pool;
    private $purse_order;

    /*
    *   执行构造方法将orm模型初始化
    */
    public function __construct()
    {
        $this->users=new \App\Users();
        $this->coupon=new \App\Coupon();
        $this->coupon_pool=new \App\Coupon_pool();
        $this->purse_order=new \App\Purse_order();
    }

    /*
    *   钱袋余额
    */
    public function pursemoney(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //查出余额数据
        $users_money=$this->users->quer(['usable_money','disable_money'],['users_id' => $data['guid']])->toArray();
        //将用户余额统计出来
        $users_moneys=$users_money[0]['usable_money']+$users_money[0]['disable_money'];
        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['users_money'=>$users_moneys]]);
    }

    /*
    *   可用余额
    */
    public function usablemoney(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //查出余额数据
        $users_money=$this->users->quer('usable_money',['users_id' => $data['guid']])->toArray();
        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['usable_money'=>$users_money[0]['usable_money']]]);
    }

    /*
    *   虫豆首页
    */
    public function beansindex(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //默认每页数量
        $limit=8;
        //定义优惠券字段
        $coupon_data=['acpid','title','cvalue','info','beans'];
        //查出余额数据
        $coupon_pool_data=$this->coupon_pool->quer($coupon_data,'open = 1',(($param['page']-1)*$limit),$limit);
        //判断是否有优惠券
        if($coupon_pool_data['total'] == 0){
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['total'=>0,'list'=>[]]]);
        }
        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$coupon_pool_data]);
    }

    /*
    *   点击签到
    */
    public function signin(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //签到增加的虫豆数量
        $addbeans=0;
        DB::table('anchong_users')->where('users_id','=',$data['guid'])->increment('sales',$gid['goods_num']);
    }

    /*
    *   钱袋充值
    */
    public function recharge(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //生成订单编号
        $order_num=rand(1000,9999).substr($data['guid'],0,1).time();
        //插入订单数据
        $order_data=[
            'order_num' =>$order_num,
            'users_id' => $data['guid'],
            'price' => $param['price'],
            'action' => 1,
            'created_at' => date('Y-m-d H:i:s',$data['time']),
        ];
        switch ($param['payment']) {
            //支付宝支付
            case 1:
                //增加订单备注
                $order_data['remark']='支付宝充值';
                break;

            //微信支付
            case 2:
                //增加订单备注
                $order_data['remark']='微信充值';
                break;

            //对公账号
            case 3:
                //增加订单备注
                $order_data['remark']='对公账号充值';
                break;
            default:
                return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'非法操作']]);
                break;
        }
        //生成订单
        $result=$this->purse_order->add($order_data);
        //判断是否成功
        if($result){
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['outTradeNo'=>$order_num,'totalFee'=>$param['price'],'subject'=>"安虫商城订单",'body'=>"安虫钱包充值"]]);
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'充值失败']]);
        }
    }
}
