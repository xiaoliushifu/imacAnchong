<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模型是操作支付订单详细信息表的模块
*/
class Pay extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'anchong_pay';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     //不允许被赋值
    protected $guarded = ['pay_id'];
    //定义主键名称
    protected $primaryKey = 'pay_id';
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public  $timestamps=false;

    /*
    *   支付订单查询
    */
    public function quer($field,$type)
    {
        return $this->select($field)->whereRaw($type)->get();
    }

    /*
    *   该方法是支付订单详细信息添加
    */
    public function add($data)
    {
       //将订单数据添加入数据表
       $this->fill($data);
       if($this->save()){
           return true;
       }else{
           return false;
       }
    }

    /*
    *   该方法是订单详细信息删除
    */
    public function orderdel($num)
    {
        if($this->where('paynum', '=', $num)->delete()){
            return true;
        }else{
            return false;
        }
    }

    /*
    *   删除支付订单时
    */
    public function delorder($id)
    {
        $data=$this->where('order_id', '=', $id)->get()->toArray();
        if($data){
            if($this->where('order_id', '=', $id)->delete()){
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }
}
