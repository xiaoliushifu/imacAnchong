<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模型是操作配套货品表的模块
*/
class GoodSupporting extends Model
{
    protected $table = 'anchong_goods_supporting';
    protected $primaryKey = 'supid';
    protected $fillable=['goods_id','gid','title','price','img','assoc_gid','goods_name'];
    public $timestamps = false;

    /*
     * 查找某个商品的所有关联商品,也叫配套商品
     * */
    public function scopeGood($query,$keyGood)
    {
        return $query->where('assoc_gid', '=', $keyGood);
    }

    /*
    *   查询货品信息
    */
    public function quer($field,$type)
    {
         return $this->select($field)->whereRaw($type)->get();
    }
}
