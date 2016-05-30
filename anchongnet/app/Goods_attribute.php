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
*   该模型是操作商品属性表的模块
*/
class Goods_attribute extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'anchong_goods_attribute';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     //不允许被赋值
    protected $guarded = ['atid'];
    //定义主键名称
    protected $primaryKey = 'atid';
    //可以批量赋值的属性
    protected $fillable=['goods_id','name','value'];
<<<<<<< HEAD
=======

>>>>>>> origin/renqingbin
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public  $timestamps=false;

    /*
    *   属性查询
    */
    public function quer($field,$type)
    {
        return $this->select($field)->whereRaw($type)->get();
    }
<<<<<<< HEAD
    /*
     * 根据条件进行属性查询
     * */
=======
    
    /*
     *  根据条件进行属性查询
     */
>>>>>>> origin/renqingbin
    public function scopeGood($query,$keyGood){
        return $query->where('goods_id', '=', $keyGood);
    }
}
