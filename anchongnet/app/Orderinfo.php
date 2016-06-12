<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模型是操作订单详细信息表的模块
*/
class Orderinfo extends Model
{

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
    *   订单查询
    */
    public function quer($field,$type)
    {
        return $this->select($field)->whereRaw($type)->get();
    }

    /*
    *   该方法是订单详细信息添加
    */
    public function add($cart_data)
    {
       //将订单数据添加入数据表
       $this->fill($cart_data);
       if($this->save()){
           return true;
       }else{
           return false;
       }
    }

    /*
    *   该方法是订单详细信息删除
    */
    public function orderinfodel($num)
    {
        if($this->where('order_num', '=', $num)->delete()){
            return true;
        }else{
            return false;
        }
    }

    /*
    * 根据条件进行收货地址搜索
    */
    public function scopeNum($query,$keyNum)
    {
        return $query->where('order_num', '=', $keyNum);
    }
}
