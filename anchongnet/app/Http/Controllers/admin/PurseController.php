<?php

namespace App\Http\Controllers\admin;

use Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/*
*   该控制器操作后台钱袋模块
*/
class PurseController extends Controller
{
    //定义变量
    private $purse_order;
    private $users;

    /*
    *   执行构造方法将orm模型初始化
    */
    public function __construct()
    {
        $this->purse_order=new \App\Purse_order();
        $this->users=new \App\Users();
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
            $datas=$this->purse_order->Purse()->whereRaw('action =2')->whereRaw('state = 1')->orderBy("purse_oid","desc")->paginate(8);
            $state=0;
        }else{
            //查出提现数据
            $datas=$this->purse_order->Purse()->whereRaw('action =2')->whereRaw('state ='.$keyType)->orderBy("purse_oid","desc")->paginate(8);
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
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
        $result=$purse_order_handle->save();
        if($result){
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
