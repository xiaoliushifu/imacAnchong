<?php

namespace App\Http\Controllers\Home\User;

use Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/*
*   该控制器是web端用户注册的页面
*/
class LoginController extends Controller
{
    //定义变量
    private $users_login;
    /*
    *   执行构造方法将orm模型初始化
    */
    public function __construct()
    {
        $this->users_login=new \App\Users_login();
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
