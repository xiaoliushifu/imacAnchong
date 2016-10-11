<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模型是操作商品分类表的模块
*/
class Goods_keyword extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'anchong_goods_keyword';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     //不允许被赋值
    protected $guarded = ['cat_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public  $timestamps=false;

    /*
     * 获取分类筛选的商品对象
     */
    public function scopeGoods($query,$sql)
    {
        return $query->whereRaw($sql);
    }
}
