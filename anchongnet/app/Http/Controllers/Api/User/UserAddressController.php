<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Address;
use DB;

class UserAddressController extends Controller
{
    private $address;
    public function __construct()
    {
        $this->address=new Address();
    }

    /*
     * 展示用户收货地址的方法
     * */
    public function show(Request $request)
    {
        $data=$this->address->User($request['guid'])->get();
        return response()->json(
            [
                "serverTime"=>time(),
                "ServerNo"=>0,
                "ResultData" => $data
            ]
        );
    }

    /*
     * 用户添加收货地址方法
     * */
    public function store(Request $request)
    {
        $param=json_decode($request['param'],true);
        $this->address->users_id=$request['guid'];
        $this->address->region = $param['region'];
        $this->address->add_name = $param['add_name'];
        $this->address->phone = $param['phone'];
        $this->address->address = $param['address'];
        $this->address->isdefault = 0;
        $result=$this->address->save();
        /*$this->address->users_id=$request['guid'];
        $this->address->region = $request['region'];
        $this->address->add_name = $request['add_name'];
        $this->address->phone = $request['phone'];
        $this->address->address = $request['address'];
        $this->address->isdefault = 0;
        $result=$this->address->save();*/
        if($result){
            return response()->json(
                [
                    "serverTime"=>time(),
                    "ServerNo"=>0,
                    "ResultData" => [
                        'Message'=>'添加成功',
                    ]
                ]
            );
        }else{
            return response()->json(
                [
                    "serverTime"=>time(),
                    "ServerNo"=>0,
                    "ResultData" => [
                        'Message'=>'添加失败，请稍后重试',
                    ]
                ]
            );
        }
    }

    /*
     * 获取默认收货地址的方法
     * */
    public function getdefault(Request $request){
        $uid=$request['guid'];
        $data=Address::UserDefault($uid);
        if($data!=null){
            /*return response()->json(
                [
                    "serverTime"=>time(),
                    "ServerNo"=>0,
                    "ResultData" => [
                        'add_name' => $data->add_name,
                        'phone'=>$data->phone,
                        'region'=>$data->region,
                        'address'=>$data->address,
                    ]
                ]*/
            return response()->json(
                [
                    "serverTime"=>time(),
                    "ServerNo"=>0,
                    "ResultData" => $data,
                ]
            );
        }else{
            $first=Address::User($request['guid'])->first();
            return response()->json(
                [
                    "serverTime"=>time(),
                    "ServerNo"=>0,
                    "ResultData" =>[
                        'add_name' => $first->add_name,
                        'phone'=>$first->phone,
                        'region'=>$first->region,
                        'address'=>$first->address,
                    ]
                ]
            );
        }
    }

    /*
     * 设置默认收货地址的方法
     * */
    public function setdefault(Request $request)
    {
        $param=json_decode($request['param'],true);
        $id=$param['aid'];
        //通过事务处理修改收货地址表中的是否默认状态
        DB::beginTransaction();
        DB::table('anchong_users_address')->where('users_id', $request['guid'])->update(['isdefault' => 0]);
        DB::table('anchong_users_address')->where('id', $id)->update(['isdefault' => 1]);
        DB::commit();
        return response()->json(
            [
                "serverTime"=>time(),
                "ServerNo"=>0,
                "ResultData" => [
                    'Message'=>'设置成功！success!',
                ]
            ]
        );
    }

    /*
     * 进入收货地址界面的方法
     * */
    public function edit(Request $request)
    {
        $param=json_decode($request['param'],true);
        $data=$this->address->find($param['aid']);
        if($data==null){
            return response()->json(
                [
                    "serverTime"=>time(),
                    "ServerNo"=>1,
                    "ResultData" => [
                        'Message'=>'获取失败，请稍后重试! failed!',
                    ]
                ]
            );
        }else{
            return response()->json(
                [
                    "serverTime"=>time(),
                    "ServerNo"=>0,
                    "ResultData" => [
                        'Message'=>$data
                    ]
                ]
            );
        }
    }

    /*
     * 用户执行修改收货地址动作的方法
     * */
    public function update(Request $request){
        $param=json_decode($request['param'],true);
        $data=$this->address->find($param['aid']);
        $data->region=$param['region'];
        $data->add_name=$param['add_name'];
        $data->phone=$param['phone'];
        $data->address=$param['address'];
        $result=$data->save();
        if($result){
            return response()->json(
                [
                    "serverTime"=>time(),
                    "ServerNo"=>0,
                    "ResultData" => [
                        'Message'=>'updata success!',
                    ]
                ]
            );
        }else{
            return response()->json(
                [
                    "serverTime"=>time(),
                    "ServerNo"=>1,
                    "ResultData" => [
                        'Message'=>'update failed!',
                    ]
                ]
            );
        }
    }

    /*
     * 用户删除收货地址的方法
     * */
    public function del(Request $request){
        $param=json_decode($request['param'],true);
        $data = $this->address->find($param['aid']);
        $data->delete();
        return response()->json(
            [
                "serverTime"=>time(),
                "ServerNo"=>0,
                "ResultData" => [
                    'Message'=>'deleted success!',
                ]
            ]
        );
    }
}
