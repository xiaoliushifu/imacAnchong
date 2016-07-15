<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Shop;
use DB;
use Gate;

class checkShopController extends Controller
{
    private $shop;

    /**
     * checkShopController constructor.
     * @param $shop
     */
    public function __construct()
    {
        $this->shop = new Shop();
    }
    /*
     * 商铺审核方法
     * */
    public function index(Request $request)
    {
        //是否有 “审核商铺"   权限
        if (Gate::denies('shop-check')) {
            return 'unauthorized';
        }
        $sid=$request['sid'];
        if ($request['certified']=="yes") {
            DB::table('anchong_shops')->where('sid', $sid)->update(['audit' => 2]);
        }else{
            DB::table('anchong_shops')->where('sid', $sid)->delete();
        };

        return "设置成功";
    }
}
