<?php

namespace App\Http\Middleware;

use Closure;

class Anchong
{
    /**
     * 该中间件绑定了安虫自营路由组
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //只许安虫自营通过，否则回退
        if ($request->user()['user_rank'] != 3) {
            return back();
        }
        return $next($request);
    }
}
