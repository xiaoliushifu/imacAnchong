<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Request;
use DB;
use Cache;


/**
*
*   搜索智能提示，前缀搜索匹配
*/
class SearchController extends Controller
{
    /**
     * for 手持设备
     * @param Request $req
     */
    public function postIndex(Request $req)
    {
        $data=$req::all();
        $param=json_decode($data['param'],true);
        $q = $param['q'];
        if (!$q) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>10,'ResultData'=>['Message'=>'请输入查找的内容']]);
        }
        $prefix='suggestion';
        if (!$result = Cache::get($prefix.$q)) {
            //返回数组，但其元素是对象
            //DB::connection()->enableQueryLog();
            $tmp=DB::table('anchong_goods_suggestion')->select('str')->where("str", "like", "$q%")->skip(0)->take(6)->orderBy('qnums','DESC')->get();
            //$queries = DB::getQueryLog();
            if (!$tmp) {
                return response()->json(['serverTime'=>time(),'ServerNo'=>10,'ResultData'=>['Message'=>'']]);
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

    /**
     * 后端搜索页
     */
    public function getPage()
    {
        return view('admin/permission/s',['res'=>[],'hex'=>'','ori'=>'']);
    }

    /**
     * 搜索转接，直接去搜索而无智能提示
     */
    public function postKey(Request $req)
    {
        //dump($req::all());
        //组装req
        $req::offsetSet('guid',0);
        $req::offsetSet('param','{"search":"'.$req::input('q').'"}');
        $at = preg_split('#\s#',$req::input('q'),-1,PREG_SPLIT_NO_EMPTY);
        foreach ($at as $k=>$v) {
            $kl = strlen($v);
            if ($kl < 2 || $kl > 84) {
                unset($at[$k]);
            }
        }
        $ori = implode(' ',$at);
        $hex = bin2hex($ori);
        Cache::tags('s')->forget('search@'.$hex);
        $res = Goods\GoodsController::goodssearch($req);
        $res = $res->getData(true);
        if ($res['ServerNo'] != 0) {
            return view('admin/permission/s',['res'=>[],'ori'=>$ori,'hex'=>$hex.'---无结果']);
        }
        //var_dump($res->getData(true)['ResultData']);
        return view('admin/permission/s',['res'=>$res['ResultData']['list'],'ori'=>$ori,'hex'=>$hex]);
    }

    /**
     * 标签方式，清除有关商品搜索的全部缓存（需要驱动支持）
     */
    public function postDel()
    {
        return Cache::tags('s')->flush();
    }
}
