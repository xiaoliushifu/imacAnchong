<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use DB;
use App\Auth;
use Gate;
use App\Http\Controllers\Controller;

class CheckController extends Controller
{
	private $auth;
    /*
	 * 审核用户认证
	 */
	public function check(Request $request)
	{
	    //权限判定
	    if (Gate::denies('authentication')) {
	        return back();
	    }
		$id=$request['id'];
		$this->auth=new Auth();
		$users_id=$this->auth->find($id)->users_id;
		$phone=DB::table('anchong_users')->where('users_id',$users_id)->pluck('phone');
		//开启事务处理
		DB::beginTransaction();
		//关于“通过"的操作
		if ($request['certified']=="yes") {
			//通过事务处理修改认证表和用户表中的认证状态
			DB::table('anchong_auth')->where('id', $id)->update(['auth_status' => 3]);
			DB::table('anchong_users')->where('users_id', $users_id)->update(['certification' => 3,'users_rank' => 2]);
			DB::table('anchong_users_login')->where('users_id', $users_id)->update(['user_rank' => 2]);
			$mes='您提交的会员认证已经审核通过，快去体验新功能吧';
		//排他就是"不通过"的操作
		} else {
			//通过事务处理修改认证表和用户表中的认证状态
			DB::table('anchong_auth')->where('id', $id)->update(['auth_status' => 2]);
			DB::table('anchong_users')->where('users_id', $users_id)->update(['certification' => 2]);
			$mes='您提交的会员认证未通过审核，请重新提交';
		}
		//事务提交
		DB::commit();
		//创建推送的ORM
		$propel=new \App\Http\Controllers\admin\Propel\PropelmesgController();
		//进行推送
		try{
			//推送消息
			$propel->apppropel($phone[0],'会员认证进度',$mes);
		}catch (\Exception $e) {
			return "设置成功";
		}
		return "设置成功";
	}
}
