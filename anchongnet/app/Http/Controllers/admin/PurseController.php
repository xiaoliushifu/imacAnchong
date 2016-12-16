<?php

namespace App\Http\Controllers\admin;

use Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;

/**
*   该控制器包含了钱袋模块的操作
*/
class PurseController extends Controller
{
    //定义变量
    private $purse_order;
    private $users;
    private $propel;

    /**
    *   执行构造方法将orm模型初始化
    */
    public function __construct()
    {
        $this->purse_order=new \App\Purse_order();
        $this->users=new \App\Users();
        $this->propel=new \App\Http\Controllers\admin\Propel\PropelmesgController();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keyType=Request::input("type");
        //判断有无筛选标签
        if($keyType==""){
            //查出提现数据
            $datas=$this->purse_order->Purse()->where('action','2')->where('state','1')->orderBy("purse_oid","ASC")->paginate(8);
            $state=1;
        }else{
            //查出提现数据
            $datas=$this->purse_order->Purse()->where('action','2')->where('state',$keyType)->orderBy("purse_oid","desc")->paginate(8);
            if($keyType == 1){
                $state=1;
            }else{
                $state=0;
            }
        }
        $args['type']=$keyType;
        return view('admin/purse/index',array("datacol"=>compact("args","datas"),'state'=>$state));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //判断是否是admin
        if(Auth::user()->users_id !=1){
            return ;
        }
        return view('admin/purse/recharge');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request('','','','','')
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //判断是否是admin
        if(Auth::user()->users_id !=1){
            return ;
        }
        //获得所有的内容
        $data=$request::all();
        //取出支付密码
        $paypassword=DB::table('anchong_users')->where('users_id',1)->pluck('password');
        //判断用户是否设置支付密码
        if(!$paypassword[0]){
            return '请先设置支付密码';
        }
        //判断支付密码是否可用(后期做大以后一定记得控制错误次数)
        if($paypassword[0] != md5($data['password'])){
            return '支付密码错误';
        }
        //得到结果
        $result=DB::table('anchong_users')->where('phone',$data['username'])->increment('usable_money',$data['money']);
        //判断结果
        if($result){
            return "充值成功";
        }else{
            return "充值失败";
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id钱袋订单ID
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //定义数据数组
        $data=[];
        //获得用户的句柄
        $users_handle=$this->users->find($id);
        $data['phone']=$users_handle->phone;
        $data['usable_money']=$users_handle->usable_money;
        return $data;
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
     * @param  无
     * @param  int  $id钱袋订单ID
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //获得钱袋订单的句柄
        $purse_order_handle=$this->purse_order->find($id);
        //如果状态为2则是已提现成功
        if($purse_order_handle->state == 2){
            return "该用户早已提现";
        }
        //改变该订单状态
        $purse_order_handle->state = 2;
        $users_id=$purse_order_handle->users_id;
        $result=$purse_order_handle->save();
        if($result){
            try{
                //推送消息
                $this->propel->apppropel($this->users->find($users_id)->phone,'提现进度',"您好，您申请的提现已成功！");
            }catch (\Exception $e) {
                return "操作成功";
            }
            return "操作成功";
        }else{
            return "操作失败";
        }
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
