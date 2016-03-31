<?php

namespace App\Http\Controllers\admin\users;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/*
*   用户相关的控制器
*/
class usersController extends Controller
{
       /*
       *    用户模块首页
       */
       public function index()
        {
          $users=new \App\Users();
          //需要查询的字段
          $users_columns=['users_id', 'phone', 'email', 'ctime', 'certification'];
          //将查询结果转化为数组
          $users_data=$users->admin_quer($users_columns)->toArray();
          //返回页面并将数据一起返回
          return view('admin.users.index')->with('user_data',$users_data);
        }
}
