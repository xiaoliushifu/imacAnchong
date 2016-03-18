<?php

namespace App\Http\Middleware;

use Illuminate\Contracts\Routing\Middleware;
use Closure;
use Auth;
use URL;
use Request;


//这个是验证的中间件，验证是否用户登录
class AppPublic implements Middleware {
    public function handle($request, Closure $next)
    {
        //$encode=new \App\Encode();
        $signature=md5(trim($request->path()).trim($request['time']).trim($request['guid']).trim($request['param']).'itxdh2016');
        //$signature=md5($request->path().$request['time'].$request['guid'].$request['param'].'itxdh2016');
        if($request['signature'] == $signature){
            return $next($request);
        }
        return response()->json(['serverTime'=>time(),'ServerNo'=>'签名错误','ResultData'=>""]);
    }
}
