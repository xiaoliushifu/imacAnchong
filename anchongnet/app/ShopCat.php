<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopCat extends Model
{
    protected $table = 'anchong_goods_category';
    protected $fillable = ['sid', 'cat_id'];
}
