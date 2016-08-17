<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Auth extends Model
{
    protected $table = 'anchong_auth';
	protected $guarded = ['id'];
    protected $fillable = ['users_id', 'auth_name', 'qua_name','explanation','credentials'];

	/*
	 * 通过users_id查找特定用户的认证记录
	 */
	public function scopeUsers($query,$id){
		return $query->where('users_id', '=', $id);
	}

	/*
	* 根据条件进行认证搜索
	* 这个方法将来会被删除，因为它和上面的方法重复了。
	*/
	public function scopeIds($query,$keyId)
    {
		return $query->where('users_id', '=', $keyId);
    }
	public function scopeStatus($query,$keyStatus)
	{
		return $query->where('auth_status', '=', $keyStatus);
	}

    /*
    *   认证数量统计
    */
    public function authcount($type)
    {
        return $this->whereRaw($type)->count();
    }
}
