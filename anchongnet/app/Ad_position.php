<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模型是操作广告表的模块
*/
class Ad_position extends Model
{
    protected $table = 'anchong_ad_position';
    public $timestamps = false;
    //不允许被赋值
    protected $guarded = ['position_id'];
    //定义主键
    protected $primaryKey = 'position_id';

    /*
    *   分页查询内容
    */
    public function quer($field,$type,$pos,$limit)
    {
         return $this->select($field)->whereRaw($type)->skip($pos)->take($limit)->orderBy('created_at', 'DESC')->get();
    }

    /*
    *   简单查询内容
    */
    public function simplequer($field,$type)
    {
         return $this->select($field)->whereRaw($type)->orderBy('position_id', 'ASC')->get();
    }
}
