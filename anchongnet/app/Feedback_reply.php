<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模型是操作商机表的模块
*/
class Feedback_reply extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'anchong_feedback_reply';
    protected $primaryKey = 'freply_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     //不允许被赋值
    protected $guarded = ['freply_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public  $timestamps=false;


    /*
     * 反馈回复查询
     */
     public function quer($field,$type)
     {
         return $this->select($field)->whereRaw($type)->orderBy('freply_id','DESC')->get();
     }
}
