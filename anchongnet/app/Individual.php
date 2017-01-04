<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模型是操作用户认证表的模块
*/
class Individual extends Model
{
    protected $table = 'anchong_mcertification_individual';
    protected $fillable = ['name', 'idcard', 'cases'];

    /*
    *   
    */
	public function scopeUsersId($query,$id)
    {
        return $query->where('users_id', '=', $id);
    }
}
