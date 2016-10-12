<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
*   该模型是操作区域库存表的模块
*/
class Stock extends Model
{
    protected $table = 'anchong_goods_stock';
    public $timestamps = false;
    protected $primaryKey = 'stock_id';
    protected $fillable = ['gid', 'region','region_num'];

    /*
     * 根据条件进行库存搜索
     * */
    public function scopeGood($query,$keyGood)
    {
        return $query->where('gid', '=', $keyGood);
    }

    /*
    *   删除货品的库存与区域
    */
    public function del($num)
    {
        if($this->where('gid', '=', $num)->delete()){
            return true;
        }else{
            return false;
        }
    }
}
