<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    protected $table = 'anchong_information';
    protected $primaryKey = 'infor_id';
    public $timestamps = false;

    /*
    *   资讯查询内容
    */
    public function quer($field,$type,$pos,$limit)
    {
         return ['total'=>$this->select($field)->whereRaw($type)->count(),'list'=>$this->select($field)->whereRaw($type)->skip($pos)->take($limit)->orderBy('created_at', 'DESC')->get()->toArray()];
    }

     /*
     *   资讯内容单一查询
     */
     public function firstquer($field,$type)
     {
         return $this->select($field)->whereRaw($type)->orderBy('created_at', 'DESC')->first();
     }
}
