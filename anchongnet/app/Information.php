<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    protected $table = 'anchong_information';
    protected $primaryKey = 'infor_id';
    //不允许被赋值
    protected $guarded = [];
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

     /*
     *   该方法是资讯添加
     */
     public function add($cart_data)
     {
        //将订单数据添加入数据表
        $this->fill($cart_data);
        if($this->save()){
            return true;
        }else{
            return false;
        }
     }

     /*
     *   资讯查询内容
     */
     public function allquer($field)
     {
          return $this->select($field)->orderBy('created_at', 'DESC');
     }

     /*
     *   单一资讯查询内容
     */
     public function onequer($field,$type)
     {
          return $this->select($field)->whereRaw($type)->orderBy('created_at', 'DESC');
     }

     /*
     *   更新信息
     */
     public function newsupdate($id,$data)
     {
         $cartnum=$this->find($id);
         if($cartnum->update($data)){
             return true;
         }else{
             return false;
         }
     }

     /*
     *   删除聊聊信息
     */
     public function infordel($id)
     {
         return $this->destroy($id);
     }
}
