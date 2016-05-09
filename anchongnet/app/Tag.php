<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'anchong_tag';
    protected $fillable = ['type_id', 'tag'];
    public $timestamps = false;
    /*
	* 根据条件进行标签搜索
	*/
    public function scopeType($query,$keyType)
    {
        return $query->where('type_id', '=', $keyType);
    }
}
