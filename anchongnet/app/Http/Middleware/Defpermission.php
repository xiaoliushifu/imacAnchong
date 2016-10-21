<?php

namespace App\Http\Middleware;

use Closure;
//引入权限认证门
use Illuminate\Auth\Access\Gate;
use App\Permission;
use App\Users;
class Defpermission
{
    /**
     * 该中间件处理后端权限
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //绑定 “权限验证回调”
        $gate = app(\Illuminate\Contracts\Auth\Access\Gate::class);
        
        $permissions = \Cache::remember('pcall','360',function(){
            return  Permission::with('roles')->get();
        });
        //行为权限定义
        foreach ($permissions as $permission) {
            $gate->define($permission->name, function($user) use ($permission) {
                return $user->hasPermission($permission);
            });
        }
        //资源权限定义
        $gate->define('res', function($user, $resource) {
            $u = Users::where('users_id', $user->users_id)->first();
            //dd($u,$user,$u->sid,$resource);
            return $u->sid == $resource->sid;
        });
        
        /**
         *定义before方法
         *不再写vendor中，以免后续麻烦
         *调用时参数：
         *@1  user  Object  当前用户
         *@2  ability String 当时验证的权限名*/
        $gate->before(function($user,$ability){
            //第三方，不属于权限验证范围
            //如果安虫和第三方有区别的操作，比如广告，是通过路由中间件实现
            $ur = $user->getAttribute('user_rank');
            $uid = $user->getAttribute('users_id');
            //只有第三方和admin不受权限控制
            if ($ur==3 && $uid != 1) {
                return null;
            }
            return true;
        });
        
        return $next($request);
    }
}
