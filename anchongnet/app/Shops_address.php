<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模快是操作商家地址表的
*/
class Shops_address extends Model
{
    protected $table = 'anchong_shops_address';
    protected $primaryKey = 'said';
    protected $guarded = ['said'];
    public $timestamps = false;

    /*
    *   商家地址查询
    */
    public function quer($type)
    {
        return $this->whereRaw($type)->count();
    }

    /*
    *   添加商家地址
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
    *   删除商家地址
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
