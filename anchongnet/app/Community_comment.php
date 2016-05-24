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
}
