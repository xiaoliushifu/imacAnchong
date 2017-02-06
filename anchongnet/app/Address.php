<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'anchong_users_address';
    protected $fillable = ['users_id', 'region', 'add_name','phone','address','isdefault'];
    public $timestamps = false;

    /*
	* 根据条件进行收货地址搜索
	*/
    public function scopeUser($query,$keyUser)
    {
        return $query->where('users_id', '=', $keyUser);
    }
    /*
     * 获取用户默认收货地址
     * */
    public function scopeUserDefault($query,$keyUser){
        return $query->where(['users_id'=>$keyUser,'isdefault'=>1])->first();
    }
}
