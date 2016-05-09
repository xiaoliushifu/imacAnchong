<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use App\Http\Controllers\Controller;

class CheckController extends Controller
{
    /*
	 * 审核用户认证 
	 */
	public function check(Request $request){
		$id=$request['id'];
		if($request['certified']=="yes"){
			DB::table('anchong_auth')->where('id', $id)->update(['auth_status' => 3]);
		}else{
			DB::table('anchong_auth')->where('id', $id)->update(['auth_status' => 2]);
		};
		return "设置成功";
	} 
}
