<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模型是操作钱袋订单的模块
*/
class Purse_order extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'anchong_purse_order';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     //不允许被赋值
    protected $guarded = ['purse_oid'];
    //定义主键名称
    protected $primaryKey = 'purse_oid';
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public  $timestamps=false;

    /*
     * 查询构造器
     */
    public function scopePurse($query)
    {
        return $query;
    }

    /*
    *   该方法是订单生成
    */
    public function add($data)
    {
       //将数据添加入数据表
       $this->fill($data);
       if($this->save()){
           return $this->purse_oid;
       }else{
           return false;
       }
    }

    /*
    *   查询
    */
    public function quer($field,$type)
    {
        return $this->select($field)->whereRaw($type)->get();
    }

    /*
    *   查询信息，有分页
    */
    public function pagequer($field,$type,$pos,$limit)
    {
         return ['total'=>$this->whereRaw($type)->count(),'list'=>$this->select($field)->whereRaw($type)->skip($pos)->take($limit)->orderBy('purse_oid', 'DESC')->get()];
    }

    /*
    *   该方法是更新商机信息
    */
    public function purseupdate($id,$data)
    {
        $id=$this->where('order_num','=',$id);
        if($id->update($data)){
            return $this->purse_oid;
        }else{
            return false;
        }
    }

    /*
    *   该方法是删除
    */
    public function pursedel($data)
    {
        return $this->destroy($data);
    }
}
