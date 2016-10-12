<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模型是操作商铺经营范围表的模块
*/
class ShopCat extends Model
{
    protected $table = 'anchong_shops_category';
    protected $fillable = ['sid', 'cat_id','cat_name'];
    public function scopeShop($query,$keyShop)
    {
        return $query->where('sid', '=', $keyShop);
    }
}
