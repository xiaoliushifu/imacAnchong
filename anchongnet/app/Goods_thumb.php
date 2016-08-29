<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模型是操作货品图片表的模块
*/
class Goods_thumb extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'anchong_goods_thumb';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     //不允许被赋值
    protected $guarded = ['tid'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public  $timestamps=false;
    protected $primaryKey = 'tid';

    /*
    *   分类查询
    */
    public function quer($field,$type)
    {
        return $this->select($field)->whereRaw($type)->get();
    }

    /*
    *   该方法是商品添加
    */
    public function add($goods_data)
    {
       //将用户发布的商机信息添加入数据表
       $this->fill($goods_data);
       if($this->save()){
           return true;
       }else{
           return false;
       }
    }

    /*
    *   该方法是图片删除
    */
    public function del($num)
    {
        if($this->where('gid', '=', $num)->delete()){
            return true;
        }else{
            return false;
        }
    }
    
    /*
     * 根据条件进行缩略图搜索
     * */
    public function scopeGid($query,$keyGid)
    {
        return $query->where('gid', '=', $keyGid);
    }
    
}
