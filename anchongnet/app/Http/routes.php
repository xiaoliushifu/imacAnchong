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

//接口路由组
Route::group(['domain' => 'api.anchong.net'], function () {
    //加上token验证的api
    Route::group(['middleware' => 'AppPrivate'], function () {
        Route::post('/index',function(){
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>'1']);
        });
        Route::post('/user/smsauth','Api\User\UserController@smsauth');
        Route::post('/user/register','Api\User\UserController@register');
    });

});
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


//验证码类,需要传入数字
Route::get('/captcha/{num}', 'CaptchaController@captcha');
//手机验证类，第一个参数需要用户行为，第二个参数需要电话号码
Route::get('/smsauth/{action}/{phone}', 'CaptchaController@smsAuth');
