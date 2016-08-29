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
    *   该方法是订单生成
    */
    public function add($data)
    {
       //将数据添加入数据表
       $this->fill($data);
       if($this->save()){
           return true;
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
