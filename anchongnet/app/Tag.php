<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'anchong_tag';
    protected $fillable = ['type_id', 'tag'];
    public $timestamps = false;
    /*
	* 根据条件进行标签搜索
	*/
    public function scopeType($query,$keyType)
    {
        return $query->where('type_id', '=', $keyType);
    }
    
    public function quer($field, $id)
    {
        return $this->select($field)->where('type_id',$id)->orWhere('type_id',0)->get();
    }
    
    public function search_quer($field, $id)
    {
        return $this->select($field)->where('type_id',$id)->get();
    }
    
}
