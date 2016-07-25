<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模型是操作意见反馈图片表的模块
*/
class Feedback_img extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'anchong_feedback_img';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     //不允许被赋值
    protected $guarded = ['id'];

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
       //将用户发布的信息添加入数据表
       $this->fill($data);
       if($this->save()){
           return true;
       }else{
           return false;
       }
    }

    /*
    *   该方法是反馈图片表的查询
    */
    public function quer($field,$id)
    {
        return $this->select($field)->where('feed_id',$id)->get()->toArray();
    }

    /*
    *   删除反馈时将图片一起删除
    */
    public function delimg($id)
    {
        $data=$this->where('feed_id', '=', $id)->count();
        if($data > 0){
            if($this->where('feed_id', '=', $id)->delete()){
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }

}
