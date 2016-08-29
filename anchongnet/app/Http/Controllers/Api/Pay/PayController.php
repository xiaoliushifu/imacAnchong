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

/*
*   支付控制器
*/
class PayController extends Controller
{
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
        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>urldecode($alipay->getPayPara())]);
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
            }elseif(strlen($notify->out_trade_no) == 15){
                //看是否成功支付
                if ($successful) {
                    //开启事务处理
                    DB::beginTransaction();
                    //创建orm
                    $purse_order=new \App\Purse_order();
                    //更新订单状态
                    $result=$purse_order->purseupdate($notify->out_trade_no,['state'=>2,'pay_num'=>"wxpay:".$notify->transaction_id]);
                    //判断是否更新成功
                    if($result){
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
    //   if (! app('alipay.mobile')->verify()) {
    //
    //       return 'fail1';
    //   }
    //Cache::add('pay-alipay', Request::instance()->getContent(), 600);

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
                           continue;
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
            }elseif(strlen($paynum) == 15){

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
                          continue;
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
           }elseif(strlen($paynum) == 15){

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
