<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class LoginHome
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(!Auth::check()){
            return redirect('/user/login');
        }


        return $next($request);
    }
}
