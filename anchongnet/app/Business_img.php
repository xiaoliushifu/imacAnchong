<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模型是操作商机图片表的模块
*/
class Business_img extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'anchong_business_img';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     //不允许被赋值
    protected $guarded = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public  $timestamps=false;

    /*
    *   该方法是添加发布信息带的图片
    */
    public function add($data)
    {
        //将数据存入商机表
        $this->fill($data);
        if($this->save()){
            return true;
        }else{
            return false;
        }
    }

    /*
    *   该方法是商机图片表的查询
    */
    public function quer($field,$id)
    {
        return $this->select($field)->where('bid',$id)->get()->toArray();
    }

    /*
    *   删除商机时将图片一起删除
    */
    public function delimg($id)
    {
        $data=$this->where('bid', '=', $id)->get()->toArray();
        if($data){
            if($this->where('bid', '=', $id)->delete()){
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }

    /*
     *  获取指定商机的图片
     */
    public function scopeBus($query,$keyBid)
    {
        return $query->where('bid','=',$keyBid);
    }
}
