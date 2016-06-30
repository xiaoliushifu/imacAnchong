<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoodThumb extends Model
{
    protected $table = 'anchong_goods_thumb';
    protected $primaryKey = 'tid';
    public $timestamps = false;
    protected $fillable = ['gid', 'img_url','thumb_url'];

    /*
     * 根据条件进行缩略图搜索
     * */
    public function scopeGid($query,$keyGid)
    {
        return $query->where('gid', '=', $keyGid);
    }
}
