<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模快是操作收藏表的
*/
class Collection extends Model
{
    protected $table = 'anchong_collection';
    protected $primaryKey = 'rec_id';
    protected $guarded = ['rec_id'];
    public $timestamps = false;

    /*
    *   收藏查询
    */
    public function quer($type)
    {
        return $this->whereRaw($type)->count();
    }

    /*
    *   收藏查询内容
    */
    public function querinfo($field,$type)
    {
        return $this->select($field)->whereRaw($type)->get();
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
