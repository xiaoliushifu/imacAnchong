<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
/*
*   该模型是操作用户表的，改模型里面提供了插入用户数据和删除修改数据的方法
*/
class Users extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'anchong_users';
    //定义主键名称
    protected $primaryKey = 'users_id';

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
     public function add($data)
     {
        //将用户信息添加入用户表
        $this->fill($data);
        if($this->save()){
            return $this->users_id;
        }else{
            return;
        }
    }

    /*
    *   查询用户数据
    */
    public function quer($field,$type)
    {
        return $this->select($field)->where($type)->get();
    }


    /*
	* 根据条件进行用户搜索
	*/
	public function scopePhone($query,$keyPhone)
    {
		return $query->where('phone', $keyPhone);
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
