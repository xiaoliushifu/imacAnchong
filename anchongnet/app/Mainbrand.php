<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模型是操作商铺经营品牌的模块
*/
class Mainbrand extends Model
{
    protected $table = 'anchong_shops_mainbrand';
    protected $fillable = ['sid', 'brand_id', 'brand_name','authorization'];
    /*
     * 根据条件进行品牌查询
     * */
    public function scopeShop($query,$keyShop)
    {
        return $query->where('sid', '=', $keyShop);
    }
}
