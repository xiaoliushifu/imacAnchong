<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

//后台路由
Route::group(['domain' => 'admin.anchong.net'], function () {
     //首页路由
     Route::get('/','admin\indexController@index');
     //用户路由
     Route::get('/users','admin\users\usersController@index');
     //用户管理
     Route::get('/users/man','admin\users\userManController@index');
   	//订单管理路由
   	Route::resource('/order','admin\orderController');

     //视图下两层目录下的模版显示
     Route::get('/{path}/{path1}/{path2}',function($path,$path1,$path2){
         return view("admin.$path.$path1.".substr($path2,0,-10));
     });
     //视图下一层目录下的模版显示
     Route::get('/{path}/{path1}',function($path,$path1){
         return view("admin.$path.".substr($path1,0,-10));
     });
     //视图根目录下的模版显示
     Route::get('/{path}',function($path){
         return view("admin.".substr($path,0,-10));
     });

});

//验证码类
Route::get('/captcha/{num}', 'CaptchaController@captcha');
//手机验证类
Route::get('/smsauth', 'CaptchaController@smsAuth');
