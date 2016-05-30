<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Redirect;

/*
*   该模型是操作商品分类表的模块
*/
class Goods_type extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'anchong_goods_type';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     //不允许被赋值
<<<<<<< HEAD
    protected $guarded = ['catid'];
	protected $primaryKey = 'cat_id';
=======
    protected $guarded = ['cat_id'];
    protected $primaryKey = 'cat_id';
>>>>>>> origin/renqingbin

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public  $timestamps=false;

    /*
    *   分类查询
    */
    public function quer($field,$type,$pos,$limit)
    {
        return ['total'=>$this->select($field)->whereRaw($type)->count(),'list'=>$this->select($field)->whereRaw($type)->skip($pos)->take($limit)->orderBy('created_at', 'DESC')->get()];
    }

    /*
    *   分类条件查询
    */
    public function condquer($field,$type,$pos,$limit,$condition,$sort)
    {
        return ['total'=>$this->select($field)->whereRaw($type)->count(),'list'=>$this->select($field)->whereRaw($type)->skip($pos)->take($limit)->orderBy($condition, $sort)->get()];
    }

    /*
    *   该方法是商品分类添加
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
    *   检索查询
    */
    public function searchquer($field,$type)
    {
        return $this->select($field)->whereRaw($type)->get();
    }

    /*
    *   该方法是货品信息删除
    */
    public function del($num)
    {
        return $this->where('gid', '=', $num)->delete();
    }

    /*
     *  通过关联的货品id查找指定的数据
     */
    public function scopeGid($query,$keyGid)
    {
        return $query->where('gid', '=', $keyGid)->first();
    }
<<<<<<< HEAD

    /*
    *   该方法是货品信息删除
    */
    public function del($num)
    {
        return $this->where('gid', '=', $num)->delete();
    }
=======
>>>>>>> renqingbin
}
