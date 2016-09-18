<?php

namespace App\Http\Controllers\Api\Purse;

use Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Cache;
use DB;
use Validator;

/*
*   该控制器包含了钱袋模块的操作
*/
class PurseController extends Controller
{
    //定义变量
    private $users;
    private $users_message;
    private $coupon;
    private $coupon_pool;
    private $purse_order;

    /*
    *   执行构造方法将orm模型初始化
    */
    public function __construct()
    {
        $this->users=new \App\Users();
        $this->users_message=new \App\Usermessages();
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
        //查出个人信息
        $users_handle=$this->users->find($data['guid']);
        $beans=$users_handle->beans;
        $usable_money=$users_handle->usable_money;
        $usersmessage=$this->users_message->quer(['headpic','nickname'],['users_id'=>$data['guid']])->toArray();
        try{
            if(!$usersmessage[0]['nickname']){
                return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'请完善个人信息中的昵称']]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'请完善个人信息中的昵称']]);
        }
        //头像信息
        if(empty($usersmessage[0]['headpic'])){
            $headpic="http://anchongres.oss-cn-hangzhou.aliyuncs.com/headpic/placeholder120@3x.png";
        }else{
            $headpic=$usersmessage[0]['headpic'];
        }
        //定义优惠券字段
        $coupon_data=['acpid','title','cvalue','target','beans','endline'];
        //查出余额数据
        $coupon_pool_data=$this->coupon_pool->quer($coupon_data,'endline > '.time().' and open = 1 and beans > 0',(($param['page']-1)*$limit),$limit);
        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['headpic'=>$headpic,'nickname'=>$usersmessage[0]['nickname'],'beans'=>$beans,'usable_money'=>$usable_money,'coupon'=>$coupon_pool_data]]);
    }

    /*
    *   优惠券兑换
    */
    public function couponexchange(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //开启事务处理
        DB::beginTransaction();
        //获取优惠券句柄
        $coupon_pool_handle=$this->coupon_pool->find($param['acpid']);
        $coupon_pool_beans=$coupon_pool_handle->beans;
        //获取用户句柄
        $users_handle=$this->users->find($data['guid']);
        //判断该优惠券是否可以兑换
        if($coupon_pool_beans == 0){
            return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'该优惠券不可兑换']]);
        }
        //判断虫豆是否够
        if($users_handle->beans < $coupon_pool_beans){
            return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'虫豆余额不足，请充值']]);
        }
        //剩余虫豆数量
        $users_handle->beans=$users_handle->beans-$coupon_pool_beans;
        //保存获得结果
        $result=$users_handle->save();
        if(!$result){
            //假如失败就回滚
            DB::rollback();
            return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'兑换失败']]);
        }
        //得到券后的过期时间与券本身的过期时间作对比
        $user_time=time()+7776000;
        if($coupon_pool_handle->endline>$user_time){
            $endtime=$user_time;
        }else{
            $endtime=$coupon_pool_handle->endline;
        }
        //优惠券数据
        $coupon_data=[
            'users_id' => $data['guid'],
            'cpid' => $param['acpid'],
            'target' => $coupon_pool_handle->target,
            'cvalue' => $coupon_pool_handle->cvalue,
            'shop' => $coupon_pool_handle->shop,
            'type' => $coupon_pool_handle->type,
            'type2' => $coupon_pool_handle->type2,
            'num' => 1,
            'end' => $endtime,
        ];
        //插入个人优惠券表
        $cpresult=DB::table('anchong_coupon')->insertGetId($coupon_data);
        //判断是否插入成功
        if(!$cpresult){
            //假如失败就回滚
            DB::rollback();
            return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'兑换失败']]);
        }
        //假如成功就提交
        DB::commit();
        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'兑换成功']]);
    }

    /*
    *   我的优惠券
    */
    public function mycoupon(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //默认每页数量
            $limit=8;
            //定义优惠券字段
            $coupon_data=['acpid','title','cvalue','target'];
            //匹配查看的优惠券类型
            switch ($param['state']) {
                //未使用的优惠券
                case '1':
                    //统计数量
                    $coupon_count=$this->coupon->Coupon()->whereRaw('users_id = '.$data['guid'].' and end >'.time())->count();
                    $coupon_cpid=$this->coupon->Coupon()->select('cpid','end')->whereRaw('users_id = '.$data['guid'].' and end >'.time())->skip((($param['page']-1)*$limit))->take($limit)->get();
                    //定义数组
                    $coupon_result=[];
                    //遍历出ID
                    foreach ($coupon_cpid as $coupon_id) {
                        $coupon_arr=$this->coupon_pool->Coupon()->select($coupon_data)->where('acpid','=',$coupon_id->cpid)->get()->toArray();
                        //将二维数组遍历并将过期时间加进结果内
                        foreach ($coupon_arr as $coupon) {
                            $coupon['endline']=$coupon_id->end;
                            $coupon['state']=$param['state'];
                            $coupon_result[]=$coupon;
                        }
                    };
                    break;
                //已过期的优惠券
                case '2':
                    //统计数量
                    $coupon_count=$this->coupon->Coupon()->whereRaw('users_id = '.$data['guid'].' and end <'.time())->count();
                    $coupon_cpid=$this->coupon->Coupon()->select('cpid','end')->whereRaw('users_id = '.$data['guid'].' and end <'.time())->skip((($param['page']-1)*$limit))->take($limit)->get();
                    //定义数组
                    $coupon_result=[];
                    //遍历出ID
                    foreach ($coupon_cpid as $coupon_id) {
                        $coupon_arr=$this->coupon_pool->Coupon()->select($coupon_data)->where('acpid','=',$coupon_id->cpid)->get()->toArray();
                        //将二维数组遍历并将过期时间加进结果内
                        foreach ($coupon_arr as $coupon) {
                            $coupon['endline']=$coupon_id->end;
                            $coupon['state']=$param['state'];
                            $coupon_result[]=$coupon;
                        }
                    };
                    break;
                //不是这两个就是非法操作
                default:
                    return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'非法操作']]);
                    break;
            }
            //返回结果
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['total'=>$coupon_count,'list'=>$coupon_result]]);
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }


    /*
    *   优惠券使用
    */
    public function usecoupon(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //定义商铺ID数组,因为shop为0表示全场通用所有数组初始有0元素
        $sid_arr=[0];
        //定义已商铺ID为键数组索引为值的数组
        $sid_index=[];
        //定义可用优惠券数组
        $acp_id=[];
        //遍历出数据
        for($i=0;$i<count($param['list']);$i++){
            $sid_arr[]=$param['list'][$i]['sid'];
            $sid_index[$param['list'][$i]['sid']]=$i;
        }
        //查出该用户下对应店铺的优惠券
        $coupons_arr=$this->coupon->Coupon()->where('users_id',$data['guid'])->whereRaw('end > '.time())->whereIn('shop',$sid_arr)->select('cpid','target','shop','type','type','type2','end')->get()->toArray();
        //遍历出所有的优惠券
        foreach ($coupons_arr as $coupons) {
            //判断是否是全场通用的券
            if($coupons['shop'] == 0){
                //根据总价判断是否可用
                if($param['total_price'] >= $coupons['target']){
                    //将可用的优惠券ID和结束时间放入数组
                    $acp_id[]=['acpid'=>$coupons['cpid'],'endline'=>$coupons['end']];
                }
            }else{
                //如果不是全场通用券就判断它是否符合使用标准
                $shopcoupon=$param['list'][$sid_index[$coupons['shop']]];
                //判断是商铺下什么使用类型的券
                switch ($coupons['type']) {
                    //如果是商铺通用则执行下面操作
                    case '1':
                        //判断是否符合使用条件
                        if($shopcoupon['shop_price'] >= $coupons['target']){
                            //将可用的优惠券ID和结束时间放入数组
                            $acp_id[]=['acpid'=>$coupons['cpid'],'endline'=>$coupons['end']];
                        }
                        break;
                    //如果是商品使用则执行下面操作
                    case '3':
                        foreach ($shopcoupon['goods'] as $goodscoupon) {
                            //判断是否有对应商品可用的优惠券，并且是否符合使用条件
                            if($coupons['type2'] == $goodscoupon['gid'] && $goodscoupon['price'] >= $coupons['target']){
                                //将可用的优惠券ID和结束时间放入数组
                                $acp_id[]=['acpid'=>$coupons['cpid'],'endline'=>$coupons['end']];
                            }
                        }
                        break;

                    default:
                        # code...
                        break;
                }
            }
        }
        //定义优惠券字段
        $coupon_data=['acpid','title','cvalue','target','shop','type','type2'];
        //定义数组
        $coupon_result=[];
        //遍历出ID
        foreach ($acp_id as $coupon_id) {
            $coupon_arr=$this->coupon_pool->Coupon()->select($coupon_data)->where('acpid','=',$coupon_id['acpid'])->get()->toArray();
            //将二维数组遍历并将过期时间加进结果内
            foreach ($coupon_arr as $coupon) {
                $coupon['endline']=$coupon_id['endline'];
                $coupon_result[]=$coupon;
            }
        };
        //返回结果
        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$coupon_result]);
    }


    /*
    *   虫豆充值界面
    */
    public function beansrecharge(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //获得个人信息的句柄
        $users_handle=$this->users->find($data['guid']);
        //获得个人的虫豆数量
        $beans=$users_handle->beans;
        //获得个人可用余额
        $usable_money=$users_handle->usable_money;
        //获得用户信息
        $usersmessage=$this->users_message->quer(['headpic','nickname'],['users_id'=>$data['guid']])->toArray();
        try{
            if(!$usersmessage[0]['nickname']){
                return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'请完善个人信息中的昵称']]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'请完善个人信息中的昵称']]);
        }
        //头像信息
        if(empty($usersmessage[0]['headpic'])){
            $headpic="http://anchongres.oss-cn-hangzhou.aliyuncs.com/headpic/placeholder120@3x.png";
        }else{
            $headpic=$usersmessage[0]['headpic'];
        }
        //查出数据
        $tariff_result=DB::table('anchong_beans_recharge')->get();
        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['headpic'=>$headpic,'nickname'=>$usersmessage[0]['nickname'],'usable_money'=>$usable_money,'beans'=>$beans,'tariff'=>$tariff_result]]);
    }

    /*
    *   虫豆购买
    */
    public function buybeans(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        $beans_data=DB::table('anchong_beans_recharge')->select('beans','money')->where('beans_id', $param['beans_id'])->get();
        //获得个人信息的句柄
        $users_handle=$this->users->find($data['guid']);
        //获得个人的虫豆数量
        $beans=$users_handle->beans;
        //获得个人可用余额
        $usable_money=$users_handle->usable_money;
        //判断钱够不够
        if($beans_data[0]->money > $usable_money){
            return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'您的可用余额不足请充值']]);
        }
        //将余额减去
        $surplus=$usable_money-$beans_data[0]->money;
        $users_handle->usable_money=$surplus;
        //将虫豆加上
        $users_handle->beans=$beans+$beans_data[0]->beans;
        $result=$users_handle->save();
        //判断是否更新成功
        if($result){
            //生成钱袋订单编号
            $order_num=rand(1000,9999).substr($data['guid'],0,1).time();
            //将消费记录插入个人钱袋的消费表
            $purse_order= DB::table('anchong_purse_order')->insertGetId(
                [
                    'order_num' =>$order_num,
                    'users_id' => $data['guid'],
                    'pay_num' => "money:虫豆充值",
                    'price' => $beans_data[0]->money,
                    'action' => 3,
                    'created_at' => date('Y-m-d H:i:s',$data['time']),
                    'state' => 2,
                    'remainder' => $surplus,
                ]
            );
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'购买成功']]);
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'购买失败，请重试']]);
        }
    }

    /*
    *   签到页面
    */
    public function signinindex(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //默认每页数量
        $limit=8;
        //今天零点的时间
        $todaytime=strtotime(date('Ymd',time()));
        //判断今天是否签到
        $users_handle=$this->users->find($data['guid']);
        $sign_day=$users_handle->day;
        if($users_handle->sign_time>$todaytime){
            $sign_state=1;
        }else{
            $sign_state=0;
        }
        //查出签到的天数和每天的虫豆数量
        $signin_data=DB::table('anchong_signin')->select('day','beans')->get();
        //定义优惠券字段
        $coupon_data=['acpid','title','cvalue','target','beans','endline'];
        //查出余额数据
        $coupon_pool_data=$this->coupon_pool->quer($coupon_data,'endline > '.time().' and open = 1 and beans > 0',(($param['page']-1)*$limit),$limit);
        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['sign_state'=>$sign_state,'sign_day'=>$sign_day,'signin'=>$signin_data,'coupon'=>$coupon_pool_data]]);
    }

    /*
    *   点击签到
    */
    public function signin(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //现在的时间
        $nowtime=time();
        //今天零点的时间
        $todaytime=strtotime(date('Ymd',$nowtime));
        //明天零点的时间
        $nexttime=$todaytime+86400;
        //获得用户的句柄
        $users_handle=$this->users->find($data['guid']);
        //获取用户签到时间
        $signintime=$users_handle->sign_time;
        //判断用户是否是第一次签到
        if(!$signintime){
            //如果第一次则增加第一次的虫豆
            $sign_beans = DB::table('anchong_signin')->where('signin_id', '1')->pluck('beans');
            $users_handle->day=2;
            $users_handle->sign_time=$nowtime;
        }else{
            if($signintime > $todaytime){
                return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'请不要重复签到']]);
            }
            //如果不是第一次则判断是否是连续签到
            //昨天凌晨的时间
            $yesterdaytime=$todaytime-86400;
            //判断是否断签
            if($signintime < $yesterdaytime){
                //如果断签则增加第一次的虫豆
                $sign_beans = DB::table('anchong_signin')->where('signin_id', '1')->pluck('beans');
                $users_handle->day=2;
                $users_handle->sign_time=$nowtime;
            }else{
                //如果没有断签
                $sign_beans = DB::table('anchong_signin')->where('signin_id', $users_handle->day)->pluck('beans');
                //假如连续签到天数大于5
                if($users_handle->day > 5){
                    //将连续签到天数变成1
                    $users_handle->day=1;
                    $users_handle->sign_time=$nowtime;
                }else{
                    //将连续签到天数增加1
                    $users_handle->day =$users_handle->day+1;
                    $users_handle->sign_time=$nowtime;
                }
            }
        }
        //将虫豆添加
        $users_handle->beans=$users_handle->beans+$sign_beans[0];
        $result=$users_handle->save();
        //判断是否成功
        if($result){
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'签到成功']]);
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'签到失败']]);
        }
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

    /*
    *   钱袋提现状态
    */
    public function withdrawstate(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //得到用户钱袋订单正在提现的数量,看看有没有
        $num=$this->purse_order->Purse()->whereRaw('users_id ='.$data['guid'].' and action = 2 and state =1')->count();
        //判断是否有正在提现的账单
        if($num > 0){
            //将账单查出来
            $purse_data=$this->purse_order->Purse()->select('remark','pay_num','price')->whereRaw('users_id ='.$data['guid'].' and action = 2 and state =1')->first();
            $pay_num=explode(":",$purse_data->pay_num);
            //取出正在提现的信息
            $remark=$purse_data->remark;
            $account=$pay_num[1];
            $price=$purse_data->price;
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['state'=>1,'remark'=>$remark,'account'=>$account,'price'=>$price]]);
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['state'=>0,'remark'=>"",'account'=>"",'price'=>""]]);
        }
    }

    /*
    *   钱袋提现
    */
    public function withdraw(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //验证用户传过来的数据是否合法
        $validator = Validator::make($param,
        [
            'name' => 'required',
            'account' => 'required',
            'phonecode' => 'required',
        ]
        );
        //如果出错返回出错信息，如果正确执行下面的操作
        if ($validator->fails())
        {
            $messages = $validator->errors();
            if ($messages->has('name')) {
                //如果验证失败,返回验证失败的信息
                return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'收款人姓名不能为空']]);
            }else if($messages->has('account')){
                return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'收款人账号不能为空']]);
            }else if($messages->has('phonecode')){
                return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'验证码不能为空']]);
            }
        }
        //得到用户信息的句柄
        $users_handle=$this->users->find($data['guid']);
        //判断手机验证码是否正确
        if(Cache::get($users_handle->phone.'身份验证') != $param['phonecode']){
            return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'手机验证码不正确']]);
        }
        //删除验证码
        Cache::forget($users_handle->phone.'身份验证');
        //查出用户可用余额
        $users_handle=$this->users->find($data['guid']);
        $usable_money=$users_handle->usable_money;
        //判断防止app恶意改包攻击
        if($param['price']>$usable_money){
            return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'非法操作']]);
        }
        //将提现的钱从余额扣除
        $users_handle->usable_money=$usable_money-$param['price'];
        $users_handle->save();
        //生成订单编号
        $order_num=rand(1000,9999).substr($data['guid'],0,1).time();
        //插入订单数据
        $order_data=[
            'order_num' =>$order_num,
            'users_id' => $data['guid'],
            'pay_num' => $param['name'].":".$param['account'],
            'price' => $param['price'],
            'action' => 2,
            'created_at' => date('Y-m-d H:i:s',$data['time']),
            'remainder' => $usable_money-$param['price'],
        ];
        //判断提现方式
        switch ($param['payment']) {
            //支付宝支付
            case 1:
                //增加订单备注
                $order_data['remark']='支付宝提现';
                break;

            //对公账号
            case 3:
                //增加订单备注
                $order_data['remark']='对公账号提现';
                break;

            default:
                return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'非法操作']]);
                break;
        }
        //生成订单
        $result=$this->purse_order->add($order_data);
        //判断是否成功
        if($result){
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['remark'=>$order_data['remark'],'account'=>$param['account'],'price'=>$param['price']]]);
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'提现失败']]);
        }
    }

    /*
    *   账单
    */
    public function bill(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //定义分页
        $limit=20;
        //查询数据
        $bill_data=['purse_oid','action','price','remainder','created_at'];
        //查询账单
        $bill_result=$this->purse_order->pagequer($bill_data,'users_id ='.$data['guid'].' and state =2',(($param['page']-1)*$limit),$limit);
        //判断是否有账单
        if($bill_result){
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$bill_result]);
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['total'=>0,'list'=>[]]]);
        }
    }

    /*
    *   账单详情
    */
    public function billinfo(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //查询数据
        $billinfo_data=['purse_oid','price','action','created_at','order_num','remainder','remark'];
        //查出单个账单的详情
        $billinfo_result=$this->purse_order->quer($billinfo_data,'purse_oid ='.$param['purse_oid'].' and users_id ='.$data['guid'])->toArray();
        if($billinfo_result){
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$billinfo_result[0]]);
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>"查询失败"]]);
        }
    }

    /*
    *   账单删除
    */
    public function delbill(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //查询账单
        $result=$this->purse_order->pursedel($param['purse_oid']);
        //判断是否有账单
        if($result){
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>"删除成功"]]);
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>"删除失败"]]);
        }
    }
}
