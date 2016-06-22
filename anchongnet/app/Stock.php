<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'anchong_goods_stock';
    public $timestamps = false;
    protected $primaryKey = 'stock_id';
    protected $fillable = ['gid', 'region','region_num'];

    /*
     * 根据条件进行库存搜索
     * */
    public function scopeGood($query,$keyGood)
    {
        return $query->where('gid', '=', $keyGood);
    }
}
