<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模型是操作购物车表的模块
*/
class Cart extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'anchong_goods_cart';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     //不允许被赋值
    protected $guarded = ['cart_id'];
    //定义主键名称
    protected $primaryKey = 'cart_id';
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
        return $this->select($field)->whereRaw($type)->orderBy('created_at', 'DESC')->get();
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

    /*
    *   购物车数量
    */
    public function cartamount($field,$type)
    {
        return $this->select($field)->whereRaw($type)->get();
    }
}
