<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Gate;

/**
*   该控制器包含了商铺审核模块的操作
*/
class checkShopController extends Controller
{
    /**
     * 商铺审核方法
     *
     * @param  $request('sid'商铺ID)
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //是否有 “审核商铺"   权限
        if (Gate::denies('shop-check')) {
            return 'unauthorized';
        }
        $sid=$request['sid'];
        //查出用户的手机号
        $users_id=DB::table('anchong_shops')->where('sid',$sid)->pluck('users_id');
        $phone=DB::table('anchong_users')->where('users_id',$users_id[0])->pluck('phone');
        if ($request['certified']=="yes") {
            DB::table('anchong_shops')->where('sid', $sid)->update(['audit' => 2]);
            DB::table('anchong_users')->where('users_id', $request['users_id'])->update(['sid' => $sid]);
            $mes='您提交的商铺申请已经审核通过，快去体验新功能吧';
        } else {
            DB::table('anchong_shops')->where('sid', $sid)->delete();
            $mes='您提交的商铺申请未通过审核，请重新提交';
        };
        //创建推送的ORM
		$propel=new \App\Http\Controllers\admin\Propel\PropelmesgController();
		//进行推送
		try{
			//推送消息
			$propel->apppropel($phone[0],'商铺申请进度',$mes);
		}catch (\Exception $e) {
			return "设置成功";
		}
        return "设置成功";
    }
}
