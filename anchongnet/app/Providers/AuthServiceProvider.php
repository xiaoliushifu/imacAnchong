<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Permission;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

       //绑定 “权限验证回调”
// 		$permissions = Permission::with('roles')->get();
//         foreach ($permissions as $permission) {
//             $gate->define($permission->name, function($user) use ($permission) {
//                 return $user->hasPermission($permission);
//             });
//         }
        
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
    }
}
