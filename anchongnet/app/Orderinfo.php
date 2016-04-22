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
*   该模型是操作订单详细信息表的模块
*/
class Orderinfo extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'anchong_goods_orderinfo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     //不允许被赋值
    protected $guarded = ['oid'];
    //定义主键名称
    protected $primaryKey = 'oid';
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public  $timestamps=false;

    /*
    *   购物车显示
    */
    public function quer($field,$type)
    {
        return $this->select($field)->whereRaw($type)->get();
    }

    /*
    *   该方法是购物车添加
    */
    public function add($cart_data)
    {
       //将购物车数据添加入数据表
       $this->fill($cart_data);
       if($this->save()){
           return true;
       }else{
           return false;
       }
    }

    /*
    *   该方法是购物车商品数量信息
    */
    public function cartupdate($id,$data)
    {
        $cartnum=$this->find($id);
        if($cartnum->update($data)){
            return true;
        }else{
            return false;
        }
    }

    /*
    *   该方法是购物车删除
    */
    public function cartdel($data)
    {
        return $this->destroy($data);
    }
}
