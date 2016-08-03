<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Cache;


/**
*
*   根据输入的关键字 进行搜索处理
*/
class SearchController extends Controller
{
    public function getIndex(Request $req)
    {
        dd('Nothing');
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$req->all();
        dd($data);
        $param=json_decode($data['param'],true);
        $ql=mb_strlen($param['q'],'utf-8');
        //关键字太短
        if ($ql<1 || $ql>8) {
            return response()->json(['search'=>$q,'fenci'=>'Too','serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'Nothing to find']]);
        }
        $prefix='search';
        if (!$result = Cache::get($prefix.$q)) {
            //返回数组，但其元素是对象
            $tmp=DB::select("select `cat_id` from `anchong_goods_keyword` where match(`keyword`) against(:key)",[bin2hex($q)]);
            if (!$tmp) {
                return response()->json(['search'=>$q,'fenci'=>'Too','ResultData'=>['Nothing to find']],200,['Content-type'=>'application/json;charset=utf-8'],JSON_UNESCAPED_UNICODE);
            }
            foreach($tmp as $o) {
                $tmparr[]= $o->cat_id;
            }
            //去表中查找真正数据
            $result = DB::table('anchong_goods_type')->whereIn('cat_id',$tmparr)->get(['gid','title','price','sname','pic','vip_price','goods_id']);
            $result['showprice']=0;
            Cache::add($prefix.$q,$result,60);
        }
        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$result]);
    }
}
