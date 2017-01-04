<?php

namespace App\Http\Controllers\Home\User;

use Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Hash;
use Auth;
use DB;
use Redirect;
use Redis;

/*
*   该控制器是web端用户手机验证的页面
*/
class ForgetpwdController extends Controller
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
        return view('home.users.forgetpwd');
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
     * 修改密码
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $validator = Validator::make($data,
            [
                'password' => 'required|min:6|confirmed',
                'password_confirmation' => 'required',
            ]
        );
        if ($validator->fails())
        {
			return Redirect::back()->withInput()->with('errormessage','两次输入密码需要一致，且密码不能小于6位');
        }else{
            //redis的验证码
            $redis = Redis::connection();
            if($redis->get($data['phone'].'变更验证') == $data['phonecode']){
                $redis->del($data['phone'].'变更验证');
                $password_data=[
                    'password' => Hash::make($data['password'])
                ];
                $users_login=new \App\Users_login();
                $result=$users_login->updatepassword($data['phone'],$password_data);
                if($result){
                    return Redirect::to('/user/login');
                }else{
                    return Redirect::back()->withInput()->with('errormessage','修改密码失败');
                }
            }else{
                return Redirect::back()->withInput()->with('errormessage','手机验证码错误');
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
}
