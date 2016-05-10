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
*   该模型是操作商机表的模块
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
    protected $guarded = ['bid'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public  $timestamps=false;

    /*
    *   该方法是添加商机信息
    */
    public function add($data)
    {
       //将用户发布的商机信息添加入数据表
       $this->fill($data);
       if($this->save()){
           return $this->id;
       }else{
           return;
       }
    }

    /*
    *   查询商机信息，有分页
    */
    public function quer($field,$type,$pos,$limit)
    {
         return ['total'=>$this->select($field)->whereRaw($type)->count(),'list'=>$this->select($field)->whereRaw($type)->skip($pos)->take($limit)->orderBy('created_at', 'DESC')->get()->toArray()];
    }

    /*
    *   该方法是更新商机信息
    */
    public function businessupdate($id,$data)
    {
        $id=$this->where('bid','=',$id);
        if($id->update($data)){
            return true;
        }else{
            return false;
        }
    }

    /*
    *   删除商机信息
    */
    public function businessdel($id)
    {
        $del=$this->where('bid','=',$id);
        if($del->delete()){
            return true;
        }else{
            return false;
        }
    }

    /*
    *   商机时间查询
    */
    public function quertime($field,$type)
    {
        return $this->select($field)->whereRaw($type)->get();
    }
}
