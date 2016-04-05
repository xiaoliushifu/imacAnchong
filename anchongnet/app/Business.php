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
    *   该方法是添加商机信息
    */
    public function add($user_data)
    {
       //将用户发布的商机信息添加入数据表
       $this->fill($user_data);
       if($this->save()){
           return $this->id;
       }else{
           return;
       }
    }
    /*
    *   因为是多表插入防止插入出错
    */
    public function del($data)
    {
        //通过传过来的userid来确定用户的位置
        $user=$this->find($data);
        if($user->delete()){
            return true;
        }else{
            return false;
        }
    }
    /*
    *   查询商机信息，有分页
    */
    public function quer($field,$column,$type,$pos,$limit)
    {
        return ['total'=>$this->select($field)->where($column,$type)->count(),'list'=>$this->select($field)->where($column,$type)->skip($pos)->take($limit)->get()->toArray()];
    }
}
