<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模型是操作聊聊评论表的模块
*/
class Community_comment extends Model
{
    protected $table = 'anchong_community_comment';
    public $timestamps = false;
    //不允许被赋值
    protected $guarded = ['comid'];
    //定义主键
    protected $primaryKey = 'comid';

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
    *   查询聊聊评论的信息带分页
    */
    public function quer($field,$type,$pos,$limit)
    {
         return ['total'=>$this->select($field)->whereRaw($type)->count(),'list'=>$this->select($field)->whereRaw($type)->skip($pos)->take($limit)->orderBy('comid', 'DESC')->get()->toArray()];
    }


    /*
    *   查询聊聊的评论信息
    */
    public function simplequer($field,$type)
    {
         return $this->select($field)->whereRaw($type)->get();
    }

    /*
    *   删除评论
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

    /*
     * 获取指定聊聊的评论
     * */
    public function scopeChat($query,$keyChat)
    {
        return $query->where('chat_id','=',$keyChat);
    }

}
