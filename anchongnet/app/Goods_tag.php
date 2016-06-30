<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
