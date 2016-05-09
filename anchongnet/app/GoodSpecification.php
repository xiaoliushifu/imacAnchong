<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoodSpecification extends Model
{
    protected $table = 'anchong_goods_specifications';
    protected $primaryKey = 'gid';
    protected $fillable = ['cat_id', 'goods_name','market_price',
        'goods_price', 'vip_price','goods_desc',
        'keyword','goods_img','goods_ceate_time',
        'goods_num', 'goods_tag','sid','goods_numbering'];

    /*
     * 根据条件进行商品查询
     * */
    public function scopeName($query,$keyName)
    {
        return $query->where('goods_name', 'like', "%{$keyName}%");
    }
}
