<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usermessages extends Model
{
    protected $table = 'anchong_usermessages';
    protected $guard='users_id';
    protected $fillable = ['contact', 'account', 'qq','email','nickname','headpic'];
     //ͨ��id��ȡָ����¼
    public function scopeMessage($query,$id)
    {
        return $query->where('users_id', '=', $id);
    }

    /*
    *   查询联系人姓名
    */
    public function quer($field,$quer_data)
    {
        return $this->select($field)->where($quer_data)->get();
    }

    /*
    *   判断是否有数据
    */
    public function countquer($type)
    {
        return $this->whereRaw($type)->count();
    }
}
