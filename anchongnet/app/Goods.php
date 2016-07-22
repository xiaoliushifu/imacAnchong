<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模型是操作货品表的模块
*/
class Goods extends Model
{
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
    *   分类查询
    */
    public function quer($field,$type)
    {
        return $this->select($field)->whereRaw($type)->get();
    }

    /*
    *   该方法是商品添加
    */
    public function add($goods_data)
    {
       //将货品添加入数据表
       $this->fill($goods_data);
       if($this->save()){
           return $this->id;
       }else{
           return;
       }
    }
}
