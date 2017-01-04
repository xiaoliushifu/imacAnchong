<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模型是操作聊聊评论回复表的模块
*/
class Community_reply extends Model
{
    protected $table = 'anchong_community_reply';
    public $timestamps = false;
    //不允许被赋值
    protected $guarded = ['reid'];
    //定义主键
    protected $primaryKey = 'reid';

    /*
    *   该方法是添加聊聊评论信息
    */
    public function add($data)
    {
        //将数据存入表中
        $this->fill($data);
        if($this->save()){
            return true;
        }else{
            return false;
        }
    }

    /*
    *   查询聊聊回复的信息限制查询
    */
    public function quer($field,$type,$pos,$limit)
    {
         return $this->select($field)->whereRaw($type)->skip($pos)->take($limit)->orderBy('reid', 'DESC')->get();
    }

    /*
    *   简单查询聊聊的评论回复信息
    */
    public function simplequer($field,$type)
    {
         return $this->select($field)->whereRaw($type)->orderBy('reid', 'DESC')->get();
    }

    /*
    *   删除评论回复
    */
    public function delcomment($id)
    {
        $data=$this->where('chat_id', '=', $id)->count();
        if($data > 0){
            if($this->where('chat_id', '=', $id)->delete()){
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }

}
