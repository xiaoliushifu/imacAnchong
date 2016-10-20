<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模型是操作反馈回复表的模块
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
         return $this->select($field)->where('users_id',$type)->orderBy('freply_id','DESC')->get();
     }

    /*
     *   该方法是更新信息
     */
     public function replyupdate($id,$data)
     {
         $id=$this->find($id);
         if($id->update($data)){
             return true;
         }else{
             return false;
         }
     }

    /*
     *   删除信息
     */
     public function replydel($id)
     {
         $del=$this->find($id);
         if($del->delete()){
             return true;
         }else{
             return false;
         }
     }

     /*
      * 反馈回复未查看数量查询
      */
      public function countquer($users_id)
      {
          return $this->where('users_id',$users_id)->where('state',0)->count();
      }
}
