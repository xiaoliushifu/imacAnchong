<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Coupon_pool;
use DB;
use Cache;

/**
*   该控制器包含了优惠券模块的操作
*/
class couponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $this->cp = new Coupon_pool();
        $data = $this->cp->backfilter($req);
        $args=$data['where'];
        $datas = $data['data'];
        return view('admin/coupon/index',array("datacol"=>compact("args","datas")));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //获得认证通过的商铺列表
        $datas = Cache::remember('shop_audit_2',100,function(){
                        return  \App\Shop::Audit(2)->get(['sid','name'])->toArray();
                      });
        return view('admin/coupon/create',['opdata'=>$datas,'endline'=>time()+86400*10]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request('shop'使用范围,'title'标题,'target'使用条件,'cvalue'面值,'beans'兑换虫豆,'type'使用小范围,'type2'精确到商品或商铺的范围,'endline'过期时间)
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        $messages = [
            'cvalue.integer' => '面额值得输入整数吧',
            'cvalue.min' => '面额值得大于 :min吧',
            'beans.integer' => '至少得是整数吧',
        ];
        $this->validate($req, [
            'cvalue' => 'integer|min:0',
            'beans' =>'integer|min:0',
        ],$messages);
        //非平台通用
        $tmp=explode('#@#',$req['shop']);
        $req['shop']=$tmp[0];
        $req['title']=$tmp[1];

        $field=array(
            'title'=>$req['title'],
            'target'=>$req['target'],
            'cvalue'=>$req['cvalue'],
            'beans'=>$req['beans'],
            'shop'=>$req['shop'],
            'type'=>$req['type'],
            'type2'=>$req['type2'],
            'endline'=>strtotime($req['endline']),
        );
        try{
            $datas = Cache::remember('shop_audit_2',100,function(){
                        return  \App\Shop::Audit(2)->get(['sid','name'])->toArray();
                      });
            if (DB::table('anchong_coupon_pool')->insert($field)) {
                return  view('admin/coupon/create',array('mes'=>'添加成功','opdata'=>$datas, 'endline'=>time()+86400*10));
            } else {
                return view('admin/coupon/create',array('mes'=>'添加失败'));
            }
        }catch(\Exception $e) {
            exit($e->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $request('cvalue'面值,'beans'兑换虫豆数量,'target'使用条件,'acpid'优惠券ID)
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
            //只更新状态
            if (isset($req['act'])) {
                $arr=array('check-success'=>1,'check-failed'=>0);
                 return DB::table("anchong_coupon_pool")->where('acpid',$req['xid'])->update(['open'=>$arr[$req['act']]]);
            }
            //其他信息更新
            //先验证
            $messages = [
                'cvalue.integer' => '面额值得输入整数吧',
                'cvalue.min' => '面额值不能小于 :min吧',
                'beans.integer' => '虫豆数至少得是整数吧',
                'beans.min' => '虫豆数不能小于 :min吧',
            ];
            $this->validate($req, [
                'cvalue' => 'integer|min:0',
                'beans' =>'integer|min:0',
            ],$messages);
            $field=array('cvalue'=>$req['cvalue'], 'beans'=>$req['beans'], 'target'=>$req['target']);
            if (DB::table("anchong_coupon_pool")->where('acpid',$req['acpid'])->update($field)) {
                return back();
            } else {
                $mes = '更新失败';
            }
            return  $mes;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id优惠券ID
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $req, $id)
    {
        if (isset($req['xid'])) {
            return DB::table("anchong_coupon_pool")->where('acpid',$req['xid'])->delete();
        }
        return 0;
    }

    /**
     *  查询优惠券信息
     *
     * @param  $request('acpid'优惠券ID)
     * @return \Illuminate\Http\Response
     */
    public function couponinfo(Request $request)
    {
        $acpid=$request->acpid;
        $data=DB::table("anchong_coupon_pool")->where('acpid',$acpid)->select('title','cvalue')->get();
        return $data;
    }
}
