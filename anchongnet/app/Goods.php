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
<<<<<<< HEAD
*   该模型是操作货品图片表的模块
=======
*   该模型是操作货品表的模块
>>>>>>> origin/renqingbin
*/
class Goods extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'anchong_goods';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     //不允许被赋值
    protected $guarded = ['goods_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public  $timestamps=false;

    /*
<<<<<<< HEAD
    *   分类查询
=======
    *   商品查询
>>>>>>> origin/renqingbin
    */
    public function quer($field,$type)
    {
        return $this->select($field)->whereRaw($type)->get();
    }

    /*
    *   该方法是商品添加
    */
<<<<<<< HEAD
    public function add($user_data)
    {
       //将用户发布的商机信息添加入数据表
       $this->fill($user_data);
=======
    public function add($goods_data)
    {
       //将货品添加入数据表
       $this->fill($goods_data);
>>>>>>> origin/renqingbin
       if($this->save()){
           return $this->id;
       }else{
           return;
       }
    }
}
