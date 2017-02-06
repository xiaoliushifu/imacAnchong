<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模型是操作权限表的模块
*/
class Role extends Model
{
    protected  $table ='anchong_roles';
    //多对多关联
    public function permissions()
    {
        //第一个参数是关联模型的类名称
     //Eloquent 假设对应的关联模型数据库表里，外键名称是基于模型名称。
        //在这个例子里，默认 Permission 模型数据库表会以 role_id 作为外键
        return $this->belongsToMany('App\Permission');
    }

    //用于给当前角色分配权限时使用
    public function givePermissionTo($permission)
    {
        return $this->permissions()->save($permission);
    }
}
