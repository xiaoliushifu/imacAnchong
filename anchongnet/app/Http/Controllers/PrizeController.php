<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class PrizeController extends Controller
{
    /**
     * 给个抽奖页面
     */
    public function getP1()
    {
        return view('admin.users.p1');
    }
    
    /**
     * 查看中奖用户页面
     */
    public function getP2()
    {
        return view('admin.users.p2');
    }
    /**
     * 获取原始名单
     */
    public function getIndex() 
    {
        $fieldlist='uid,user,phone';
        $ret=array();
        //名字为空的过滤
        $tmp = DB::select("select $fieldlist from orilist_view where `user` !=''  order by ct desc limit 100 ");
        foreach ($tmp as $o) {
            //已中奖的过滤
            if (!DB::table('anchong_prise_list')->where('uid', $o->uid)->first()) {
                array_push($ret, array($o->uid,$o->user,$o->phone));
            }
        }
        return response()->json($ret);
    }
    
    /**
     * 存储中奖名单
     * @param Request $req
     */
    public function postList(Request $req)
    {
        $get= $req->all();
        //失效上一个名单
        DB::table('anchong_prise_list')->update(['flag'=>'1']);
        foreach($get['a2'] as $val)  {
            if ($val[0]) {
                $value[] = [ 'uid'=>$val[0] , 'plevel'=>$val[1] ];
            }
        }
        $res[]=DB::table("anchong_prise_list")->insert($value);
        return response()->json($res);
    }
    
    /**
     * 获取中奖名单
     * @param Request $req
     */
    public function getList(Request $req)
    {
        $res = DB::select("select ol.user,ol.phone,pl.plevel from anchong_prise_list pl,orilist_view ol where ol.uid=pl.uid and pl.flag=0");
        return response()->json($res);
    }
    
}
