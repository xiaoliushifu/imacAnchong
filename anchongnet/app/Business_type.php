<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模型是操作商机类型表的模块
*/
class Business_type extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'anchong_business_type';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     //不允许被赋值
    protected $guarded = ['id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public  $timestamps=false;

    /*
    *   查询Business_type数据表中的数据
    */
    public function quer($field)
    {
        return $this->select($field)->get();
    }


}
