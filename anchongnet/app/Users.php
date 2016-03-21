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
    *   因为这个是多表插入，为了防止意外，在第一个用户表插入成功后第二个表插入失败时，会去删除第一个表中用户的信息，确保数据的正确性
    */
    public function del($user_data)
    {
        //通过传过来的userid来确定用户的位置
        $user=$this->find($user_data);
        if($user->delete('phone')){
            return true;
        }else{
            return false;
        }

    }
}
