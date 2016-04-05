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

//接口路由�?

Route::group(['domain' => 'api.anchong.net'], function () {
    //加上token验证的api
    Route::group(['middleware' => 'AppPrivate'], function () {

        /*
        *   用户模块
        */
        //短信验证码的接口
        Route::post('/user/smsauth','Api\User\UserController@smsauth');
        //用户注册的接�?
        Route::post('/user/register','Api\User\UserController@register');
        //用户登录的接�?
        Route::post('/user/login','Api\User\UserController@login');
        //获得用户资料
        Route::post('/user/getmessage','Api\User\UsermessagesController@show');
        //修改用户资料
        Route::post('/user/setmessage','Api\User\UsermessagesController@update');
        //设置头像
        Route::post('/user/sethead','Api\User\UsermessagesController@setUserHead');
       //��֤·��
        Route::post('/user/indivi','Api\User\UserIndiviController@index');
        //上传的sts认证
        Route::post('/user/sts','Api\User\UserController@sts');
        //上传回调
        Route::post('/user/callback','Api\User\UserController@callback');

        /*
        *   商机模块
        */
        //商机发布
        Route::post('/business/release','Api\Business\BusinessController@release');
        //发布类别和标�?
        Route::post('/business/typetag','Api\Business\BusinessController@typetag');
        //商机查看
        Route::post('/business/businessinfo','Api\Business\BusinessController@businessinfo');
        //个人发布商机查看
        Route::post('/business/mybusinessinfo','Api\Business\BusinessController@mybusinessinfo');

    });

});

//后台路由
Route::group(['domain' => 'admin.anchong.net'], function () {
     //首页路由
     Route::get('/','admin\indexController@index');
     //��户路由
    Route::resource('/users','admin\userController');
     //认证路由
	Route::resource('/cert','admin\certController');
     //订单管理路由
   	 Route::resource('/order','admin\orderController');
       //�����֤·��
	Route::get('/check','admin\CheckController@check');

     //视图下两层目录下的模版显�?
     Route::get('/{path}/{path1}/{path2}',function($path,$path1,$path2){
         return view("admin.$path.$path1.".substr($path2,0,-10));
     });
     //视图下一层目录下的模版显�?
     Route::get('/{path}/{path1}',function($path,$path1){
         return view("admin.$path.".substr($path1,0,-10));
     });
     //视图根目录下的模版显�?
     Route::get('/{path}',function($path){
         return view("admin.".substr($path,0,-10));
     });

});


//验证码类,需要传入数�?
Route::get('/captcha/{num}', 'CaptchaController@captcha');
