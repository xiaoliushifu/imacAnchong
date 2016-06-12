<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模型是操作商品属性表的模块
*/
class Goods_attribute extends Model
{

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

    /*
     *  根据条件进行属性查询
     */
    public function scopeGood($query,$keyGood){
        return $query->where('goods_id', '=', $keyGood);
    }
}
