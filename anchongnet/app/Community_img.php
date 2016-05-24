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
        //将数据存入商机表
        $this->fill($data);
        if($this->save()){
            return true;
        }else{
            return false;
        }
    }
}
