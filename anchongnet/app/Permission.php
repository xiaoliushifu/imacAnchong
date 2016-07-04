<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected  $table = 'anchong_permissions';
    //多对多关联
    public function roles()
    {
        //多对多关联时，第二个参数是枢纽表的名字，默认是按照字母顺序，即表名是permission_roles,
        //如果需要修改枢纽表时，才填写第二个参数
        //因为数据库配置文件里，没有prefix的缘故，避免表名错误，手动添加了第二个参数，枢纽表
       return $this->belongsToMany('App\Role','anchong_permission_role');
        //第三，四个参数是定义关联的字段，也有默认的
        //return $this->belongsToMany('App\Role', 'permission_roles', 'permission_id', 'role_id');    
    }
}
