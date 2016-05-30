<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模快是操作快递公司表的
*/
class Shops_logistics extends Model
{
    protected $table = 'anchong_shops_logistics';
    protected $primaryKey = 'l_id';
    protected $guarded = ['l_id'];
    protected $fillable=['name','num'];
    public $timestamps = false;

    /*
    *   商家地址查询
    */
    public function quer($field)
    {
        return $this->select($field)->get();
    }
}
