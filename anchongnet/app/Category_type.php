<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模型是操作三级分类的模块
*/
class Category_type extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'anchong_goods_cat_type';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     //不允许被赋值
    protected $guarded = ['cid'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public  $timestamps=false;

    /*
    *   分类查询
    */
    public function quer($field,$type)
    {
        return $this->select($field)->whereRaw($type)->get();
    }
}
