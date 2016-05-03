<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $table = 'anchong_shops';
    protected $fillable = ['users_id', 'name', 'mainbrand','authorization','category','introduction','premises','img','audit'];

    /*
	* 根据条件进行商铺搜索
	*/
    public function scopeName($query,$keyName)
    {
        return $query->where('name', 'like', "%{$keyName}%");
    }
    public function scopeAudit($query,$keyAudit)
    {
        return $query->where('audit', '=', $keyAudit);
    }
    public function scopeSid($query,$keySid)
    {
        return $query->where('sid', '=', $keySid);
    }
    public function scopeUid($query,$keyUid){
        return $query->where('users_id','=',$keyUid)->first();
    }
    
    /*
    *   查询商铺信息
    */
    public function quer($field,$type)
    {
        return $this->select($field)->whereRaw($type)->get();
    }
}
