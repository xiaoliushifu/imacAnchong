<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Auth;
use App\Qua;
use App\Users;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use DB;

class UserIndiviController extends Controller
{
	private $auth;
	private $user;
	private $qua;
	/*
	 * 构造方法
	 */
	public function __construct(){
		$this->auth=new Auth();
		$this->user=new Users();
		$this->qua=new Qua();
	}

	/*
	 * 商户认证的方法
	 */
    public function index(Request $request){
		//获取用户id
		$id=$request['guid'];
		//定义返回的message
		$message="";
		$param=json_decode($request['param'],true);
		//验证用户传过来的数据是否合法
        $validator = Validator::make($param,
            [
                'auth_name' => 'max:128',
                'qua_name' => 'required|max:128',
            ]
        );
		if ($validator->fails()){
			$messages = $validator->errors();
			if ($messages->has('auth_name')) {
				//如果验证失败,返回验证失败的信息
				return response()->json(['serverTime'=>time(),'ServerNo'=>1,'ResultData'=>['Message'=>'认证名称不能超过100个字']]);
			}else if($messages->has('qua_name')){
				return response()->json(['serverTime'=>time(),'ServerNo'=>1,'ResultData'=>['Message'=>'资质名称不能为空，且不能超过100个字']]);
			}
		}else{
			//先判断用户是否有待审核的认证
			$wait=$this->auth->Ids($id)->Status(1)->first();
			if($wait){
				return response()->json(['serverTime'=>time(),'ServerNo'=>1,'ResultData' => ['Message'=>'您有待审核的资质，暂时无法提交']]);
			}else{

				//先开启事务处理
				DB::beginTransaction();
				//通过一个for循环将用户上传的资质全部插入到数据库中
				for($i=0;$i<count($param['qua_name']);$i++){
    				//向认证表中插入数据
					$result=Auth::create(array(
						'users_id'  => $id,
						'auth_name' => $param['auth_name'],
					));
					Qua::create(array(
					    'users_id'=>$id,
					    'qua_name'  => $param['qua_name'][$i],
						'explanation'=>$param['explanation'][$i],
						'credentials'=>$param['credentials'][$i],
					));
				}
				//修改user表中用户的认证状态为1（认证待审核）
				DB::table('anchong_users')->where('users_id', $id)->update(['certification' => 1]);
				//提交事务
				DB::commit();
				//返回给客户端数据
				return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData' => ['Message'=>'认证提交成功，请等待审核！！']]);

			}
		}
	}
}
