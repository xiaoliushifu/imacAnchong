<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon_pool extends Model
{
    protected $table = 'anchong_coupon_pool';
    protected $guard='acpid';
    protected $primaryKey='acpid';
    //不允许用create方法赋值
    protected $guarded = [];
    public  $timestamps=false;

    /*
    *   查询信息
    */
    public function quer($field,$type,$pos,$limit)
    {
        return ['total'=>$this->whereRaw($type)->count(),'list'=>$this->select($field)->whereRaw($type)->skip($pos)->take($limit)->orderBy('acpid', 'DESC')->get()];
    }
}
