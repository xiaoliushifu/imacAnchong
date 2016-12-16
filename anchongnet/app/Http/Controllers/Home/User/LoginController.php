<?php

namespace App\Http\Controllers\Home\User;

use Request;

use App\Http\Controllers\Controller;
use Validator;
use Auth;
use Session;
use Redirect;
use Cache;

/*
*   该控制器是web端用户注册的页面
*/
class LoginController extends Controller
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
        return view('home.users.login');
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
     * 用户登录
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=$request::all();
        //提取username和password
        $username=$data['username'];
        $password=$data['password'];
        //使用laravel集成的验证方法来验证
        $validator = Validator::make($data,
            [
                'username' => 'unique:anchong_users_login,username',
            ]
        );
        //如果不出错返回未注册，如果出错执行下面的操作
        if (!$validator->fails()) {
            return Redirect::back()->withInput()->with('errormessage','账号未注册!');
        } else {
            //验证码
            if ($data['captchapic'] == Session::get($data['captchanum'].'adminmilkcaptcha')) {
                //用户名和密码
                if ( $user = Auth::attempt(['username' => $username, 'password' => $password])) {
                   session(['user'=>$username]);
                    return Redirect::to('/');
                } else {
                    return Redirect::back()->withInput()->with('errormessage','账号密码错误');
                }
            } else {
                return Redirect::back()->with('errormessage','请填写正确的验证码');
            }
        }
    }

    /**
     * 在分享页点击"登录"时的跳转
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('home.users.sharelogin',compact('id'));
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

    /**
    *   登出
    *
    * @param  无
    * @return \Illuminate\Http\Response
    */
    public function logout()
    {
        //清除登录状态
        Auth::logout();
        return Redirect::back();
    }

    /*
    *   分享登录
    */
    public function sharelogin(Request $request)
    {
        $data=$request::all();
        //提取username和password
        $username=$data['username'];
        $password=$data['password'];
        $shareId=$data['shareId'];
        //使用laravel集成的验证方法来验证
        $validator = Validator::make($data,
            [
                'username' => 'unique:anchong_users_login,username',
            ]
        );
        //如果不出错返回未注册，如果出错执行下面的操作
        if (!$validator->fails()) {
            return Redirect::back()->withInput()->with('errormessage','账号未注册!');
        } else {
            if ($data['captchapic'] == Session::get($data['captchanum'].'adminmilkcaptcha')) {
                if (Auth::attempt(['username' => $username, 'password' => $password])) {
                    session(['user'=>$username]);
                    return Redirect::to("/cartshare/$shareId");
                } else {
                    return Redirect::back()->withInput()->with('errormessage','账号密码错误');
                }
            } else {
                return Redirect::back()->withInput()->with('errormessage','请填写正确的验证码');
            }
        }
    }

    public function quit()
    {
        session(['user'=>null]);
        Cache::forget('all');
        Cache::forget('user');
        Auth::logout();
        return redirect('/');
    }
}
