<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模型是操作广告表的模块
*/
class Ad extends Model
{
    protected $table = 'anchong_ad';
    public $timestamps = false;
    //不允许被赋值
    protected $guarded = ['ad_id'];
    //定义主键
    protected $primaryKey = 'ad_id';

    /*
    *   收藏查询内容
    */
    public function quer($field,$type,$pos,$limit)
    {
         return $this->select($field)->whereRaw($type)->skip($pos)->take($limit)->get();
    }

    /*
    *   收藏查询内容
    */
    public function simplequer($field,$type)
    {
         return $this->select($field)->whereRaw($type)->orderBy('ad_id', 'ASC')->get();
    }

    /*
    *   该方法是更新
    */
    public function adupdate($id,$data)
    {
        $ad=$this->find($id);
        if($ad->update($data)){
            return true;
        }else{
            return false;
        }
    }
}
