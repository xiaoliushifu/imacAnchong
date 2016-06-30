<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopCat extends Model
{
    protected $table = 'anchong_shops_category';
    protected $fillable = ['sid', 'cat_id','cat_name'];
    public function scopeShop($query,$keyShop)
    {
        return $query->where('sid', '=', $keyShop);
    }
}
