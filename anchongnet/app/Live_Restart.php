<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Live_Restart extends Model
{
    protected $table = 'v_restart';
    //定义主键名称
    protected $primaryKey = 'cb_id';
    //不允许被赋值
    protected $guarded = [];
    public  $timestamps=false;

    /*
     * 查询构造器
     */
    public function scopeLive($query)
    {
        return $query;
    }
}
