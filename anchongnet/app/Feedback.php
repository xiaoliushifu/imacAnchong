<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模型是操作反馈表的模块
*/
class Feedback extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'anchong_feedback';
    protected $primaryKey = 'feed_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     //不允许被赋值
    protected $guarded = ['feed_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public  $timestamps=false;

    /*
    *   该方法是添加信息
    */
    public function add($data)
    {
       //将用户发布的商机信息添加入数据表
       $this->fill($data);
       if($this->save()){
           return $this->feed_id;
       }else{
           return;
       }
    }

    /*
     * 获取指定用户的发布信息
     */
     public function scopeUser($query)
     {
         return $query;
     }

     /*
     *   数量统计
     */
     public function feedbackcount($type)
     {
         return $this->whereRaw($type)->count();
     }
}
