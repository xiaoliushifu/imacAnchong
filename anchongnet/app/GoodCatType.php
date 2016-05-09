<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoodCatType extends Model
{
    protected $table = 'anchong_goods_cat_type';
    protected $fillable = ['cat_name', 'keyword', 'cat_desc','is_show','cat_id','parent_id','pic'];
    protected $guarded = ['cid'];
    public $timestamps = false;
    protected $primaryKey = 'cid';

    /*
     * 根据条件进行搜索
     * */
    public function scopeName($query,$keyName)
    {
        return $query->where('cat_name', 'like',"%{$keyName}%");
    }
    public function scopeLevel($query,$keyLevel)
    {
        return $query->where('parent_id', '=',$keyLevel);
    }
}
