<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goods_img extends Model
{
    protected $table = 'anchong_goods_img';
    protected $primaryKey = 'iid';
    public $timestamps = false;
    protected $fillable = ['gid','url','type'];

    /*
     * 根据条件进行图片搜索
     * */
    public function scopeGid($query,$keyGid)
    {
        return $query->where('goods_id', '=', $keyGid);
    }

    /*
    *   图片查询
    */
    public function quer($field,$type)
    {
        return $this->select($field)->whereRaw($type)->get();
    }
}
