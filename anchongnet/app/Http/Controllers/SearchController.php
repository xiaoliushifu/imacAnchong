<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Cache;


/**
*
*   根据输入的关键字 进行搜索处理,WEB端
*/
class SearchController extends Controller
{
    /**
     * 货品搜索，不带分词
     * @param Request $req
     */
    public function index(Request $req)
    {
        dd('Nothing');
        $q=$req->get('q');
        $ql=mb_strlen($q,'utf-8');
        if ($ql<1 || $ql>8) {
            return response()->json(['search'=>$q,'fenci'=>'Too','ResultData'=>['keyword too short']]);
        }
        //缓存前缀
        $prefix='search';
        //搜索缓存处理
        if (!$result = Cache::get($prefix.$q)) {
            $tq = bin2hex($q);
            //返回数组，但其元素是对象
            $tmp=DB::select("select `cat_id` from `anchong_goods_keyword` where match(`keyword`) against(:key)",[$tq]);
            if (!$tmp) {
                return response()->json(['search'=>$q,'fenci'=>'Too','ResultData'=>['Nothing to find']],200,['Content-type'=>'application/json;charset=utf-8'],JSON_UNESCAPED_UNICODE);
            }
            foreach($tmp as $o) {
                $tmparr[]= $o->cat_id;
            }
            //去表中查找真正数据
            $result = DB::table('anchong_goods_type')->whereIn('cat_id',$tmparr)->get();
            Cache::add($prefix.$q,$result,60);
        }
        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'search'=>$q,'fenci'=>'','ResultData'=>$result],200,['Content-type'=>'application/json;charset=utf-8'],JSON_UNESCAPED_UNICODE);
    }
}
