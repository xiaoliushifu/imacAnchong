<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use URL;
use Request;

/*
*   该类是手机Api的签名验证中间件，会验证每一个请求的合法性
*/
class AppPrivate
{
    /**
     *  该方法是验证每一个请求的合法性
     */
     public function handle($request, Closure $next)
     {
         if($request['guid'] == 0){
                 //公开的中间件
             $signature=md5(trim($request->path()).trim($request['time']).trim($request['guid']).trim($request['param']).'anchongnet');
                 if($request['signature'] == $signature){
                     return $next($request);
                 }
                 return response()->json(['serverTime'=>time(),'ServerNo'=>5,'ResultData'=>['Message'=>'登陆超时，请重新登陆']]);
         }else{
             //登陆后的中间件
             $encode=new \App\Encode\Encode();
             $user=new \App\Users_login();
             $token=$user->querToken($request['guid']);
             $encodetoken=$encode->encodeToken($token[0]['token']);
             $signature=md5(trim($request->path()).trim($request['time']).trim($request['guid']).trim($request['param']).trim($encodetoken));
             if($request['signature'] == $signature){
                 return $next($request);
             }
             return response()->json(['serverTime'=>time(),'ServerNo'=>5,'ResultData'=>['Message'=>'登陆超时，请重新登陆']]);
         }
     }
}
