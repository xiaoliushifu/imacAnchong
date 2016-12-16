<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Request as Requester;

use App\Http\Controllers\Controller;
use App\Order;
use App\Orderinfo;
use DB;
use Mail;
use Gate;
use Auth;
use App\Exp;
use App\Shop;
use App\Goods_logistics;

/**
*   该控制器包含了订单模块的操作
*/
class orderController extends Controller
{
    private $order;
    private $orderinfo;
    private $uid;
    private $sid;
    private $gl;
    public function __construct()
    {
        $user = Auth::user();
        if (!$user) {
            return null;
        }
        $this->uid = $user->users_id;
        if ($user->user_rank == 3) {
            $this->sid = 1;
        } else {
            $shop = Shop::where('users_id',$this->uid)->first();
            if ($shop) {
                $this->sid=$shop->sid;
            } else {
                return null;
            }
        }
    }

    /**
	 * 后台订单管理列表
     *
     * @param  input('KEYNUM'区分查询数据的关键字)
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $kn=Requester::input('kn');
        $ks=Requester::input('state');
        $this->order=new Order();
        if ($kn) {
            if($this->sid ==1 ){
                $datas=$this->order->where('order_num',$kn)->orderBy("order_id","desc")->paginate(8);
            }else{
                $datas = Order::num($kn,$this->sid)->orderBy("order_id","desc")->paginate(8);
            }
        } elseif ($ks) {
            $datas=$this->order->where("sid","=",$this->sid)->where('state',$ks)->orderBy("order_id","desc")->paginate(8);
        } else {
            $datas=$this->order->where("sid","=",$this->sid)->orderBy("order_id","desc")->paginate(8);
        }
        $args=array("state"=>$ks);
        return view('admin/order/index',array("datacol"=>compact("args","datas")));
    }

    /**
     * 向物流公司下单后，查看其回馈的状态信息
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postStatus(Request $req)
    {
        $lnum = $req->lnum;
        $ret = ['order'=>'','wl'=>''];
        $odata = ['company','content','time'];
        $ldata = ['company','bill_code','data'];
        $ostatus = DB::table('anchong_ostatus')->where('logisticsnum',$lnum)->get($odata);
        $lstatus = DB::table('anchong_lstatus')->where('logisticsnum',$lnum)->get($ldata);
        foreach ($ostatus as $o) {
            $ret['order'] .=$o->company.'---'.$o->content.'---'.$o->time.'<br>';
        }
        foreach ($lstatus as $o) {
            $ret['wl'] .='快递公司: '.$o->company.'---运单号: '.$o->bill_code.'<br>';
            $tmp = unserialize($o->data);
            foreach ($tmp as $sub) {
                $ret['wl'] .=$sub['time'].'---'.$sub['content'].'<br>';
            }
        }
        return $ret;
    }


    /**
     * 审核订单，ajax调用
     * 需手动在对应（支付宝|微信）账号退款，然后这里执行通过。
     *
     * @param  $request('isPass'是否退货,'num'订单标号,'gid'货品ID,'oid'订单ID)
     * @return \Illuminate\Http\Response
     */
    public function postCheckorder(Request $request)
    {
        $this->order=new Order();
        //获取订单ID
        $id=$request->oid;
        //得到操作订单数据的句柄
        $data=$this->order->find($id);
        //开启事务处理
        DB::beginTransaction();
        //判断是否通过退货
        if ($request->isPass==="pass") {
            $this->orderinfo=new Orderinfo();
            //若通过退货则改变订单状态并将商品数量还原
            $datasarr=$this->orderinfo->where('order_num','=',$request->num)->get()->toArray();
            //遍历得到的结果
            foreach ($datasarr as $datas) {
                //更改货品列表的数量
                DB::table('anchong_goods_specifications')->where('gid','=',$datas['gid'])->increment('goods_num',$datas['goods_num']);
                //更改区域表的数量
                DB::table('anchong_goods_stock')->where('gid','=',$datas['gid'])->increment('region_num',$datas['goods_num']);
            }
            $money_result=DB::table('anchong_users')->where('sid','=',$this->sid)->decrement('disable_money',$request->total_price);
            if(!$money_result){
                DB::rollback();
                return "操作失败";
            }
            //如果是余额支付的话就需要余额改变
            if($request->paytype == "moneypay"){
                $moneyadd=DB::table('anchong_users')->where('users_id','=',$request->users_id)->increment('usable_money',$request->total_price);
                if(!$moneyadd){
                    DB::rollback();
                    return "操作失败";
                }
            }
            //改变订单状态为已退款
            $data->state=5;
        } else {
            //改变订单状态为代发货
            $data->state=3;
        }
        $data->save();
        //假如成功就提交
        DB::commit();
        return "操作成功";
    }

