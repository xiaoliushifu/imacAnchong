<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Individual extends Model
{
    protected $table = 'anchong_mcertification_individual';
    protected $fillable = ['name', 'idcard', 'cases'];
	public function scopeUsersId($query,$id)
    {
        return $query->where('users_id', '=', $id);
    }
}
