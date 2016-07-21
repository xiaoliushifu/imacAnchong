<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模型是操作货品表的模块
*/
class Goods_specifications extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'anchong_goods_specifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     //不允许被赋值
    protected $guarded = ['gid'];
    //定义主键
    protected $primaryKey = 'gid';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public  $timestamps=false;

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
    public function add($user_data)
    {
       //将数据信息添加入数据表
       $this->fill($user_data);
       if($this->save()){
           return $this->id;
       }else{
           return;
       }
    }

    /*
    *   该方法是商品图片添加
    */
    public function addimg($pic,$id)
    {
       //将数据添加入数据表
       $img=$this->where('gid','=',$id);
       if($img->update($pic)){
           return true;
       }else{
           return false;
       }
    }

    /*
    *   该方法是更新货品信息
    */
    public function specupdate($id,$data)
    {
        $cartnum=$this->find($id);
        if($cartnum->update($data)){
            return true;
        }else{
            return false;
        }
    }

    /*
    *   分页查询
    */
    public function limitquer($field,$type)
    {
        return ['total'=>$this->select($field)->whereRaw($type)->count(),'list'=>$this->select($field)->whereRaw($type)->orderBy('updated_at', 'DESC')->get()];
    }

    /*
    *   货品删除
    */
    public function del($data)
    {
        return $this->destroy($data);
    }
}
