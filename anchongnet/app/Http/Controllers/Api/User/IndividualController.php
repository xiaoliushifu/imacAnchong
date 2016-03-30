<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Individual;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class IndividualController extends Controller
{
	private $individual;
	//构造方��?
	public function __construct(){
		$this->individual=new Individual();
	}

	//用户认证的方��?
    public function index(Request $request){

        //获取用户id
		$id=$request['guid'];
		$data=Individual::UsersId($id)->get();
		if(count($data)==0){
			//�����ݿ���������
			$this->individual->users_id = $id;
			$param=json_decode($request['param'],true);
			$this->individual->name = $param['name'];
			$this->individual->idcard = $param['idcard'];
			$this->individual->cases = $param['case'];
			$result=$this->individual->save();
		}else{
			$user=Individual::where('users_id', '=', $id)->first();
			$param=json_decode($request['param'],true);
			$user->name = $param['name'];
			$user->idcard = $param['idcard'];
			$user->cases = $param['case'];
			$result=$user->save();
		}
        //返回给客户端数据
		if($result){
		    return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData' => ['isSuccess'=>0,'Message'=>'认证成功']]);
		}else{
			return response()->json(['serverTime'=>time(),'ServerNo'=>7,'ResultData' => ['isSuccess'=>1,'Message'=>'未认证成功']]);
		}
	}
}
