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

/*
*   该控制器包含了用户认证模块的操作
*/
class UserIndiviController extends Controller
{
	private $auth;
	private $user;
	private $qua;
	private $propel;

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
    public function index(Request $request)
    {
        try{
        		//获取用户id
        		$id=$request['guid'];
        		/*首先检查是否有和当前用户有关的待审核或已审核通过的认证*/
        		$wait=$this->auth->Ids($id)->first();
        		if ($wait) {
        		    return response()->json(['serverTime'=>time(),'ServerNo'=>1,'ResultData' => ['Message'=>'您有待审核的资质，暂时无法提交']]);
        		}
        		//定义返回的message
        		$message="";
        		$param=json_decode($request['param'],true);
        		//验证用户传过来的数据是否合法
            $validator = Validator::make($param,
                [
                 'auth_name' => 'required|max:128',
                 'qua_name' => 'required|max:128',
    				'explanation' => 'required|max:500'
                ]
            );
        		if ($validator->fails()) {
        			$messages = $validator->errors();
        			if ($messages->has('auth_name')) {
        				//如果验证失败,返回验证失败的信息
        				return response()->json(['serverTime'=>time(),'ServerNo'=>1,'ResultData'=>['Message'=>'会员名称不能超过100个字']]);
        			} elseif ($messages->has('qua_name')){
        				return response()->json(['serverTime'=>time(),'ServerNo'=>1,'ResultData'=>['Message'=>'证件名称不能为空，且不能超过100个字']]);
        			} elseif ($messages->has('explanation')){
        				return response()->json(['serverTime'=>time(),'ServerNo'=>1,'ResultData'=>['Message'=>'会员简介不能为空，且不能超过200个字']]);
        			}
        		} else {
        				//先开启事务处理
        				DB::beginTransaction();
            				//向认证表auth中插入数据,使用批量赋值方法
        				$result=Auth::create(array(
        					'users_id'  => $id,
        					'auth_name' => $param['auth_name'],
        					'qua_name'  => $param['qua_name'],
        					'explanation'=>$param['explanation'],
        				));
        				if ($result->id) {
        					//通过一个for循环将该资质相关的证件照片全部插入到数据表qua中
        					for($i=0;$i<count($param['credentials']);$i++){
        						Qua::create(array(
        							'auth_id'=>$result->id,
        							'credentials'=>$param['credentials'][$i],
        						));
        					}
        				}
        				//修改user表中用户的认证状态为1（认证待审核）
        				DB::table('anchong_users')->where('users_id', $id)->update(['certification' => 1]);
        				//提交事务
        				DB::commit();
						$this->propel=new \App\Http\Controllers\admin\Propel\PropelmesgController();
						//进行推送
						try{
	                        //推送消息
	                        $this->propel->apppropel('13013221114','认证审核','有人提交认证了，快去审核吧');
	                    }catch (\Exception $e) {
							//返回给客户端数据
	        				return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData' => ['Message'=>'认证提交成功，请等待审核！！']]);
						}
        				//返回给客户端数据
        				return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData' => ['Message'=>'认证提交成功，请等待审核！！']]);
        		}
        }catch (\Exception $e) {
           return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

	/*
	 * 商户认证的修改
	 */
    public function change(Request $request)
    {
		$param=json_decode($request['param'],true);
		$validator = Validator::make($param,
			[
			 'auth_name' => 'required|max:128',
			 'qua_name' => 'required|max:128',
				'explanation' => 'required|max:500'
			]
		);
		if ($validator->fails()) {
			$messages = $validator->errors();
			if ($messages->has('auth_name')) {
				//如果验证失败,返回验证失败的信息
				return response()->json(['serverTime'=>time(),'ServerNo'=>1,'ResultData'=>['Message'=>'会员名称不能超过100个字']]);
			} elseif ($messages->has('qua_name')){
				return response()->json(['serverTime'=>time(),'ServerNo'=>1,'ResultData'=>['Message'=>'证件名称不能为空，且不能超过100个字']]);
			} elseif ($messages->has('explanation')){
				return response()->json(['serverTime'=>time(),'ServerNo'=>1,'ResultData'=>['Message'=>'会员简介不能为空，且不能超过200个字']]);
			}
		} else {
			//先开启事务处理
			DB::beginTransaction();
				//向认证表auth中插入数据,使用批量赋值方法
			$result=Auth::where('users_id',$request['guid'])->update(array(
				'auth_name' => $param['auth_name'],
				'qua_name'  => $param['qua_name'],
				'explanation'=>$param['explanation'],
			));
			if ($result) {
				//通过一个for循环将该资质相关的证件照片全部插入到数据表qua中
				for($i=0;$i<count($param['credentials']);$i++){
					Qua::create(array(
						'auth_id'=>$result,
						'credentials'=>$param['credentials'][$i],
					));
				}
			}
		}
	}
}
