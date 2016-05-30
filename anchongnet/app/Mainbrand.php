<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mainbrand extends Model
{
<<<<<<< HEAD
    protected $table = 'anchong_goods_mainbrand';
    protected $fillable = ['users_id', 'name', 'introduction','premises','img','audit','free_price','freight','customer'];
=======
    protected $table = 'anchong_shops_mainbrand';
    protected $fillable = ['sid', 'brand_id', 'brand_name','authorization'];
    /*
     * 根据条件进行品牌查询
     * */
    public function scopeShop($query,$keyShop)
    {
        return $query->where('sid', '=', $keyShop);
    }
>>>>>>> origin/renqingbin
}
