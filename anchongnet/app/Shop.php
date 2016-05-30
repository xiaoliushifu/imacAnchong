<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $table = 'anchong_shops';
    protected $fillable = ['users_id', 'name', 'mainbrand','authorization','category','introduction','premises','img','audit','banner'];
    //不允许被赋值
    protected $guarded = ['sid'];
    //定义主键名称
    protected $primaryKey = 'sid';
    public  $timestamps=false;

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
<<<<<<< HEAD

    public function scopeUser($query,$keyUser){
        return $query->where('users_id','=',$keyUser);
    }
    
=======
    public function scopeUser($query,$keyUser){
        return $query->where('users_id','=',$keyUser);
    }

>>>>>>> origin/renqingbin
    /*
    *   查询商铺信息
    */
    public function quer($field,$type)
    {
        return $this->select($field)->whereRaw($type)->get();
    }

    /*
    *   商铺更新信息
    */
    public function shopsupdate($id,$data)
    {
        $cartnum=$this->find($id);
        if($cartnum->update($data)){
            return true;
        }else{
            return false;
        }
    }
}
