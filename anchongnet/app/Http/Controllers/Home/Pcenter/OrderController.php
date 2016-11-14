<?php

namespace App\Http\Controllers\Home\Pcenter;

use App\Http\Controllers\Home\CommonController;
use App\Http\Requests;
use App\Order;
use App\Orderinfo;
use App\Users;
use Auth;
use Request;
use DB;

class OrderController extends CommonController
{
    public function index()
    {
        $usersinfo=Auth::user();
        //$user =Users::where('users_id',$usersinfo->users_id)->first();
        $orderlist = Order::where('users_id',$usersinfo->users_id)->get();
          foreach($orderlist as $k){
            $mm = $k['order_num'];
             $orderinfo[$mm] = Orderinfo::where('order_num',$mm)->get();
          }
        $ordernum1 = $orderlist->where('state',1);
        foreach($ordernum1 as $k){
            $mm = $k['order_num'];
            $order1[$mm] = Orderinfo::where('order_num',$mm)->get();
        }
        $ordernum2 = $orderlist->where('state',2);
        foreach($ordernum2 as $k){
            $mm = $k['order_num'];
            $order2[$mm] = Orderinfo::where('order_num',$mm)->get();
        }
        $ordernum3 = $orderlist->where('state',3);
        foreach($ordernum3 as $k){
            $mm = $k['order_num'];
            $order3[$mm] = Orderinfo::where('order_num',$mm)->get();
        }

        return view('home.order.order',compact('orderlist','orderinfo','ordernum1','order1','ordernum2','order2','ordernum3','order3'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('home/order/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // try{

            //得到用户的ID
            $users_id=Auth::user()->users_id;
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $orderinfo=json_decode($data['orderinfo'],true);
            if(empty($data['address'])){
                return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'请填写收货地址']]);
            }
            //定义优惠券字段
            $coupon_cvalue=$data['cvalue'];
            //定义状态
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
            foreach ($orderinfo as $orderarr) {
                //查出该订单生成的联系人姓名
                $usermessages=new \App\Usermessages();
                $name=$usermessages->quer('contact',['users_id'=>$users_id])->toArray();
                if(!$name){
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
                $order_num=rand(10000,99999).substr($users_id,0,1).time();
                $orderprice=$orderarr['total_price'];
                $total_price += $orderprice;
                //判断是否使用优惠券
                if($coupon_cvalue){
                    if($orderprice > $coupon_cvalue){
                        //判断是否是全网通用的
                        if($data['shop'] == 0){
                            //订单总价
                            $orderprice=$orderprice-$coupon_cvalue;
                            //总价
                            $total_price=$total_price-$coupon_cvalue;
                        }elseif($data['shop'] == $orderarr['sid']){
                            //订单总价
                            $orderprice=$orderprice-$coupon_cvalue;
                            //总价
                            $total_price=$total_price-$coupon_cvalue;
                        }
                    }
                }
                //判断发票类型
                if($data['invoicetype']==0){
                    $invoice="";
                }elseif($data['invoicetype']==1){
                    $invoice=$data['invoice1']."#".$data['invoice2'];
                }elseif($data['invoicetype']==2){
                    $invoice=$data['invoice3']."#".$data['invoice4']."#".$data['invoice5']."#".$data['invoice6']."#".$data['invoice7'];
                }
                $order_data=[
                    'order_num' => $order_num,
                    'users_id' => $users_id,
                    'sid' => $orderarr['sid'],
                    'sname' => $orderarr['sname'],
                    'address' => $data['address'],
                    'name' => $data['name'],
                    'phone' => $data['phone'],
                    'total_price' => $orderprice,
                    'created_at' => date('Y-m-d H:i:s',time()),
                    'freight' => $orderarr['freight'],
                    'invoice_type' => $data['invoicetype'],
                    'invoice' => $invoice,
                    'customer' => $customers[0]['customer'],
                    'tname' => $name[0]['contact']
                ];
                //判断是否使用优惠券
                if($orderprice < $orderarr['total_price']){
                    //增加一个字段
                    $order_data['acpid']=$data['acpid'];
                    $coupon_id=DB::table('anchong_coupon')->where('users_id',$users_id)->where('cpid',$data['acpid'])->where('end','>',time())->pluck('id');
                    //如果优惠券不可使用
                    if(!$coupon_id){
                        //假如失败就回滚
                        DB::rollback();
                        return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'订单生成失败，该优惠券不可使用']]);
                    }
                    DB::table('anchong_coupon')->where('id',$coupon_id[0])->delete();
                    $coupon_cvalue="";
                }
                //创建订单的ORM模型
                $order=new \App\Order();
                $cart=new \App\Cart();
                $pay=new \App\Pay();
                //插入数据
                $result=$order->add($order_data);
                //如果失败
                if(!$result){
                    //假如失败就回滚
                    DB::rollback();
                    return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'订单生成失败']]);
                }
                //定义初始商铺总价
                $goods_total_price=0;
                $payresult=$pay->add(['paynum'=>$paynum,'order_id'=>$result,'total_price'=>$orderprice]);
                //假如生成失败
                if(!$payresult){
                    //假如失败就回滚
                    DB::rollback();
                    return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'订单生成失败']]);
                }
                foreach ($orderarr['goods'] as $goodsinfo) {
                    //创建货品表的ORM模型来查询货品数量
                    $goods_specifications=new \App\Goods_specifications();
                    $goods_num=$goods_specifications->quer(['title','vip_price','goods_num','model','added','goods_numbering'],'gid ='.$goodsinfo['gid'])->toArray();
                    //判断商品是否以删除
                    if(empty($goods_num)){
                        //假如失败就回滚
                        DB::rollback();
                        return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>$goodsinfo['goods_name'].'商品已下架']]);
                    }
                    //将每个商品的最低价相加
                    $minpric=$goods_num[0]['vip_price']*$goodsinfo['goods_num'];
                    $goods_total_price+=$minpric;
                    //判断商品是否下架
                    if($goods_num[0]['added'] != 1){
                        //假如失败就回滚
                        DB::rollback();
                        return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>$goods_num[0]['title'].'已下架']]);
                    }
                    //判断总库存是否足够
                    if($goods_num[0]['goods_num'] < $goodsinfo['goods_num']){
                        //假如失败就回滚
                        DB::rollback();
                        return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>$goods_num[0]['title'].'库存不足，剩余库存'.$goods_num[0]['goods_num']]]);
                    }
                    //如果数量足够就减去购买的数量
                    $goodsnum=$goods_num[0]['goods_num']-$goodsinfo['goods_num'];
                    //订单生产时更新库存
                    $goodsnum_result=$goods_specifications->specupdate($goodsinfo['gid'],['goods_num' => $goodsnum]);
                    DB::table('anchong_goods_stock')->where('gid','=',$goodsinfo['gid'])->decrement('region_num',$goodsinfo['goods_num']);
                    //判断更新库存是否成功
                    if(!$goodsnum_result){
                        //假如失败就回滚
                        DB::rollback();
                        return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'订单生成失败']]);
                    }
                    $orderinfo_data=[
                        'order_num' =>$order_num,
                        'goods_name' => $goodsinfo['goods_name'],
                        'goods_num' => $goodsinfo['goods_num'],
                        'goods_price' => $goodsinfo['goods_price'],
                        'goods_type' => $goodsinfo['goods_type'],
                        'img' => $goodsinfo['img'],
                        'goods_numbering' =>$goods_num[0]['goods_numbering'],
                        'model' => $goods_num[0]['model'],
                        'gid' => $goodsinfo['gid'],
                        'oem' => $goodsinfo['oem'],
                    ];
                    $body .=$goodsinfo['goods_name'].",";
                    //创建购物车的ORM模型
                    $orderinfo=new \App\Orderinfo();
                    //插入数据
                    $order_result=$orderinfo->add($orderinfo_data);
                    if(!$order_result){
                        //假如失败就回滚
                        DB::rollback();
                        return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'订单生成失败']]);
                    }
                    $true=true;
                     //同时删除购物车
                    //  $resultdel=$cart->cartdel($goodsinfo['cart_id']);
                    //  if($resultdel){
                    //      $true=true;
                    //  }else{
                    //      $true=false;
                    //  }
                }
                //判断传输过程中价格有没有被篡改
                if($orderarr['total_price'] < $goods_total_price){
                    //假如失败就回滚
                    DB::rollback();
                    return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'非法的价格，订单生成失败']]);
                }
            }
            if($true && $total_price>0){
                //假如成功就提交
                DB::commit();
                if($data['invoicetype']==0){
                    $total_price=$total_price;
                }elseif($data['invoicetype']==1){
                    $total_price=$total_price*1.05;
                }elseif($data['invoicetype']==2){
                    $total_price=$total_price*1.1;
                }
                //判断是那种支付方式
                switch ($data['paytype']) {
                    case '1':
                        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['payurl'=>'','outTradeNo'=>$paynum,'totalFee'=>$total_price,'body'=>$body,'subject'=>"安虫商城订单支付"]]);
                        break;

                    case '2':
                        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['payurl'=>'http://pay.anchong.net/pay/alipay','outTradeNo'=>$paynum,'totalFee'=>$total_price,'body'=>$body,'subject'=>"安虫商城订单支付"]]);
                        break;

                    case '3':
                        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['payurl'=>'http://pay.anchong.net/pay/wxpay','outTradeNo'=>$paynum,'totalFee'=>$total_price,'body'=>$body,'subject'=>"安虫商城订单支付"]]);
                        break;

                    default:
                        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['payurl'=>'','outTradeNo'=>$paynum,'totalFee'=>$total_price,'body'=>$body,'subject'=>"安虫商城订单支付"]]);
                        break;
                }

            }else{
                //假如失败就回滚
                DB::rollback();
                return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'订单生成失败']]);
            }
        // }catch (\Exception $e) {
        //    return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        // }
    }

    public function show($order_num)
    {
        $orderdetail = Order::where('order_num',$order_num)->first();
        $orderlist = Orderinfo::where('order_num',$order_num)->get();
        return view('home.order.orderdetail',compact('orderdetail','orderlist'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
