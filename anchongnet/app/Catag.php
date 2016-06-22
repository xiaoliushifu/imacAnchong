<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Catag extends Model
{
    protected $table = 'anchong_goods_tag';
    protected $fillable = ['tag', 'cat_id'];
    public $timestamps = false;
    /*
     * 根据条件进行标签搜索
     * */
    public function scopeCat($query,$keyCat){
        return $query->where('cat_id', '=', $keyCat);
    }
}
