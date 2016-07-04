<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session,Redirect,Request,Hash,Auth;
use DB;

class indexController extends Controller
{

     /*
     *  后台首页
     */
    public function index()
    {
        return view('admin.index',['username' => Auth::user()['username']]);
    }

    /*
    *  后台首页
    */
   public function zhuce()
   {
       return view('welcome');
   }

    /*
    *   验证登陆
    */
    public function checklogin(Request $request)
    {
        $data=$request::all();
        //判断验证码是否正确
        if($data['captchapic'] == Session::get('adminmilkcaptcha')){
            //判断用户名密码是否正确
            if (Auth::attempt(['username' => $data['username'], 'password' => $data['password']])){
                $users=new \App\Users();
                $rank=$users->quer('users_rank',['users_id'=>Auth::user()['users_id']])->toArray();
                //判断会员的权限是否是管理员
                if($rank[0]['users_rank'] == 3 || $rank[0]['users_rank']==2){
                    return Redirect::intended('/');
                }else{
                    //假如会员权限不够就清除登录状态并退出
                    Auth::logout();
                    return Redirect::back();
                }
            }else{
                return Redirect::back()->withInput()->with('loginmes','账号或密码错误!');
            }
        }else{
            return Redirect::back()->withInput()->with('admincaptcha','请填写正确的验证码!');
        }
    }

    /*
    *   登出
    */
    public function logout()
    {
        //清除登录状态
        Auth::logout();
        return Redirect::intended('/');
    }

    /*
    *   注册
    */
    public function userregister(Request $request)
    {
        //开启事务处理
        DB::beginTransaction();
        $data=$request::all();
        //清除登录状态
        $users_login=new \App\Users_login();
        $users=new \App\Users();
        $users_data=[
            'phone' => $data['username'],
            'ctime' => time(),
        ];
        $usersid=$users->add($users_data);
        $users_login_data=[
            'users_id' => $usersid,
            'password' => Hash::make($data['password']),
            'username' => $data['username'],
            'token' => md5($data['username']),
            'user_rank' => 2,
        ];
        $result=$users_login->add($users_login_data);
        if($result){
            //假如成功就提交
            DB::commit();
            return '注册成功';
        }else{
            //假如失败就回滚
            DB::rollback();
            return '注册失败';
        }
    }
}
