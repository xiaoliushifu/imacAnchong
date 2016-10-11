<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模型是操作用户信息表的模块
*/
class Usermessages extends Model
{
    protected $table = 'anchong_usermessages';
    protected $guard='users_id';
    protected $fillable = ['contact', 'account', 'qq','email','nickname','headpic'];

    public function scopeMessage($query,$id)
    {
        return $query->where('users_id', '=', $id);
    }

    /*
    *   查询联系人姓名
    */
    public function quer($field,$type)
    {
        return $this->select($field)->where($type)->get();
    }

    /*
    *   判断是否有数据
    */
    public function countquer($type)
    {
        return $this->whereRaw($type)->count();
    }
}
