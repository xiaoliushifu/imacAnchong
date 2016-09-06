<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon_pool extends Model
{
    protected $table = 'anchong_coupon_pool';
    protected $guard='acpid';
    protected $primaryKey='acpid';
    //不允许用create方法赋值
    protected $guarded = [];
    public  $timestamps=false;

    /*
    *   查询信息
    */
    public function quer($field,$type,$pos,$limit)
    {
        return ['total'=>$this->whereRaw($type)->count(),'list'=>$this->select($field)->whereRaw($type)->skip($pos)->take($limit)->orderBy('acpid', 'DESC')->get()];
    }
    
    /**
     * 列表页的筛选
     * @param unknown $req
     */
    public function backfilter($req)
    {
        $where=[];
        foreach ($req->all() as $key=>$val) {
            if (!$val || $key== 'page') {
                continue;
            }
            if ($key == 'open') {
                $val--;
            }
            $where[]=[$key,$val];
            if ($key == 'acpid') {
                break;
            }
        }
        $res = $this->where($where)->orderBy("acpid","desc")->paginate(8);
        return ['data'=>$res,'where'=>$where];
    }
}
