<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模型是操作商品标签表的模块
*/
class Goods_tag extends Model
{
    protected $table = 'anchong_goods_tag';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /*
    *   标签搜索
    */
    public function quer($field,$type)
    {
        return $this->select($field)->whereRaw($type)->get();
    }

    public function scopeCat($query,$keyCat)
    {
        return $query->where('cat_id', '=', $keyCat);
    }
}
