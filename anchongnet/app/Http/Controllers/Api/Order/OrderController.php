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
            if(empty($param['address'])){
                return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'请填写收货地址']]);
            }
            //定义优惠券字段
            $coupon_cvalue=$param['cvalue'];
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
            //遍历传过来的订单数据,orderarr是单个店铺的
            foreach ($param['list'] as $orderarr) {
                //查出该订单生成的联系人姓名
                $usermessages=new \App\Usermessages();
                $name=$usermessages->quer('contact',['users_id'=>$data['guid']])->toArray();
                if(!$name){
                    return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'请先填写个人资料里面的联系人']]);
                }
                // //查出该店铺客服联系方式
                // $customer=new \App\Shop();
                // $customers=$customer->quer('customer',"sid =".$orderarr['sid'])->toArray();
                // //如果店铺客服为空，则指定一个值不能让他报错
                // if(empty($customers)){
                //     //假如失败就回滚
                //     DB::rollback();
                //     return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'订单生成失败']]);
                // }
                $order_num=rand(10000,99999).substr($data['guid'],0,1).time();
                $orderprice=$orderarr['total_price'];
                //加单个商铺的总价到所有总价中
                $total_price += $orderprice;
                $total_price += $orderarr['freight'];
                //判断是否使用优惠券
                if($coupon_cvalue){
                    if($orderprice > $coupon_cvalue){
                        //判断是否是全网通用的
                        if($param['shop'] == 0){
                            //订单总价
                            $orderprice=$orderprice-$coupon_cvalue;
                            //总价
                            $total_price=$total_price-$coupon_cvalue;
                        }elseif($param['shop'] == $orderarr['sid']){
                            //订单总价
                            $orderprice=$orderprice-$coupon_cvalue;
                            //总价
                            $total_price=$total_price-$coupon_cvalue;
                        }
                    }
                }
                //为了初期版本没有invoicetype字段做准备
                try{
                    //如果没有该字段就赋值为0
                    if($param['invoicetype']){
                        $invoicetype = $param['invoicetype'];
                    }else{
                        $invoicetype = 0;
                    }
                } catch (\Exception $e) {
                    $invoicetype = 0;
                }
                //算上发票后的订单价格
                try{
                    //判断发票类型来增加价格
                    if($param['invoicetype']==0){
                        $allfree=$orderprice;
                    }elseif($param['invoicetype']==1){
                        $allfree=$orderprice*1.05;
                    }elseif($param['invoicetype']==2){
                        $allfree=$orderprice*1.1;
                    }
                }catch (\Exception $e) {
                        $allfree=$orderprice;
                }
                $order_data=[
                    'order_num' => $order_num,
                    'users_id' => $data['guid'],
                    'sid' => $orderarr['sid'],
                    'sname' => $orderarr['sname'],
                    'address' => $param['address'],
                    'name' => $param['name'],
                    'phone' => $param['phone'],
                    'total_price' => $allfree,
                    'created_at' => date('Y-m-d H:i:s',$data['time']),
                    'freight' => $orderarr['freight'],
                    'invoice_type' => $invoicetype,
                    'invoice' => $param['invoice'],
                    'customer' => "",
                    'tname' => $name[0]['contact']
                ];
                //判断是否使用优惠券
                if($orderprice < $orderarr['total_price']){
                    //增加一个字段
                    $order_data['acpid']=$param['acpid'];
                    $coupon_id=DB::table('anchong_coupon')->where('users_id',$data['guid'])->where('cpid',$param['acpid'])->where('end','>',time())->pluck('id');
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
                //拆分：每一个商铺对应：一个订单，一个支付单，一个订单详情
                //订单表
                $result=$order->add($order_data);
                //如果失败
                if(!$result){
                    //假如失败就回滚
                    DB::rollback();
                    return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'订单生成失败']]);
                }
                //支付单表
                $payresult=$pay->add(['paynum'=>$paynum,'order_id'=>$result,'total_price'=>$orderprice]);
                //假如生成失败
                if(!$payresult){
                    //假如失败就回滚
                    DB::rollback();
                    return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'订单支付生成失败']]);
                }
                //定义初始商铺总价
                $goods_total_price=0;
                foreach ($orderarr['goods'] as $goodsinfo) {
                    //创建货品表的ORM模型来查询货品数量
                    $goods_specifications=new \App\Goods_specifications();
                    try{
                        if($goodsinfo['promotion']){
                            $goods_datas=['title','promotion_price','goods_num','model','added','goods_numbering'];
                        }else{
                            $goods_datas=['title','vip_price','goods_num','model','added','goods_numbering'];
                        }
                    }catch (\Exception $e) {
                        $goods_datas=['title','vip_price','goods_num','model','added','goods_numbering'];
                    }
                    $goods_num=$goods_specifications->select($goods_datas)->find($goodsinfo['gid'])->toArray();
                    //判断商品是否以删除
                    if(empty($goods_num)){
                        //假如失败就回滚
                        DB::rollback();
                        return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>$goodsinfo['goods_name'].'商品已下架']]);
                    }
                    //查出最低价格
                    try{
                        if ($goodsinfo['promotion']) {
                            //促销活动时加入购物车，促销过后再提交订单
                            //此时货品的促销价已是0 [START]
                            if (!$goods_num['promotion_price']) {
                                //把这个货品从购物车删除吧
                                $cart->cartdel($goodsinfo['cart_id']);
                                return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'促销活动已过期']]);
                            }
                            //[END]
                            $minpric=$goods_num['promotion_price']*$goodsinfo['goods_num'];
                        } else {
                            $minpric=$goods_num['vip_price']*$goodsinfo['goods_num'];
                        }
                    }catch (\Exception $e) {
                        $minpric=$goods_num['vip_price']*$goodsinfo['goods_num'];
                    }
                    $goods_total_price+=$minpric;
                    //判断商品是否下架
                    if($goods_num['added'] != 1){
                        //假如失败就回滚
                        DB::rollback();
                        return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>$goods_num['title'].'已下架']]);
                    }
                    //判断总库存是否足够
                    if($goods_num['goods_num'] < $goodsinfo['goods_num']){
                        //假如失败就回滚
                        DB::rollback();
                        return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>$goods_num['title'].'库存不足，剩余库存'.$goods_num['goods_num']]]);
                    }
                    //如果数量足够就减去购买的数量
                    $goodsnum=$goods_num['goods_num']-$goodsinfo['goods_num'];
                    //订单生产时更新库存
                    $goodsnum_result=$goods_specifications->specupdate($goodsinfo['gid'],['goods_num' => $goodsnum]);
                    DB::table('anchong_goods_stock')->where('gid','=',$goodsinfo['gid'])->decrement('region_num',$goodsinfo['goods_num']);
                    //判断更新库存是否成功
                    if(!$goodsnum_result){
                        //假如失败就回滚
                        DB::rollback();
                        return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'订单生成失败，库存未更新']]);
                    }
                    $orderinfo_data=[
                        'order_num' =>$order_num,
                        'goods_name' => $goodsinfo['goods_name'],
                        'goods_num' => $goodsinfo['goods_num'],
                        'goods_price' => $goodsinfo['goods_price'],
                        'goods_type' => $goodsinfo['goods_type'],
                        'img' => $goodsinfo['img'],
                        'goods_numbering' =>$goods_num['goods_numbering'],
                        'model' => $goods_num['model'],
                        'gid' => $goodsinfo['gid'],
                        'oem' => $goodsinfo['oem'],
                    ];
                    $body .=$goodsinfo['goods_name'].",";
                    //创建购物车的ORM模型
                    $orderinfo=new \App\Orderinfo();
                    //订单详情表
                    $order_result=$orderinfo->add($orderinfo_data);
                    if(!$order_result){
                        //假如失败就回滚
                        DB::rollback();
                        return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'订单生成失败，订单详细信息未生成']]);
                    }
                    $true=true;
                     //同时删除购物车
                     $resultdel=$cart->cartdel($goodsinfo['cart_id']);
                     if($resultdel){
                         $true=true;
                     }else{
                         $true=false;
                     }
                }//单个商铺的处理结束
                //判断传输过程中价格有没有被篡改
                //整个总订单的价格和各个商铺叠加的总和判定
                //如果$goods_total_price为0呢？
                if ($orderarr['total_price'] < $goods_total_price) {
                    //假如失败就回滚
                    DB::rollback();
                    return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'订单内有物品的价格已改变，订单生成失败']]);
                }
            }//所有商铺的处理结束
            if($true && $total_price>0){
                //假如成功就提交
                DB::commit();
                //为老版本做优化
                try{
                    //判断发票类型来增加价格
                    if($param['invoicetype']==0){
                        $total_price=$total_price;
                    }elseif($param['invoicetype']==1){
                        $total_price=$total_price*1.05;
                    }elseif($param['invoicetype']==2){
                        $total_price=$total_price*1.1;
                    }
                }catch (\Exception $e) {
                   return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['outTradeNo'=>$paynum,'totalFee'=>$total_price,'body'=>$body,'subject'=>"安虫商城订单支付"]]);
                }
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['outTradeNo'=>$paynum,'totalFee'=>$total_price,'body'=>$body,'subject'=>"安虫商城订单支付"]]);
            }else{
                //假如失败就回滚
                DB::rollback();
                return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'订单生成失败，购物车商品未删除']]);
            }
        }catch (\Exception $e) {
           return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'请将APP更新到最新版本安虫，体验订单新功能！']]);
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
            $shop=new \App\Shop();
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
            $order_data=['order_id','order_num','sid','sname','state','updated_at','total_price','name','phone','address','freight','invoice','customer'];
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
                //获取商铺logo,供客服聊天时使用
                $shopimg=$shop->select('img')->find($order_results['sid'])->toArray();

                //为取支付宝订单名
                foreach ($orderinfo_result as $orderinfo_goodsname) {
                    $body .=$orderinfo_goodsname['goods_name'];
                }
                //将查询结果组成数组
                $order_results['body']=$body;
                $order_results['img']=$shopimg['img'];//商铺logo
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
                        DB::table('anchong_goods_specifications')->where('gid','=',$gid['gid'])->increment('goods_num',$gid['goods_num']);
                        DB::table('anchong_goods_stock')->where('gid','=',$gid['gid'])->increment('region_num',$gid['goods_num']);
                    }
                    $result=true;
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
                    //将商户冻结资金转移到可用资金
                    DB::table('anchong_users')->where('sid','=',$order_handle->sid)->decrement('disable_money',$order_handle->total_price);
                    $resultss=DB::table('anchong_users')->where('sid','=',$order_handle->sid)->increment('usable_money',$order_handle->total_price);
                    //假如资金转成功则保存数据
                    if($resultss){
                        $results=$order_handle->save();
                    }else{
                        //假如失败就回滚
                        DB::rollback();
                        return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'操作失败']]);
                    }
                }
                if($results){
                    //创建ORM模型
                    $orderinfo=new \App\Orderinfo();
                    $order_gid=$orderinfo->quer(['gid','goods_num'],'order_num ='.$param['order_num'])->toArray();
                    foreach ($order_gid as $gid) {
                        DB::table('anchong_goods_specifications')->where('gid','=',$gid['gid'])->increment('sales',$gid['goods_num']);
                        DB::table('anchong_goods_type')->where('gid','=',$gid['gid'])->increment('sales',$gid['goods_num']);
                        $result=true;
                    }
                }else{
                    //假如失败就回滚
                    DB::rollback();
                    return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'操作失败']]);
                }
            }elseif($param['action'] == 4){
                //处理成功给用户和商户推送消息
                try{
                    $propel=new \App\Http\Controllers\admin\Propel\PropelmesgController();
                    $sid=DB::table('anchong_goods_order')->where('order_id',$param['order_id'])->pluck('sid');
                    if($sid[0] == 1){
                        //退货操作
                        $propel->apppropel("13013221114",'退货通知','您的商铺有人退货，请及时查看！');
                    }else{
                        $phone=DB::table('anchong_users')->where('sid',$sid[0])->pluck('phone');
                        //退货操作
                        $propel->apppropel($phone[0],'退货通知','您的商铺有人退货，请及时查看！');
                    }

                }catch (\Exception $e) {

                }
                //获取订单句柄
                $order_handle=$order->find($param['order_id']);
                $order_handle->state = 4;
                $result=$order_handle->save();
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

    /*
     * 对于使用物流发货的订单
     *   该方法用来查看订单的物流状态
     */
    public function orderstate(Request $request)
    {
        try{
            $data=$request::all();
            $param=json_decode($data['param'],true);
            if (!$param['order_num']) {
                return response()->json(['serverTime'=>time(),'ServerNo'=>10,'ResultData'=>['Message'=>'订单编号有误']]);
            }
            $ret = ['order'=>'','logis'=>''];
            $odata = ['logisticsnum','order_id','company','order_no','status','content','time'];
            $ldata = ['logisticsnum','company','bill_code','status','data'];
            $ostatus = DB::table('anchong_ostatus')->where('logisticsnum',$param['order_num'])->get($odata);
            $lstatus = DB::table('anchong_lstatus')->where('logisticsnum',$param['order_num'])->get($ldata);
            //最新的物流信息应该在最上面显示，故倒序之
            $lstatus = array_reverse($lstatus);
            $ret['order'] =end($ostatus);
            //物流状态(物流公司发货后有物流状态)
            $tmp = array();
            //每次的data都拼接起来
            foreach ($lstatus as $o) {
                $tmp = array_merge($tmp,unserialize($o->data));
                $o->data=$tmp;
                $ret['logis']=$o;
            }
            return response()->json(['serverTime'=>time(),'ServerNo'=>10,'ResultData'=>$ret]);
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
     *  单个订单查看
     */
    public function orderdetail(Request $request)
    {
        try{
            $data=$request::all();
            $param=json_decode($data['param'],true);
            $result=DB::table('anchong_goods_order')->where('order_id',$param['order_id'])->select('order_id','order_num','total_price','freight')->get();
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$result]);
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
     *  单个订单修改
     */
    public function orderedit(Request $request)
    {
        try{
            $data=$request::all();
            $param=json_decode($data['param'],true);
            $users_sid=DB::table('anchong_shops')->where('users_id',$data['guid'])->pluck('sid');
            //查出该商铺的ID
            $sid=DB::table('anchong_goods_order')->where('order_id',$param['order_id'])->pluck('sid');
            //判断是否是该商铺在改自己的价格
            if($sid && $users_sid && $sid[0] == $users_sid[0]){
                $results=DB::table('anchong_goods_order')->where('order_id',$param['order_id'])->update(['total_price'=>$param['total_price'],'freight'=>$param['freight']]);
                if($results){
                    return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'修改成功']]);
                }else{
                    return response()->json(['serverTime'=>time(),'ServerNo'=>10,'ResultData'=>['Message'=>'修改失败']]);
                }
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>10,'ResultData'=>['Message'=>'非法操作']]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
     *  单个订单免运费
     */
    public function freefreight(Request $request)
    {
        try{
            $data=$request::all();
            $param=json_decode($data['param'],true);
            $users_sid=DB::table('anchong_shops')->where('users_id',$data['guid'])->pluck('sid');
            //查出该商铺的ID
            $sid=DB::table('anchong_goods_order')->where('order_id',$param['order_id'])->pluck('sid');
            //判断是否是该商铺在改自己的价格
            if($sid && $users_sid && $sid[0] == $users_sid[0]){
                $result=DB::table('anchong_goods_order')->where('order_id',$param['order_id'])->update(['freight'=>0]);
                if($result){
                    return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'免运费成功']]);
                }else{
                    return response()->json(['serverTime'=>time(),'ServerNo'=>10,'ResultData'=>['Message'=>'免运费失败']]);
                }
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>10,'ResultData'=>['Message'=>'非法操作']]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }
}
