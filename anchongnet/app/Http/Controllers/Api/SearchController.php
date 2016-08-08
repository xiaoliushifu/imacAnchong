<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Cache;


/**
*
*   搜索智能提示，前缀搜索匹配
*/
class SearchController extends Controller
{
    public function postIndex(Request $req)
    {
        $data=$req->all();
        $param=json_decode($data['param'],true);
        $q = $param['q'];
        if (!$q) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>10,'ResultData'=>['']]);
        }
        $prefix='suggestion';
        if (!$result = Cache::get($prefix.$q)) {
            //返回数组，但其元素是对象
            //DB::connection()->enableQueryLog();
            $tmp=DB::select("select `str` from `anchong_goods_suggestion` where `str` like '$q%' order by qnums desc limit 6");
            //$queries = DB::getQueryLog();
            if (!$tmp) {
                return response()->json(['serverTime'=>time(),'ServerNo'=>10,'ResultData'=>['']]);
            }
            $result='';
            foreach ($tmp as $o) {
                $result[]= $o->str;
            }
            //缓存30分钟
            Cache::add($prefix.$q,$result,30);
        }
        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$result]);
    }
}
