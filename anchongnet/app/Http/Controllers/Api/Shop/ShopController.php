<?php

namespace App\Http\Controllers\Api\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Shop;
use App\Brand;
use App\ShopCat;
use DB;

class ShopController extends Controller
{
    private $shop;
    private $brand;
    private $shopcat;
    /**
     * ShopController constructor.
     */
    public function __construct()
    {
        $this->shop=new Shop();
        $this->brand=new Brand();
        $this->shopcat=new ShopCat();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $uid=$request['guid'];
        $param=json_decode($request['param'],true);
        DB::beginTransaction();
        //图片替换处理
        $urls = str_replace('.oss-','.img-',$param['logo']);
        //想shops表中插入一条记录并返回其id
        $sid = DB::table('anchong_shops')->insertGetId(
            [
                'users_id' => $uid,
                'name'=>$param['name'],
                'introduction'=>$param['introduction'],
                'premises'=>$param['address'],
                'img'=>$urls,
                'created_at'=>$request['time'],
                'audit'=>1,
                'free_price'=>$param['free_price'],
    			    'freight'=>$param['freight'],
    			    'customer'=>$param['customer'],
            ]
        );
        //通过一个for循环向shops_category表中插入数据
        for ($i=0;$i<count($param['cat']);$i++) {
            DB::table('anchong_shops_category')->insert(
                [
                    'sid' => $sid,
                    'cat_id' => $param['cat'][$i],
                ]
            );
        }

        //通过一个for循环向shops_mainbrand表中插入数据
        for ($i=0;$i<count($param['brandId']);$i++) {
            DB::table('anchong_shops_mainbrand')->insert(
                [
                    'sid' => $sid,
                    'brand_id' => $param['brandId'][$i],
                    'authorization'=>$param['brandUrl'][$i],
                ]
            );
        }

        //提交事务
        DB::commit();
        //创建推送的ORM
        $propel=new \App\Http\Controllers\admin\Propel\PropelmesgController();
        //进行推送
        try{
            //推送消息
            $propel->apppropel('13730593861','商铺开通审核','有人提交商铺申请了，快去审核吧');
        }catch (\Exception $e) {
            //返回给客户端数据
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData' => ['Message'=>'申请成功，请等待审核']]);
        }
        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData' => ['Message'=>'申请成功，请等待审核']]);
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