    /**
     * 订单发货的方法
     * 由订单列表页，点击"发货",选择完发货方式后执行
     *
     * @param  $request('orderid'订单ID,'ship'行为参数,'lognum'物流单号,'logistics'企业)
     * @return \Illuminate\Http\Response
     */
    public function postOrdership(Request $req)
    {
        //权限判定
        if (Gate::denies('order-ship')) {
            return back();
        }
        DB::beginTransaction();
        $this->order=new Order();
        $carrier=['0','hand'];
        
        $data = $this->order->find($req['orderid']);
        $orderpa = clone $data;
        Mail::raw(print_r($req->all(),true),function($message){
            $message->subject('物流下单了');
            $message->from('872140945@qq.com');
            $message->cc('872140945@qq.com')->to('www@anchong.net');
        });
        //物流发货方式,否则手动发货
        if ($req['ship'] == "wl") {
           //获得订单数据，准备聚合接口的请求参数
           //以下三个地址
           $tmp = explode(' ',$orderpa['address']);
           //兼容性
           if(count($tmp)<2){
               $tmp[2]=$tmp[1]=$tmp[0];
           }
           //拆出来省市区
           $orderpa['receiver_province_name'] = $tmp[0];
           $orderpa['receiver_city_name'] = $tmp[1];
           $orderpa['receiver_district_name'] = $tmp[2];
           //以上三个地址
           $orderpa['send_start_time'] = date('Y-m-d H:i:s',time()+3600);//通知快递员X分钟后取件
           $orderpa['send_end_time'] = date('Y-m-d H:i:s',time()+7200);
           //$orderpa['phone'] = '18600818638';
           //去掉空格字符，否则下单不成功
           $orderpa['address'] = str_replace(' ','',$orderpa['address']);
           
           $exp = new Exp();
           //向指定物流公司下单
           $carrier = explode('|',$req['logistics']);
           $res = $exp->sendOrder($orderpa,$carrier[0]);
            //记录一次下单
            \Log::info(print_r($res,true),['result_juheSend:'.$orderpa['order_num']]);
            if ($res['error_code'] != '0') {//正常下单
                return $res['reason'];
            }
        }
        //记录一次下单
        $this->gl=new Goods_logistics();
        $this->gl->logisticsnum=$req['onum'];
        $this->gl->order_id=$req['orderid'];
        $this->gl->com_code=$carrier[0];//物流公司编号
        $this->gl->company=$carrier[1];
        $this->gl->save();

        //改状态为'3待收货'
        $data->state=3;
        $data->save();
        DB::commit();
        $this->propleinfo($data->users_id,'订单发货通知','您订单编号为'.$data->order_num.'的订单已发货，感谢您对安虫平台的支持！');
        return '';
    }


    /*
     * 由聚合回调，用于安虫下单后，接收其有关订单状态的信息
     * */
    public function ostatus(Request $req)
    {

//         $black = ['121.43.160.158','123.150.107.239','124.239.251.119','127.0.0.1'];
//         if (!in_array($req->ip(),$black)){
//             return '非法请求';
//         }
        $header = getallheaders();
        $body = file_get_contents('php://input');
        \Log::info("clientIP:".$req->ip().print_r($header,true).PHP_EOL.$body,['订单推送信息']);
        $body = json_decode($body,true);
        if ($this->derror($body)) {
            return 'error';
        }
        $res=$body['orders'][0];
        DB::table('anchong_ostatus')->insert(['logisticsnum'=>$res['order_no'],'company'=>$res['carrier_code'],'status'=>$res['status'],'time'=>$res['time'],'content'=>$res['content']]);
        return 'success';
    }

    /*
     * 由聚合回调，用于安虫下单后，接收其有关物流状态的信息
     * */
    public function lstatus(Request $req)
    {

//         $black = ['121.43.160.158','123.150.107.239','124.239.251.119','127.0.0.1'];
//         if (!in_array($req->ip(),$black)){
//             return '非法请求';
//         }
        $header = getallheaders();
        $body = file_get_contents('php://input');
        \Log::info("clientIP:".$req->ip().print_r($header,true).PHP_EOL.$body,['物流推送信息']);
        $body = json_decode($body,true);
        if ($this->derror($body)) {
            return 'error';
        }
        $res=$body['orders'][0]['order'];
        $data=$body['orders'][0]['data'];
        DB::table('anchong_lstatus')->insert(['logisticsnum'=>$res['order_no'],'company'=>$res['carrier_code'],'bill_code'=>$res['bill_code'],'status'=>$res['status'],'data'=>serialize($data)]);
        //物流发货方式
        return 'success';
    }

