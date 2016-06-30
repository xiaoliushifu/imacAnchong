<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use URL;
use Request;

/*
*   该类是保证支付宝安全的中间件
*/
class PayAuthen
{
    /*
     *  该方法是验证每一个请求的合法性
     */
     public function handle($request, Closure $next)
     {
         $id=Request::all();
         if($id['seller_id'] !== '2088911913159962'){
             return view('error.503');
         }
         return $next($request);
     }
}
