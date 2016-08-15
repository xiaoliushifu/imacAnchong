<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Qua extends Model
{
    protected $table = 'anchong_qua';
	protected $fillable = ['auth_id','qua_name','explanation','credentials'];
	/*
	* 根据条件进行认证搜索
	*/
	public function scopeIds($query,$keyId)
    {
		return $query->where('auth_id', '=', $keyId);
    }
}
