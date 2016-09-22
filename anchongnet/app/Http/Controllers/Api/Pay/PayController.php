<?php

namespace App\Http\Controllers\Api\Pay;

use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Omnipay;
use Input;
use Log;
use EasyWeChat\Payment\Order;
use QrCode;
use Cache;
use Hash;

/*
*   支付控制器
*/
class PayController extends Controller
{
    //定义变量
    private $users;
    private $propel;

    /*
    *   执行构造方法将orm模型初始化
    */
    public function __construct()
    {
        $this->users=new \App\Users();
        $this->propel=new \App\Http\Controllers\admin\Propel\PropelmesgController();
    }

    /*
    *   余额支付
    */
    public function moneypay(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //取出支付密码
        $paypassword=DB::table('anchong_users')->where('users_id',$data['guid'])->pluck('password');
        //判断用户是否设置支付密码
        if(!$paypassword[0]){
            return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'请先设置支付密码']]);
        }
        //判断支付密码是否可用(后期做大以后一定记得控制错误次数)
        if($paypassword[0] != md5($param['paypassword'])){
            return response()->json(['serverTime'=>time(),'ServerNo'=>4,'ResultData'=>['Message'=>'支付密码错误']]);
        }
        $pay_datas=DB::table('anchong_pay')->select('order_id','total_price')->where('paynum',$param['outTradeNo'])->get();
        //开启事务处理
        DB::beginTransaction();
        $pay_total_price=0;
        //将订单一个个处理
        foreach ($pay_datas as $datas) {
            $pay_total_price+=$datas->total_price;
            //创建ORM模型
            $orders = new \App\Order();
            // 使用通知里的 "商户订单号" 去自己的数据库找到订单
            $order = $orders->find($datas->order_id);
            // 如果订单不存在
            if (!$order) {
                // 订单没找到，别再通知我了
                return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'付款失败，该订单不存在']]);
            }
            // 如果订单存在
            // 检查订单是否已经更新过支付状态
            if ($order->state == 2) {
                // 假设订单字段“支付时间”不为空代表已经支付
                // 已经支付成功了就不再更新了
                return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'有商品已付款']]);
            }
            // 不是已经支付状态则修改为已经支付状态
            // 更新支付ID
            $order->state = 2;
            $order->paycode="moneypay:".$param['outTradeNo'];
            //将钱增加到商户冻结资金
            $result=DB::table('anchong_users')->where('sid','=',$order->sid)->increment('disable_money',$order->total_price*0.99);
            //判断是否加钱成功
            if($result){
                // 保存订单
                $order->save();
            }else{
                //假如失败就回滚
                DB::rollback();
                // 返回处理完成
                return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'付款失败']]);
            }
        }
        //判断再付款的时候订单是否被恶意修改
        if($param['totalFee'] == $pay_total_price){
            //获取用户句柄
            $users_handle=$this->users->find($data['guid']);
            //如果余额不够付款
            if($users_handle->usable_money < $pay_total_price){
                //假如失败就回滚
                DB::rollback();
                return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'您好，您的可用余额不足，请充值']]);
            }
            //将用户余额减去应付款数
            $surplus=$users_handle->usable_money-$pay_total_price;
            $users_handle->usable_money=$surplus;
            $users_handle->save();
            //生成钱袋订单编号
            $order_num=rand(1000,9999).substr($data['guid'],0,1).time();
            //将消费记录插入个人钱袋的消费表
            $purse_order= DB::table('anchong_purse_order')->insertGetId(
                [
                    'order_num' =>$order_num,
                    'users_id' => $data['guid'],
                    'pay_num' => "money:".$param['outTradeNo'],
                    'price' => $pay_total_price,
                    'action' => 3,
                    'created_at' => date('Y-m-d H:i:s',$data['time']),
                    'state' => 2,
                    'remainder' => $surplus,
                ]
            );
            //假如生成钱袋订单出错
            if(!$purse_order){
                //假如失败就回滚
                DB::rollback();
                // 返回处理完成
                return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'付款失败']]);
            }
            DB::commit();
            // 返回处理完成
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'支付成功']]);
        }else{
            //假如失败就回滚
            DB::rollback();
            // 返回处理完成
            return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'付款失败，您的交易金额不合法']]);
        }
    }

    /*
    *   该方法是APP订单内的余额支付接口
    */
    public function moneyorderpay(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //取出支付密码
        $paypassword=DB::table('anchong_users')->where('users_id',$data['guid'])->pluck('password');
        //判断用户是否设置支付密码
        if(!$paypassword[0]){
            return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'请先设置支付密码']]);
        }
        //判断支付密码是否可用(后期做大以后一定记得控制错误次数)
        if($paypassword[0] != md5($param['paypassword'])){
            return response()->json(['serverTime'=>time(),'ServerNo'=>4,'ResultData'=>['Message'=>'支付密码错误']]);
        }
        //开启事务处理
        DB::beginTransaction();
        //创建ORM模型
        $pay=new \App\Pay();
        //支付单号
        $paynum=rand(100000,999999).time();
        $payresult=$pay->add(['paynum'=>$paynum,'order_id'=>$param['order_id'],'total_price'=>$param['totalFee']]);
        //创建ORM模型
        $orders=new \App\Order();
        // 使用通知里的 "商户订单号" 去自己的数据库找到订单
        $order = $orders->find($param['order_id']);
        $pay_total_price=$order->total_price;
        //判断再付款的时候订单是否被恶意
        if($param['totalFee'] != $pay_total_price){
            //假如失败就回滚
            DB::rollback();
            // 返回处理完成
            return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'付款失败，您的交易金额不合法']]);
        }
        // 如果订单不存在
        if (!$order) {
            //假如失败就回滚
            DB::rollback();
            // 订单没找到，别再通知我了
            return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'付款失败，该订单不存在']]);
        }
        // 如果订单存在
        // 检查订单是否已经更新过支付状态
        if ($order->state == 2) {
            // 已经支付成功了就不再更新了
            return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'有商品已付款']]);
        }
        // 不是已经支付状态则修改为已经支付状态
        // 更新支付ID
        $order->state = 2;
        $order->paycode="moneypay:".$paynum;
        //将钱增加到商户冻结资金
        $result=DB::table('anchong_users')->where('sid','=',$order->sid)->increment('disable_money',$order->total_price*0.99);
        //判断是否加钱成功
        if($result){
            // 保存订单
            $order->save();
        }else{
            //假如失败就回滚
            DB::rollback();
            // 返回处理完成
            return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'付款失败']]);
        }
        //获取用户句柄
        $users_handle=$this->users->find($data['guid']);
        //如果余额不够付款
        if($users_handle->usable_money < $pay_total_price){
            //假如失败就回滚
            DB::rollback();
            return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'您好，您的可用余额不足，请充值']]);
        }
        //将用户余额减去应付款数
        $surplus=$users_handle->usable_money-$pay_total_price;
        $users_handle->usable_money=$surplus;
        $users_handle->save();
        //生成钱袋订单编号
        $order_num=rand(1000,9999).substr($data['guid'],0,1).time();
        //将消费记录插入个人钱袋的消费表
        $purse_order= DB::table('anchong_purse_order')->insertGetId(
            [
                'order_num' =>$order_num,
                'users_id' => $data['guid'],
                'pay_num' => "money:".$paynum,
                'price' => $pay_total_price,
                'action' => 3,
                'created_at' => date('Y-m-d H:i:s',$data['time']),
                'state' => 2,
                'remainder' => $surplus,
            ]
        );
        //假如生成钱袋订单出错
        if(!$purse_order){
            //假如失败就回滚
            DB::rollback();
            // 返回处理完成
            return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'付款失败']]);
        }
        DB::commit();
        // 返回处理完成
        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'支付成功']]);
    }

    /*
    *   该方法是支付宝的支付接口
    */
    public function alipay()
    {
        // 创建支付单。
        $alipay = app('alipay.mobile');
        $alipay->setOutTradeNo('94869281467365887');
        $alipay->setTotalFee('0.1');
        $alipay->setSubject('安虫测试付2款单');
        $alipay->setBody('2222');

        //$alipay->setQrPayMode('4'); //该设置为可选，添加该参数设置，支持二维码支付。

        // 返回签名后的支付参数给支付宝移动端的SDK。
        return $alipay->getPayPara();
        exit;
        // 跳转到支付页面。
        return redirect()->to($alipay->getPayLink());
    }

    /*
    *   该方法是微信的支付接口
    */
    public function wxpay()
    {
        $wechat = app('wechat');
        $attributes = [
            'trade_type'       => 'NATIVE', // JSAPI，NATIVE，APP...
            'body'             => 'iPad mini 16G 白色',
            'detail'           => 'iPad mini 16G 白色',
            'out_trade_no'     => '16012014702776217',
            'total_fee'        => 1,
            'notify_url'       => 'http://pay.anchong.net/pay/wxnotify',
        ];
        $order = new Order($attributes);
        $payment=$wechat->payment;
        $result = $payment->prepare($order);
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
            $prepayId = $result->prepay_id;
        }
        $config = $payment->configForAppPayment($prepayId);
        var_dump($config);
        return QrCode::size(200)->color(105,80,10)->backgroundColor(205,230,199)->generate($result->code_url);
    }

    /*
    *   该方法是微信APP的支付接口
    */
    public function wxapppay(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        $total_fee=$param['totalFee']*100;
        //总价转换
        $wechat = app('wechat');
        $attributes = [
            'trade_type'       => 'APP', // JSAPI，NATIVE，APP...
            'body'             => $param['subject'],
            'detail'           => $param['body'],
            'out_trade_no'     => $param['outTradeNo'],
            'total_fee'        => $total_fee,
            'notify_url'       => 'http://pay.anchong.net/pay/wxnotify',
        ];
        //生成订单类
        $order = new Order($attributes);
        $payment=$wechat->payment;
        $result = $payment->prepare($order);
        //判断是否有成功的订单
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
            $prepayId = $result->prepay_id;
        }
        //生成app所需的内容
        $config = $payment->configForAppPayment($prepayId);
        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$config]);
    }

    /*
    *   该方法是支付宝APP的支付接口
    */
    public function aliapppay(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        // 创建支付单。
        $alipay = app('alipay.mobile');
        $alipay->setOutTradeNo($param['outTradeNo']);
        $alipay->setTotalFee($param['totalFee']);
        $alipay->setSubject($param['subject']);
        $alipay->setBody($param['body']);

        // 返回签名后的支付参数给支付宝移动端的SDK。
        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$alipay->getPayPara()]);
    }

    /*
    *   该方法是支付宝APP订单内的支付接口
    */
    public function aliapporderpay(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //创建ORM模型
            $pay=new \App\Pay();
            //支付单号
            $paynum=rand(100000,999999).time();
            $payresult=$pay->add(['paynum'=>$paynum,'order_id'=>$param['order_id'],'total_price'=>$param['totalFee']]);
            if($payresult){
                // 创建支付单。
                $alipay = app('alipay.mobile');
                $alipay->setOutTradeNo($paynum);
                $alipay->setTotalFee($param['totalFee']);
                $alipay->setSubject('安虫商城订单支付');
                $alipay->setBody($param['body']);
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$alipay->getPayPara()]);
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'付款失败']]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   该方法是微信APP订单内的支付接口
    */
    public function wxapporderpay(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //创建ORM模型
            $pay=new \App\Pay();
            //支付单号
            $paynum=rand(100000,999999).time();
            $payresult=$pay->add(['paynum'=>$paynum,'order_id'=>$param['order_id'],'total_price'=>$param['totalFee']]);
            if($payresult){
                $total_fee=$param['totalFee']*100;
                //总价转换
                $wechat = app('wechat');
                $attributes = [
                    'trade_type'       => 'APP', // JSAPI，NATIVE，APP...
                    'body'             => "安虫商城订单支付",
                    'detail'           => $param['body'],
                    'out_trade_no'     => $paynum,
                    'total_fee'        => $total_fee,
                    'notify_url'       => 'http://pay.anchong.net/pay/wxnotify',
                ];
                //生成订单类
                $order = new Order($attributes);
                $payment=$wechat->payment;
                $result = $payment->prepare($order);
                //判断是否有成功的订单
                if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
                    $prepayId = $result->prepay_id;
                }
                //生成app所需的内容
                $config = $payment->configForAppPayment($prepayId);
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$config]);
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'付款失败']]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   该方法是微信的支付接口
    */
    public function wxnotify(Request $request)
    {
        //获得app传过来的参数
        $app = app('wechat');
        $response = $app->payment->handleNotify(function($notify, $successful){
            //创建orm模型
            $pay=new \App\Pay();
             if(strlen($notify->out_trade_no) == 16){
                //开启事务处理
                DB::beginTransaction();
                //判断总价防止app攻击
                $total_price=0;
                $order_id_arr=$pay->quer(['order_id','total_price'],'paynum ='.$notify->out_trade_no)->toArray();
                 foreach ($order_id_arr as $order_id) {
                    $total_price +=$order_id['total_price'];
                    //创建ORM模型
                    $orders=new \App\Order();
                    // 使用通知里的 "商户订单号" 去自己的数据库找到订单
                    $order = $orders->find($order_id['order_id']);
                    // 如果订单不存在
                    if (!$order) {
                        // 告诉微信，我已经处理完了，订单没找到，别再通知我了
                        return 'Order not exist.';
                    }
                    // 如果订单存在
                    // 检查订单是否已经更新过支付状态
                    if ($order->state == 2) {
                        // 假设订单字段“支付时间”不为空代表已经支付
                        // 已经支付成功了就不再更新了
                        return true;
                    }
                    // 用户是否支付成功
                    if ($successful) {
                        // 不是已经支付状态则修改为已经支付状态
                        // 更新支付时间为当前时间
                        $order->state = 2;
                        $order->paycode="wxpay:".$notify->transaction_id;
                        //将钱增加到商户冻结资金
                        $result=DB::table('anchong_users')->where('sid','=',$order->sid)->increment('disable_money',$order->total_price*0.99);
                    } else {
                        // 用户支付失败
                        $order->state = 1;
                        $result=false;
                    }
                    //判断是否加钱成功
                    if($result){
                        // 保存订单
                        $order->save();
                    }else{
                        //假如失败就回滚
                        DB::rollback();
                        // 返回处理完成
                        return true;
                    }
                }
                if($total_price == ($notify->total_fee/100)){
                    DB::commit();
                    // 返回处理完成
                    return true;
                }else{
                    //假如失败就回滚
                    DB::rollback();
                    // 返回处理完成
                    return true;
                }
            //个人钱袋订单处理
            }elseif(strlen($notify->out_trade_no) == 15){
                //看是否成功支付
                if ($successful) {
                    //开启事务处理
                    DB::beginTransaction();
                    //创建orm
                    $purse_order=new \App\Purse_order();
                    //通过订单查出价格和ID
                    $result=$purse_order->quer(['purse_oid','price'],'order_num ='.$notify->out_trade_no)->toArray();
                    //判断总价，防止app改包攻击
                    if($result[0]['price'] != ($notify->total_fee/100)){
                        return true;
                    }
                    //更新订单状态
                    $purse_order_handle=$purse_order->find($result[0]['purse_oid']);
                    //订单已经修改过，无需再修改
                    if($purse_order_handle->state == 2){
                        return true;
                    }
                    //将订单改为2
                    $purse_order_handle->state = 2;
                    $purse_order_handle->pay_num="wxpay:".$notify->transaction_id;
                    //将钱增加到商户冻结资金
                    $results=DB::table('anchong_users')->where('users_id','=',$purse_order_handle->users_id)->increment('usable_money',$result[0]['price']);
                    //判断是否操作成功
                    if($results){
                        $purse_order_handle->remainder=$this->users->find($purse_order_handle->users_id)->usable_money;
                        //保存订单
                        $purse_order_handle->save();
                        DB::commit();
                        // 返回处理完成
                        return true;
                    }else{
                        //假如失败就回滚
                        DB::rollback();
                        return true;
                    }
                }else{
                    // 返回处理完成
                    return true;
                }
            }
        });
        return $response;
    }

   /*
   *   异步通知（具体待修改）
   */
   public function webnotify()
   {
       // 验证请求。
       if (! app('alipay.web')->verify()) {
           Log::notice('Alipay notify post data verification fail.', [
               'data' => Request::instance()->getContent()
           ]);
           return 'fail';
       }

       // 判断通知类型。
       switch (Input::get('trade_status')) {
           case 'TRADE_SUCCESS':
                break;
           case 'TRADE_FINISHED':
               // TODO: 支付成功，取得订单号进行其它相关操作。
               Log::debug('Alipay notify post data verification success.', [
                   'out_trade_no' => Input::get('out_trade_no'),
                   'trade_no' => Input::get('trade_no')
               ]);
               break;
       }
   }

   /*
   *   手机异步通知
   */
  public function mobilenotify(Request $request)
  {
      //获得app传过来的参数
      $data=$request::all();
      // 验证请求。
      if (! app('alipay.mobile')->verify()) {

         return 'fail';
     }

      // 判断通知类型。
      switch ($data['trade_status']) {
          case 'TRADE_SUCCESS':
               //开启事务处理
               DB::beginTransaction();
               $paynum=$data['out_trade_no'];
               if(strlen($paynum) == 16){
                   //创建ORM模型
                   $orders=new \App\Order();
                   $pay=new \App\Pay();
                   //判断总价防止app攻击
                   $total_price=0;
                   $order_id_arr=$pay->quer(['order_id','total_price'],'paynum ='.$paynum)->toArray();
                   foreach ($order_id_arr as $order_id) {
                       //对总价进行累加
                       $total_price +=$order_id['total_price'];
                       //进行订单操作
                       // 使用通知里的 "商户订单号" 去自己的数据库找到订单
                       $order = $orders->find($order_id['order_id']);
                       // 如果订单不存在
                       if (!$order) {
                           // 我已经处理完了，订单没找到，别再通知我了
                           return 'fail';
                       }

                       // 检查订单是否已经更新过支付状态
                       if ($order->state == 2) {
                           // 假设订单字段“支付时间”不为空代表已经支付
                           // 已经支付成功了就不再更新了
                           DB::rollback();
                           return 'fail';
                       }
                       //将订单状态改成成功并记录下支付单号
                       $order->state = 2;
                       $order->paycode="alipay:".$data['trade_no'];

                       //将钱增加到商户冻结资金
                       $result=DB::table('anchong_users')->where('sid','=',$order->sid)->increment('disable_money',$order->total_price*0.99);
                       if($result){
                           // 保存订单
                           $order->save();
                       }else{
                           //假如失败就回滚
                           DB::rollback();
                           return 'fail';
                       }
                   }

                //假如价格比对成功就提交
                if($total_price == $data['total_fee']){
                    DB::commit();
                    return 'success';
                }else{
                    //假如失败就回滚
                    DB::rollback();
                    return 'fail';
                }
            //个人钱袋订单处理
            }elseif(strlen($paynum) == 15){
                //创建orm
                $purse_order=new \App\Purse_order();
                //通过订单查出价格和ID
                $result=$purse_order->quer(['purse_oid','price'],'order_num ='.$paynum)->toArray();
                //判断总价，防止app改包攻击
                if($result[0]['price'] != $data['total_fee']){
                    return 'fail';
                }
                //更新订单状态
                $purse_order_handle=$purse_order->find($result[0]['purse_oid']);
                //订单已经修改过，无需再修改
                if($purse_order_handle->state == 2){
                    return 'fail';
                }
                //将订单改为2
                $purse_order_handle->state = 2;
                $purse_order_handle->pay_num="alipay:".$data['trade_no'];
                //将钱增加到商户冻结资金
                $results=DB::table('anchong_users')->where('users_id','=',$purse_order_handle->users_id)->increment('usable_money',$result[0]['price']);
                //判断是否操作成功
                if($results){
                    $purse_order_handle->remainder=$this->users->find($purse_order_handle->users_id)->usable_money;
                    //保存订单
                    $purse_order_handle->save();
                    DB::commit();
                    // 返回处理完成
                    return 'success';
                }else{
                    //假如失败就回滚
                    DB::rollback();
                    return 'fail';
                }
            }
                break;
          case 'TRADE_FINISHED':
              // TODO: 支付成功，取得订单号进行其它相关操作。
              //开启事务处理
              DB::beginTransaction();
              $paynum=$data['out_trade_no'];
              if(strlen($paynum) == 16){
                  //创建ORM模型
                  $orders=new \App\Order();
                  $pay=new \App\Pay();
                  //判断总价防止app攻击
                  $total_price=0;
                  $order_id_arr=$pay->quer(['order_id','total_price'],'paynum ='.$paynum)->toArray();
                  foreach ($order_id_arr as $order_id) {
                      //对总价进行累加
                      $total_price +=$order_id['total_price'];
                      //进行订单操作
                      // 使用通知里的 "商户订单号" 去自己的数据库找到订单
                      $order = $orders->find($order_id['order_id']);
                      // 如果订单不存在
                      if (!$order) {
                          // 我已经处理完了，订单没找到，别再通知我了
                          return 'fail';
                      }

                      // 检查订单是否已经更新过支付状态
                      if ($order->state == 2) {
                          // 假设订单字段“支付时间”不为空代表已经支付
                          // 已经支付成功了就不再更新了
                          DB::rollback();
                          return 'fail';
                      }
                      //将订单状态改成成功并记录下支付单号
                      $order->state = 2;
                      $order->paycode="alipay:".$data['trade_no'];

                      //将钱增加到商户冻结资金
                      $result=DB::table('anchong_users')->where('sid','=',$order->sid)->increment('disable_money',$order->total_price*0.99);
                      if($result){
                          // 保存订单
                          $order->save();
                      }else{
                          //假如失败就回滚
                          DB::rollback();
                          return 'fail';
                      }
                  }

               //假如价格比对成功就提交
               if($total_price == $data['total_fee']){
                   DB::commit();
                   return 'success';
               }else{
                   //假如失败就回滚
                   DB::rollback();
                   return 'fail';
               }
           //个人钱袋订单处理
           }elseif(strlen($paynum) == 15){
               //开启事务处理
               DB::beginTransaction();
               //创建orm
               $purse_order=new \App\Purse_order();
               //通过订单查出价格和ID
               $result=$purse_order->quer(['purse_oid','price'],'order_num ='.$paynum)->toArray();
               //判断总价，防止app改包攻击
               if($result[0]['price'] != $data['total_fee']){
                   return 'fail';
               }
               //更新订单状态
               $purse_order_handle=$purse_order->find($result[0]['purse_oid']);
               //订单已经修改过，无需再修改
               if($purse_order_handle->state == 2){
                   return 'fail';
               }
               //将订单改为2
               $purse_order_handle->state = 2;
               $purse_order_handle->pay_num="alipay:".$data['trade_no'];
               //将钱增加到商户冻结资金
               $results=DB::table('anchong_users')->where('users_id','=',$purse_order_handle->users_id)->increment('usable_money',$result[0]['price']);
               //判断是否操作成功
               if($results){
                   $purse_order_handle->remainder=$this->users->find($purse_order_handle->users_id)->usable_money;
                   //保存订单
                   $purse_order_handle->save();
                   DB::commit();
                   // 返回处理完成
                   return 'success';
               }else{
                   //假如失败就回滚
                   DB::rollback();
                   return 'fail';
               }
           }
               break;
      }
  }

   /*
    *   同步通知
    */
   public function webreturn()
   {
       // 验证请求。
       if (! app('alipay.web')->verify()) {
           Log::notice('Alipay return query data verification fail.', [
               'data' => Request::getQueryString()
           ]);
           return view('test');
       }

       // 判断通知类型。
       switch (Input::get('trade_status')) {
           case 'TRADE_SUCCESS':
           case 'TRADE_FINISHED':
               // TODO: 支付成功，取得订单号进行其它相关操作。
               Log::debug('Alipay notify get data verification success.', [
                   'out_trade_no' => Input::get('out_trade_no'),
                   'trade_no' => Input::get('trade_no')
               ]);
               break;
       }

       return view('test');
   }
}
