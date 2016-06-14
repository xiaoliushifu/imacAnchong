<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Redirect;
/*
*   该模型是操作用户登录表的模块
*/
class Users_login extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'anchong_users_login';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public  $timestamps=false;

    /*
    *   该方法是添加登录用户账号密码的方法，在注册成功之后会返回用户Token和用户ID还有用户权限
    */
    public function add($user_data)
    {
        //将数据存入登录表
        $this->fill($user_data);
        if($this->save()){
            return true;
        }else{
            return false;
        }
    }

    /*
    *   登陆时的显示用户的token和用户id
    */
    public function quer($field, $quer_data)
    {
        return $this->select($field)->where($quer_data)->get();
    }

    /*
    *   登陆是更新token
    */
    public function addToken($user_data, $users_id){
        $user=$this->where('users_id', '=', $users_id);
        if($user->update($user_data)){
            return true;
        }else{
            return false;
        }

    }

    /*
    *   获得用户token
    */
    public function querToken($guid){
        return $this->select('token')->where('users_id',$guid)->get()->toArray();
    }

    /*
    *   该方法是更新密码
    */
    public function updatepassword($phone,$data)
    {
        $id=$this->where('username','=',$phone);
        if($id->update($data)){
            return true;
        }else{
            return false;
        }
    }

    //通过用户id获取记录
    public function scopeUid($query,$keyUid)
    {
        return $query->where('users_id', '=', $keyUid)->first();
    }
}
