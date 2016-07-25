<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模型是操作聊聊表的模块
*/
class Community_release extends Model
{
    protected $table = 'anchong_community_release';
    public $timestamps = false;
    //不允许被赋值
    protected $guarded = ['chat_id'];
    //定义主键
    protected $primaryKey = 'chat_id';

    /*
    *   该方法是添加聊聊信息
    */
    public function add($data)
    {
       //将用户发布的商机信息添加入数据表
       $this->fill($data);
       if($this->save()){
           return $this->chat_id;
       }else{
           return;
       }
   }

   /*
   *   查询聊聊的信息
   */
   public function quer($field,$type,$pos,$limit)
   {
        return ['total'=>$this->select($field)->whereRaw($type)->count(),'list'=>$this->select($field)->whereRaw($type)->skip($pos)->take($limit)->orderBy('created_at', 'DESC')->get()->toArray()];
   }

   /*
   *   查询聊聊的信息
   */
   public function simplequer($field,$type)
   {
        return $this->select($field)->whereRaw($type)->get();
   }

   /*
   *   查询聊聊的信息
   */
   public function indexquer($field,$type)
   {
        return $this->select($field)->whereRaw($type);
   }

   /*
   *   删除聊聊信息
   */
   public function communitydel($id)
   {
       return $this->destroy($id);
   }

   /*
    * 获取指定用户的发布信息
    * */
    public function scopeUser($query,$keyUid)
    {
        return $query->where('users_id','=',$keyUid);
    }
    
    /*
     * 获取指定用户发布的指定类型的信息
     * */
    public function scopeTag($query,$keyUid,$keyTag)
    {
        return $query->where('users_id','=',$keyUid)->where('tags','=',$keyTag);
    }

    /*
     * 获取指定用户发布的指定类型的信息无用户区分
     * */
    public function scopeTags($query,$keyTag)
    {
        return $query->where('tags','=',$keyTag);
    }

}
