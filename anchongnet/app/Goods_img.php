<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模型是操作商品图片表的模块
*/
class Goods_img extends Model
{
    protected $table = 'anchong_goods_img';
    protected $primaryKey = 'iid';
    public $timestamps = false;
    //可以批量赋值的属性
    protected $fillable = ['gid','url','type'];

    /*
     * 根据条件进行图片搜索
     * */
    public function scopeGid($query,$keyGid)
    {
        return $query->where('goods_id', '=', $keyGid);
    }

    /*
    *   商品图片查询
    */
    public function quer($field,$type)
    {
        return $this->select($field)->whereRaw($type)->get();
    }
}
