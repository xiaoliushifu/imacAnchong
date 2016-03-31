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
class Business extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'anchong_business';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     //不允许被赋值
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
            //因为这个是多表插入，为了防止意外，在第一个用户表插入成功后第二个表插入失败时，会去删除第一个表中已插入的数据来确保数据的正确性
            $users=new \App\Users();
            if($users->del($user_data['users_id'])){
                return 2;
            }else{
                return false;
            }

        }

    }

    /*
    *   登陆时的显示用户的token和用户id
    */
    public function quer($field, $quer_data)
    {
        return $this->select($field)->where($quer_data)->get();
    }

    //登陆是更新token
    public function addToken($user_data, $users_id){
        $user=$this->where('users_id', '=', $users_id);
        if($user->update($user_data)){
            return true;
        }else{
            return false;
        }

    }
    //获得token
    public function querToken($guid){
        return $this->select('token')->where('users_id',$guid)->get()->toArray();
    }
    //查看手机是否已注册
    public function querPhone($phone){
        return $this->select('phone')->where('phone',$phone)->get()->toArray();
    }
    //更新用户视频
    public function addcourse($user_data,$userid){
        $user=$this->find($userid);
        if($user->update($user_data)){
            return true;
        }else{
            return false;
        }
    }
	/*----按照名字进行匹配搜索----*/
	public function scopeKeyActive($query,$keyActive)
    {
        return $query->where('active', '=', "{$keyActive}");
    }
}
