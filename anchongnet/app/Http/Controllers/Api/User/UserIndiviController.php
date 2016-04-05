<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Auth;
use App\Users;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use DB;

class UserIndiviController extends Controller
{
	private $auth;
	private $user;
	/*
	 * 构造方法
	 */
	public function __construct(){
		$this->auth=new Auth();
		$this->user=new Users();
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
                'auth_name' => 'max:8',
                'qua_name' => 'required|max:11',
            ]
        );
		if ($validator->fails()){
			//$messages = $validator->errors();
			//如果验证失败,返回验证失败的信息
			//1return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData' => ['Message'=>$messages->first('auth_name')]]);
		}else{
			//通过一个for循环将用户上传的资质全部插入到数据库中
			for($i=0;$i<count($param['qua_name']);$i++){	
				//向认证表中插入数据	
				$result=Auth::create(array(
					'users_id'  => $id,
					'auth_name' => $param['auth_name'],
					'qua_name'  => $param['qua_name'][$i],
					'explanation'=>$param['explanation'][$i],
					'credentials'=>$param['credentials'][$i],
				));
				
				
				if($result){
					//修改user表中用户的认证状态为1（认证待审核）
					DB::table('anchong_users')->where('users_id', $id)->update(['certification' => 1]);
					$message.=$param['qua_name'][$i]." success!!";
				}else{
					$message.=$param['qua_name'][$i]." failed!!";
				};
			}
			//返回给客户端数据
			return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData' => ['Message'=>$message]]);
		}
		
	}
}
