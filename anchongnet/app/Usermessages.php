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
}
