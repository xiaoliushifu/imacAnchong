<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模型是操作一级二级分类表的模块
*/
class Category extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'anchong_goods_cat';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     //不允许被赋值
    protected $guarded = ['cat_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public  $timestamps=false;
    protected $primaryKey = 'cat_id';

    /*
    *   分类查询
    */
    public function quer($field,$type)
    {
        return $this->select($field)->whereRaw($type)->orderBy("sort_order","ASC")->get();
    }
    
    /*
     * 根据条件进行分类搜索
     */
    public function scopePids($query,$keyPid)
    {
        return $query->where('parent_id', '=', $keyPid);
    }
    
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
