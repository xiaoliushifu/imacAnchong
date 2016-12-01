<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Shop;
use App\Mainbrand;
use App\ShopCat;
use Gate;
use DB;

/**
*   该控制器包含了商铺模块的操作
*/
class shopController extends Controller
{
    private $shop;
    private $mb;
    private $shopcat;

    /**
     * shopController constructor.
     * @param $shop
     */
    public function __construct()
    {
        $this->shop = new Shop();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex(Request $req)
    {
        $kName=$req["name"];
        $kAudit=$req["audit"];

        if ($kName) {
            $datas = Shop::Name($kName)->orderBy("sid","desc")->paginate(8);
        } elseif ($kAudit) {
            $datas = Shop::Audit($kAudit)->orderBy("sid","desc")->paginate(8);
        } else {
            $datas=$this->shop->orderBy("sid","desc")->paginate(8);
        }
        $args=array("audit"=>$kAudit);
        return view('admin/shop/index',array("datacol"=>compact("args","datas")));
    }

    /**
     * 根据店铺id获取店铺的主营品牌及类别
     *
     * @param  $request('sid'商铺ID)
     * @return \Illuminate\Http\Response
     */
    public function getShopbc(Request $req)
    {
        $this->mb=new Mainbrand();
        $this->shopcat=new ShopCat();
        $sid=$req['sid'];
        $datas['brand'] = $this->mb->Shop($sid)->get();
        $datas['cat'] = $this->shopcat->Shop($sid)->get();
        return $datas;
    }

    /**
    *   修改店铺状态
    *待审，审核通过，已关闭，不通过直接删除
    * @param  $request('sid'商铺ID)
    * @return \Illuminate\Http\Response
    */
    public function postState(Request $req)
    {
        //商铺开关的权限判定
        if (Gate::denies('shop-toggle')) {
            return 'unauthorized';
        }
        //得到操作商铺的句柄
        $data=$this->shop->find($req['sid']);
        if($data->audit == 1){
            return '商铺正在审核中';
        }
        //改变商铺状态
        $data->audit=$req['state'];
        //保存
        $data->save();
        return "成功";
    }

    /**
     * 商铺审核方法
     *
     * @param  $request('sid'商铺ID)
     * @return \Illuminate\Http\Response
     */
    public function getCheck(Request $req)
    {
        //是否有 “审核商铺"   权限
        if (Gate::denies('shop-check')) {
            return 'unauthorized';
        }
        $sid=$req['sid'];
        //查出用户的手机号
        $users_id=DB::table('anchong_shops')->where('sid',$sid)->pluck('users_id');
        $phone=DB::table('anchong_users')->where('users_id',$users_id[0])->pluck('phone');
        if ($req['act']=="pass") {
            DB::table('anchong_shops')->where('sid', $sid)->update(['audit' => 2]);
            DB::table('anchong_users')->where('users_id', $req['users_id'])->update(['sid' => $sid]);
            $mes='您提交的商铺申请已经审核通过，快去体验新功能吧';
        } elseif($req['act']=="selfpass") {
            DB::table('anchong_shops')->where('sid', $sid)->update(['audit' => 2,'acself' => 1]);
            DB::table('anchong_users')->where('users_id', $req['users_id'])->update(['sid' => $sid]);
            $mes='您提交的商铺申请已经审核通过安虫自营商铺，快去体验新功能吧';
        } else {
            DB::table('anchong_shops')->where('sid', $sid)->delete();
            DB::table('anchong_shops_mainbrand')->where('sid', $sid)->delete();
            DB::table('anchong_shops_category')->where('sid', $sid)->delete();
            $mes='您提交的商铺申请未通过审核，请重新提交';
        };
        //创建推送的ORM
        $propel=new \App\Http\Controllers\admin\Propel\PropelmesgController();
        //进行推送
        try{
            //推送消息
            $propel->apppropel($phone[0],'商铺申请进度',$mes);
        }catch (\Exception $e) {
            //return "设置成功";
        }
        return $mes;
    }
}
