<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'anchong_goods_brand';
    protected  $primaryKey = 'brand_id';
    public $timestamps = false;
}
