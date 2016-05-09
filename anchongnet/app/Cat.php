<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cat extends Model
{
    protected $table = 'anchong_goods_cat';
    protected $fillable = [];

    /*
	* 根据条件进行分类搜索
	*/
    public function scopePids($query,$keyPid)
    {
        return $query->where('parent_id', '=', $keyPid);
    }
}
