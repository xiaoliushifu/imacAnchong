<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模型是操作聊聊收藏表的模块
*/
class Community_collect extends Model
{
    protected $table = 'anchong_community_collect';
    public $timestamps = false;
    //不允许被赋值
    protected $guarded = ['collect_id'];
    //定义主键
    protected $primaryKey = 'collect_id';

    /*
    *   收藏查询内容
    */
    public function quer($field,$type,$pos,$limit)
    {
         return $this->select($field)->whereRaw($type)->skip($pos)->take($limit)->orderBy('created_at', 'DESC')->get();
    }


    /*
    *   收藏查询
    */
    public function countquer($type)
    {
        return $this->whereRaw($type)->count();
    }

    /*
    *   添加收藏
    */
    public function add($data)
    {
        //将用户发布的商机信息添加入数据表
        $this->fill($data);
        if($this->save()){
            return true;
        }else{
            return false;
        }
    }

    /*
    *   取消收藏
    */
    public function del($type)
    {
        $del=$this->whereRaw($type);
        if($del->delete()){
            return true;
        }else{
            return false;
        }
    }

}
