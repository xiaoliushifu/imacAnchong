<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模型是操作优惠券表的模块
*/
class Coupon extends Model
{
    protected $table = 'anchong_coupon';
    protected $guard='acid';
    //不允许被赋值
    protected $guarded = [];
    public  $timestamps=false;

    /*
    *   查询优惠券信息
    */
    public function quer($field,$quer_data)
    {
        return $this->select($field)->where($quer_data)->get();
    }

    /*
     * 查询构造器
     */
    public function scopeCoupon($query)
    {
        return $query;
    }
}