    /*
     * 取消物流订单的方法
     * */
    public function postOrdercancel(Request $req)
    {
        //权限判定
        if (Gate::denies('order-ship')) {
            return back();
        }
        DB::beginTransaction();
        //下单表
        $this->gl=Goods_logistics::where('order_id',$req['oid'])->where('ship',1)->first();
        if (!$this->gl) {
            return '本来就没有发货';
        }
        $this->gl->ship=0;
        $this->gl->save();
        //物流公司退单
        if ($this->gl->com_code) {
            $exp = new Exp();
            $res = $exp->cancelOrder($req,$this->gl->com_code);
            //记录一次撤单
            \Log::info(print_r($res,true),['juheCancel:'.$req['onum']]);
            if ($res['error_code']!='0') {//正常撤单
                return $res['reason'];
            }
        }

        //订单表更新
        $this->order=new Order();
        $data=$this->order->find($req['oid']);
        //改回状态为'2待发货'
        $data->state=2;
        $data->save();
        DB::commit();
        $this->propleinfo($data->users_id,'发货取消通知','您订单编号为'.$data->order_num.'的订单已停止发货，感谢您对安虫平台的支持！');
        return '';
    }
    /*
     * 获取订单支付信息
     * */
    public function getPaycode(Request $req)
    {
        $data=DB::table('anchong_goods_order')->where('order_id',$req->id)->pluck('paycode');
        return $data;
    }

    /*
    * 确认收货
    */
    public static function confirm($order_id_arr)
    {
        //$order_id_arr=DB::table('anchong_goods_order')->select('order_id')->where('state',3)->where('updated_at','<',date('Y-m-d H:i:s',($nowtime-864000)))->get();
        $order=new \App\Order();
        //进行订单编号遍历
        foreach ($order_id_arr as $order_id) {
            //开启事务处理
            DB::beginTransaction();
            //获取订单句柄
            $order_handle=$order->find($order_id->order_id);
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
                \Log::info('OrderMessage',['确认收货操作资金修改失败,订单号'.$order_handle->order_num]);//统计
            }
            if($results){
                //创建ORM模型
                $orderinfo=new \App\Orderinfo();
                $order_gid=$orderinfo->quer(['gid','goods_num'],'order_num ='.$order_handle->order_num)->toArray();
                foreach ($order_gid as $gid) {
                    DB::table('anchong_goods_specifications')->where('gid','=',$gid['gid'])->increment('sales',$gid['goods_num']);
                    DB::table('anchong_goods_type')->where('gid','=',$gid['gid'])->increment('sales',$gid['goods_num']);
                }
                //假如成功就提交
                DB::commit();
                \Log::info('OrderMessage',['确认收货成功,订单号'.$order_handle->order_num]);//统计
            }else{
                //假如失败就回滚
                DB::rollback();
                \Log::info('OrderMessage',['确认收货操作资金保存失败,订单号'.$order_handle->order_num]);//统计
            }
        }
    }

    /**
    *    该方法提供了订单的推送服务
    *
    * @param  用户ID  $users_id
    * @param  标题    $title
    * @param  信息    $message
    * @return \Illuminate\Http\Response
    */
    private function propleinfo($users_id,$title,$Message)
    {
        //处理成功给用户和商户推送消息
        try{
            //创建ORM模型
            $users=new \App\Users();
            $this->propel=new \App\Http\Controllers\admin\Propel\PropelmesgController();
            //推送消息
            $this->propel->apppropel($users->find($users_id)->phone,$title,$Message);
            DB::table('anchong_feedback_reply')->insertGetId(
                [
                    'title' => $title,
                    'content' => $Message,
                    'users_id' => $users_id,
                ]
             );
             return true;
        }catch (\Exception $e) {
            // 返回处理完成
            return true;
        }
    }
    /**
     * 用于解析聚合回调的json信息
     * @param unknown $data
     */
    private function derror($data)
    {
        $res = '';
        if (!$data) {
            switch (json_last_error()) {
                case JSON_ERROR_NONE:
                    $res =  ' - No errors';
                    break;
                case JSON_ERROR_DEPTH:
                    $res =  ' - Maximum stack depth exceeded';
                    break;
                case JSON_ERROR_STATE_MISMATCH:
                    $res =  ' - Underflow or the modes mismatch';
                    break;
                case JSON_ERROR_CTRL_CHAR:
                    $res =  ' - Unexpected control character found';
                    break;
                case JSON_ERROR_SYNTAX:
                    $res =  ' - Syntax error, malformed JSON';
                    break;
                case JSON_ERROR_UTF8:
                    $res =  ' - Malformed UTF-8 characters, possibly incorrectly encoded';
                    break;
                default:
                    $res =  ' - Unknown error';
                    break;
            }
            \Log::info($res,['json_error']);
        }
        return $res;
    }

}
