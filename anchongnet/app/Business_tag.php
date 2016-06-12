<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模型是操作标签的模块
*/
class Business_tag extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'anchong_tag';

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
    *   查询Business_tag数据表里面的数据
    */
    public function quer($field, $id)
    {
        return $this->select($field)->where('type_id',$id)->orWhere('type_id',0)->get();
    }

    /*
    *   检索是时查询Business_tag数据表里面的数据
    */
    public function search_quer($field, $id)
    {
        return $this->select($field)->where('type_id',$id)->get();
    }

}
