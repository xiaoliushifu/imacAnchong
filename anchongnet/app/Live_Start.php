<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Live_Start extends Model
{
    protected $table = 'v_start';
    protected $guard='zb_id';
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
