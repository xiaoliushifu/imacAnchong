<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use App\Auth;
use App\Http\Controllers\Controller;

class CheckController extends Controller
{
	private $auth;
	//构造方法
	public function __construct(){
		$this->auth=new Auth();
	}
    /*
	 * 审核用户认证 
	 */
	public function check(Request $request){
		$id=$request['id'];
		$users_id=$this->auth->find($id)->users_id;
		if($request['certified']=="yes"){
			//通过事务处理修改认证表和用户表中的认证状态
			DB::beginTransaction();
			DB::table('anchong_auth')->where('id', $id)->update(['auth_status' => 3]);
			DB::table('anchong_users')->where('users_id', $users_id)->update(['certification' => 3]);
			DB::commit();
		}else{
			//通过事务处理修改认证表和用户表中的认证状态
			DB::beginTransaction();
			DB::table('anchong_auth')->where('id', $id)->update(['auth_status' => 2]);
			DB::table('anchong_users')->where('users_id', $users_id)->update(['certification' => 2]);
			DB::commit();
		};
		return "设置成功";
	} 
}
