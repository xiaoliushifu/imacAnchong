<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模型是操作聊聊图片表的模块
*/
class Community_img extends Model
{
    protected $table = 'anchong_community_img';
    public $timestamps = false;
    //不允许被赋值
    protected $guarded = ['id'];
    //定义主键
    protected $primaryKey = 'id';

    /*
    *   该方法是添加聊聊信息
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
    *   该方法是聊聊图片表的查询
    */
    public function quer($field,$id)
    {
        return $this->select($field)->where('chat_id',$id)->get()->toArray();
    }

    /*
    *   该方法是更新聊聊图片
    */
    public function comupdate($id,$data)
    {
        $id=$this->where("id","=",$id);
        if($id->update($data)){
            return true;
        }else{
            return false;
        }
    }

    /*
    *   删除聊聊时将图片一起删除
    */
    public function delimg($id)
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
     * 获取指定发布的图片
     * */
    public function scopeChat($query,$keyChat)
    {
        return $query->where('chat_id','=',$keyChat);
    }
}
