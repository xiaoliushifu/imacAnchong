<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Users;
use App\Auth;
use App\Qua;
use App\Http\Controllers\Controller;
use DB;
use Gate;
use Validator;
use Hash;

/**
*   该控制器包含了用户信息模块的操作
*/
class userController extends Controller
{
	private $user;
	private $auth;
	public function __construct()
	{
		$this->user=new Users();
	}
    /**
     * Display a listing of the resource.
     *
	 * $request('phone'电话号码,'users_rank'用户等级,'uid'用户ID)
     * @return \Illuminate\Http\Response
     */
    public function getIndex(Request $req)
    {
		$keyPhone=$req["phone"];
		$kl=$req["users_rank"];
		$keyID=$req["uid"];

        if ($keyID) {
            $datas = Users::IDs($keyID)->orderBy("users_id","desc")->paginate(8);
		} elseif ($keyPhone) {
		    $datas = Users::Phone($keyPhone)->orderBy("users_id","desc")->paginate(8);
		} elseif ($kl) {
			$datas = Users::Level($kl)->orderBy("users_id","desc")->paginate(8);
		} else {
			$datas = $this->user->orderBy("users_id","desc")->paginate(8);
		}
		$args=array("users_rank"=>$kl);
		return view('admin/users/index',array("datacol"=>compact("args","datas")));
    }

    /**
     * 审核用户提交的认证
     *
     * @param  $request('$id'用户表ID)
     * @return \Illuminate\Http\Response
     */
    public function getCheck(Request $req)
    {
        $this->auth=new Auth();
        //权限判定
        if (Gate::denies('authentication')) {
            return back();
        }
        $id=$req['id'];
        $this->auth=new Auth();
        $users_id=$this->auth->find($id)->users_id;
        $phone=DB::table('anchong_users')->where('users_id',$users_id)->pluck('phone');
        //开启事务处理
        DB::beginTransaction();
        //关于“通过”的操作
        if ($req['confi']=="p") {
            //通过事务处理修改认证表和用户表中的认证状态
            DB::table('anchong_auth')->where('id', $id)->update(['auth_status' => 3]);
            DB::table('anchong_users')->where('users_id', $users_id)->update(['certification' => 3,'users_rank' => 2]);
            DB::table('anchong_users_login')->where('users_id', $users_id)->update(['user_rank' => 2]);
            $mes='您提交的会员认证已经审核通过，快去体验新功能吧';
            //排他就是"不通过"的操作
        } else {
            //认证失败时，记录立即清除
//             DB::table('anchong_auth')->where('id', $id)->update(['auth_status' => 2]);
            DB::table('anchong_auth')->where('id', $id)->delete();
            DB::table('anchong_qua')->where('auth_id', $id)->delete();
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
            //return "设置成功";
        }
        return "设置成功";
    }

    /**
     * 有关用户认证的列表
     * @param  $request('id'资质ID,'auth_status'认证状态)
     * @return \Illuminate\Http\Response
     */
    public function getList(Request $req)
    {
        $kId=$req["id"];
        $kS=$req["auth_status"];

        if ($kId) {
            $datas = Auth::Users($kId)->orderBy("id","desc")->paginate(8);
        } elseif ($kS) {
            $datas = Auth::Status($kS)->orderBy("id","desc")->paginate(8);
        } else {
            $datas=Auth::orderBy("id","desc")->paginate(8);
        }
        $args=array("auth_status"=>$kS);
        return view('admin/users/cert',array("datacol"=>compact("args","datas")));
    }

    /**
     * 查看提交的认证资料
     *
     * @param  int  $id认证ID
     * @return \Illuminate\Http\Response
     */
    public function getCertfile($id)
    {
        return Qua::Ids($id)->get();
    }

	/*
	*	显示用户注册的页面
	*/
	public function getRegister()
	{
		return view('admin/users/register');
	}

	/*
    *   注册
    */
    public function postRegister(Request $request)
    {
		//获得app端传过来的json格式的数据转换成数组格式
        $param=$request->all();
		//验证用户传过来的数据是否合法
		$validator = Validator::make($param,
			[
				'password' => 'required|min:6',
				'username' => 'required|min:8|unique:anchong_users_login,username',
			]
		);
		//如果出错返回出错信息，如果正确执行下面的操作
		if ($validator->fails())
		{
			$messages = $validator->errors();
			if ($messages->has('username')) {
				//如果验证失败,返回验证失败的信息
				return '账号不符合规范或该账号已注册';
			}else if($messages->has('password')){
				return '密码不能为空，并且密码不能小于6位';
			}
		}else{
			//像users表中插的数据
			$users_data=[
				'phone' => $param['username'],
				'ctime' => time(),
				'users_rank'=>2,
			];
			//开启事务处理
			DB::beginTransaction();
			//向users表中插数据
			$users=new \App\Users();
			$usersid=$users->add($users_data);
			//判断是否插入成功
			if(!empty($usersid)){
				//向users_login表中插的数据
				$users_login_data=[
					'users_id' => $usersid,
					'password' => Hash::make($param['password']),
					'username' => $param['username'],
					'token' => md5($param['username']),
					'netease_token' => '3c374b5bc7a7d5235cde6426487d8a3c',
					'user_rank'=>2
				];

				$users_login=new \App\Users_login();
				//创建ORM
				$JsonPost=new \App\JsonPost\JsonPost();
				//网易云信
				$url  = "https://api.netease.im/nimserver/user/create.action";
				//生成账号的数据
				$datas = 'accid='.$param['username'].'&token=3c374b5bc7a7d5235cde6426487d8a3c';
				list($return_code, $return_content) = $JsonPost->http_post_data($url, $datas);
				//判断是否请求成功
				if($return_code != 200){
					//假如失败就回滚
					DB::rollback();
					return '为了您的安全，请重新注册';
				}
				//假如插入成功
				if($users_login->add($users_login_data)){
					//假如成功就提交
					DB::commit();
					return '注册成功';
				}else{
					//假如失败就回滚
					DB::rollback();
					return '为了您的安全，请重新注册';
				}
			}else{
				//假如失败就回滚
				DB::rollback();
				return '为了您的安全，请重新注册';
			}
		}
    }
}
