<?php

namespace App\Http\Controllers\Api\Pay;

use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Omnipay;
use Input;
use Log;

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
        $alipay = app('alipay.web');
        $alipay->setOutTradeNo('61189914669915624');
        $alipay->setTotalFee('0.02');
        $alipay->setSubject('安虫测试付2款单');
        $alipay->setBody('goods_description');

        //$alipay->setQrPayMode('4'); //该设置为可选，添加该参数设置，支持二维码支付。

        // 跳转到支付页面。
        return redirect()->to($alipay->getPayLink());
    }

    /*
    *   异步通知
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
                //开启事务处理
                DB::beginTransaction();
                $paynum=Input::get('out_trade_no');
                //创建ORM模型
                $order=new \App\Order();
                $pay=new \App\Pay();
                $order_id_arr=$pay->quer('order_id','paynum ='.$paynum)->toArray();
                foreach ($order_id_arr as $order_id) {
                    //删除多余订单
                    $paydel=$pay->delorder($order_id);
                    //进行订单操作
                    $result=$order->orderupdate($order_id['order_id'],['state' => 2]);
                    if(!$result){
                        //再次执行
                        $result=$order->orderupdate($order_id['order_id'],['state' => 2]);
                        if(!$result){
                            //假如失败就回滚
                            DB::rollback();
                            return 'fail';
                        }
                    }
                }
                if($result){
                    $payresult=$pay->orderdel($paynum);
                    if($payresult){
                        //假如成功就提交
                        DB::commit();
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
               Log::debug('Alipay notify post data verification success.', [
                   'out_trade_no' => Input::get('out_trade_no'),
                   'trade_no' => Input::get('trade_no')
               ]);
               break;
       }
   }

   /*
   *   异步通知
   */
  public function mobilenotify()
  {
      // 验证请求。
      if (! app('alipay.mobile')->verify()) {
          Log::notice('Alipay notify post data verification fail.', [
              'data' => Request::instance()->getContent()
          ]);
          return 'fail';
      }

      // 判断通知类型。
      switch (Input::get('trade_status')) {
          case 'TRADE_SUCCESS':
               //开启事务处理
               DB::beginTransaction();
               $paynum=Input::get('out_trade_no');
               //创建ORM模型
               $order=new \App\Order();
               $pay=new \App\Pay();
               $order_id_arr=$pay->quer('order_id','paynum ='.$paynum)->toArray();
               foreach ($order_id_arr as $order_id) {
                   //进行订单操作
                   $result=$order->orderupdate($order_id['order_id'],['state' => 2]);
                   if(!$result){
                       //再次执行
                       $result=$order->orderupdate($order_id['order_id'],['state' => 2]);
                       if(!$result){
                           //假如失败就回滚
                           DB::rollback();
                           return 'fail';
                       }
                   }
               }
               if($result){
                   $payresult=$pay->orderdel($paynum);
                   if($payresult){
                       //假如成功就提交
                       DB::commit();
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
              Log::debug('Alipay notify post data verification success.', [
                  'out_trade_no' => Input::get('out_trade_no'),
                  'trade_no' => Input::get('trade_no')
              ]);
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
