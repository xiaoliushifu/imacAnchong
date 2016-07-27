<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use DB;
/**
*
*   根据输入的关键字 进行搜索处理
*/
class SearchController extends Controller
{
    /**
     * 货品搜索，不带分词
     * @param Request $req
     */
    public function index(Request $req)
    {
        $q=$req->get('q');
        $ql=mb_strlen($q,'utf-8');
        if ($ql<1 || $ql>8) {
            return response()->json(['search'=>$q,'fenci'=>'Too','ResultData'=>[]]);
        }
        $tq = bin2hex($q);
        //返回数组，但其元素是对象
        $tmp=DB::select("select `cat_id` from `anchong_goods_keyword` where match(`keyword`) against(:key)",[$tq]);
        foreach($tmp as $o) {
            $tmparr[]= $o->cat_id;
        }
        //去表中查找真正数据
        $result = DB::table('anchong_goods_type')->whereIn('cat_id',$tmparr)->get();
        return response()->json(['search'=>$q,'fenci'=>'','ResultData'=>$result]);
    }
}
