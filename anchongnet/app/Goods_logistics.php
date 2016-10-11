<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模快是操作物流表的
*/
class Goods_logistics extends Model
{
    protected $table = 'anchong_goods_logistics';
    protected $primaryKey = 'wid';
    protected $guarded = ['wid'];
    public $timestamps = false;

    /*
    *   物流数量查询
    */
    public function quer($type)
    {
        return $this->whereRaw($type)->count();
    }

    /*
    *   添加物流
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
    *   删除物流信息
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
