<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'anchong_goods_brand';
    protected $fillable = ['brand_id', 'brand_name', 'brand_logo'];

}
