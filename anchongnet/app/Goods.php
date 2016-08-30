<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   商品表
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
    public function scopeName($query,$keyName,$keySid)
    {
        return $query->where('title', 'like', "%{$keyName}%")->where('sid','=',$keySid);
    }
    
    public function scopeType($query,$keyType,$keySid)
    {
        return $query->where('type', 'like', "%{$keyType}%")->where('sid','=',$keySid);
    }
    
    public function getGoodsByType($type)
    {
        return $this->whereRaw("match(`type`) against(?)",array(bin2hex($type)) )->take(3)->get();
    }
}
