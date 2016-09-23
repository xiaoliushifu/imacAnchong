<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;
use Closure;
class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
    ];
    
    public function handle($request, Closure $next)
    {
//         $uri = $request->getRequestUri();
//         //暂时开启的路由
//         $except = ['information','getparam','getpackage'];
//         foreach ($except as $route) {
//             if (strpos($uri,$route))  {
//                 return $next($request);
//             } 
//         }
//         //前台不上线，只留首页可访
//         if ($request->getRequestUri() != '/') {
//             return redirect('/');
//         }
        // 使用CSRF
        return parent::handle($request, $next);
        // 禁用CSRF
        //return $next($request);
    }
    
}
