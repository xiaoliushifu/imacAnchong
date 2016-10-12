<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模型是操作商品表的模块
*/
class Goods extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'anchong_goods';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'desc'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public  $timestamps=false;

    //不允许被赋值
    protected $guarded = ['goods_id'];
    protected  $primaryKey='goods_id';
    /*
    *   商品查询
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
       //将货品添加入数据表
       $this->fill($goods_data);
       if ($this->save()) {
           return $this->id;
       } else {
           return;
       }
    }

    /*
     * 根据条件进行商品查询
     * */
    public function scopeName($query,$keyName)
    {
        return $query->where('title', 'like', "%{$keyName}%");
    }

    /*
    *   根据分类进行商品查询
    */
    public function scopeType($query,$keyType,$keySid)
    {
        return $query->whereRaw("match(`type`) against(?)",array(bin2hex($keyType)) )->where('sid','=',$keySid);
    }

    /*
    *   根据分类和商铺进行商品查询
    */
    public function scopeMType($query,$keyType,$keySid)
    {
        return $query->whereRaw("`type`=? ", array($keyType))->where('sid','=',$keySid);
    }

    /*
    *   根据分类进行商品查询三条数据
    */
    public function getGoodsByType($type)
    {
        return $this->whereRaw("match(`type`) against(?)",array(bin2hex($type)) )->take(3)->get();
    }
}
