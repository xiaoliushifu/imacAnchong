<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模型是操作会员认证数据表的模块
*/
class Qua extends Model
{
    protected $table = 'anchong_qua';
	protected $fillable = ['auth_id','qua_name','explanation','credentials'];
	//关闭自动更新时间戳
	public   $timestamps=false;
	/*
	* 根据条件进行认证搜索
	*/
	public function scopeIds($query,$keyId)
    {
		return $query->where('auth_id', '=', $keyId);
    }
}
