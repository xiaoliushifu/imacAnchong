<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session,Redirect,Request,Hash,Auth;

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
                if($rank[0]['users_rank'] == 3){
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
}
