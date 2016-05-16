<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mainbrand extends Model
{
    protected $table = 'anchong_goods_mainbrand';
    protected $fillable = ['users_id', 'name', 'introduction','premises','img','audit','free_price','freight','customer'];
}
