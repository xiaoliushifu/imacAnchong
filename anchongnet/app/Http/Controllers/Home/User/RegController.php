<?php

namespace App\Http\Controllers\Home\User;

use Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Redis;
use Validator;
use Hash;
use Auth;
use DB;
use Redirect;

/*
*   该控制器是web端用户注册的页面
*/
class RegController extends Controller
{

    /*
    *   执行构造方法将orm模型初始化
    */
    public function __construct()
    {

    }

    /**
     * 显示页面
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home.users.register');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * 用户注册
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //获得传过来的数据
        $data=$request::all();
        //验证用户传过来的数据是否合法
        $validator = Validator::make($data,
        [
            'password' => 'required|min:6',
            'phone' => 'required|min:11|unique:anchong_users_login,username',
            'phonecode' => 'required',
        ]
        );
        //如果出错返回出错信息，如果正确执行下面的操作
        if ($validator->fails())
        {
            $messages = $validator->errors();
            if ($messages->has('phone')) {
				//如果验证失败,返回验证失败的信息
			    return Redirect::back()->withInput()->with('errormessage','账号已注册!');
			}else if($messages->has('password')){
				return Redirect::back()->withInput()->with('errormessage','密码不能为空，并且密码不能小于6位!');
			}else if($messages->has('phonecode')){
				return Redirect::back()->withInput()->with('errormessage','验证码不能为空!');
			}
        }else{
            //从Redis里面取出验证码
            $redis = Redis::connection();
            if($redis->get($data['phone'].'注册验证') == $data['phonecode']){
                $redis->del($data['phone'].'注册验证');
                //像users表中插的数据
                $users_data=[
                    'phone' => $data['phone'],
                    'ctime' => time(),
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
                        'password' => Hash::make($data['password']),
                        'username' => $data['phone'],
                        'token' => md5($data['phone']),
                        'user_rank'=>1
                    ];
                    $users_login=new \App\Users_login();
                    //假如插入成功
                    if($users_login->add($users_login_data)){
                        //假如成功就提交
                        DB::commit();
                        return Redirect::to('/');
                    }else{
                        //假如失败就回滚
                        DB::rollback();
                        return Redirect::back()->withInput()->with('errormessage','为了您的安全，请重新注册');
                    }
                }else{
                    //假如失败就回滚
                    DB::rollback();
                    return Redirect::back()->withInput()->with('errormessage','为了您的安全，请重新注册');
                }
            }else{
                return Redirect::back()->withInput()->with('errormessage','手机验证码错误!');
            }
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /*
    *   该方法是用户注册时的手机验证的接口
    */
    public function smsauth(Request $request)
    {
        //获得传过来的数据
        $data=$request::all();
        //判断用户行为
        switch ($data['action']) {
            case 1:
                $action="注册验证";
                break;
            case 2:
                $action="变更验证";
                break;
            case 3:
                $action="登录验证";
                break;
            case 4:
                $action="身份验证";
                break;
            default:
                return '短信行为异常';
                break;
        }
        //new一个短信的对象
        $smsauth=new \App\SMS\smsAuth();
        $result=$smsauth->smsAuth($action,$data['phone']);
        //判断短信是否发送成功并且插入Redis
        if($result[0]){
            return $result[1];
        }else{
            return $result[1];
        }
    }
}
