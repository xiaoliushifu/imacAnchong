<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
