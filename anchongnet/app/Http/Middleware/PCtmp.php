<?php

namespace App\Http\Middleware;

use Closure;
class PCtmp
{
    /**
     * 暂停PC访问的临时中间件
     * @param unknown $request
     * @param Closure $next
     */
    public function handle($request, Closure $next)
    {
        $uri = $request->getRequestUri();
        //暂时开启的路由
        $except = ['information','getparam','getpackage'];
        foreach ($except as $route) {
            if (false  !== strpos($uri,$route))  {
                return $next($request);
            }
        }
        //前台不上线，只留首页可访
        if ($uri != '/') {
           return redirect('/');
        }
        //Only '/'
        return $next($request);
    }
    
}
