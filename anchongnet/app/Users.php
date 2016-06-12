<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模型是操作用户表的，改模型里面提供了插入用户数据和删除修改数据的方��?
*/
class Users extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'anchong_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['user_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
     public  $timestamps=false;

     /*
     *   添加用户信息
     */
     public function add($user_data)
     {
        //将用户信息添加入用户表
        $this->fill($user_data);
        if($this->save()){
            return $this->id;
        }else{
            return;
        }
    }

    /*
    *   查询用户等级
    */
    public function quer($field,$quer_data)
    {
        return $this->select($field)->where($quer_data)->get();
    }


    /*
	* 根据条件进行用户搜索
	*/
	public function scopePhone($query,$keyPhone)
    {
		return $query->where('phone', 'like', "%{$keyPhone}%");
    }
	public function scopeLevel($query,$keyLevel)
	{
		return $query->where('users_rank', '=', $keyLevel);
	}
	/*
	 * 根据用户id获取用户
	*/
	public function scopeIds($query,$id){
		return $query->where('users_id','=',$id);
	}
}
