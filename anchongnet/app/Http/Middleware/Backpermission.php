<?php

namespace App\Http\Middleware;

use Closure;

class Backpermission
{
    /**
     * 该中间件绑定了Permission控制器
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //只许admin通过，否则回退
        if($request->user()['users_id'] != 1)
            return back();
        return $next($request);
    }
}
