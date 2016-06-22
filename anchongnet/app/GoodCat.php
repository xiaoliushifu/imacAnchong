<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoodCat extends Model
{
    protected $table = 'anchong_goods_cat';
    protected $fillable = ['cat_name', 'keyword', 'cat_desc','is_show','parent_id'];
    protected $guarded = ['cat_id'];
    public $timestamps = false;
    protected $primaryKey = 'cat_id';
    /*
	* 根据条件进行分类搜索
	*/
    public function scopeName($query,$keyName)
    {
        return $query->where('cat_name', 'like',"%{$keyName}%");
    }
    public function scopeLevel($query,$keyLevel)
    {
        return $query->where('parent_id', '=',$keyLevel);
    }
    /*
     * 获取一级和二级分类表中的二级分类
     * */
    public function scopeLevel2($query)
    {
        return $query->where('parent_id', '!=',0);
    }
}
