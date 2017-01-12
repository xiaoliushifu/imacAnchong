<?php

namespace App\Http\Controllers\Api\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Shop;
use App\Brand;
use App\ShopCat;
use DB;
use Validator;

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
        try{
            $uid=$request['guid'];
            $param=json_decode($request['param'],true);
            DB::beginTransaction();
            //验证用户传过来的数据是否合法
            $validator = Validator::make($param,
                [
                    'logo' => 'required',
                    'name' => 'required',
                    'introduction' => 'required',
                    'address' => 'required',
                    'free_price' => 'required',
                    'freight' => 'required',
                    "first" => "required",
                    "additional" => "required",
                    'customer' => 'required',
                    'cat' => 'required',
                    'catName' => 'required',
                    'brandId' => 'required',
                    'brandName' => 'required',
                    'brandUrl' => 'required',
                ]
            );
            //如果出错返回出错信息，如果正确执行下面的操作
            if ($validator->fails()) {
                $messages = $validator->errors();
                if ($messages->has('logo')) {
        				//如果验证失败,返回验证失败的信息
        			    return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'商铺头像不能为空']]);
        			} elseif ($messages->has('name')) {
        				return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'商铺名称不能为空']]);
        			} elseif ($messages->has('introduction')) {
        				return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'商铺介绍不能为空']]);
        			}elseif ($messages->has('address')) {
        				return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'商铺经营地点不能为空']]);
        			}elseif ($messages->has('free_price')) {
        				return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'商铺免运费额度不能为空']]);
        			}elseif ($messages->has('freight')) {
        				return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'运费不能为空']]);
                    }elseif ($messages->has('first')) {
        				return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'首重不能为空']]);
                    }elseif ($messages->has('additional')) {
        				return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'续重费用不能为空']]);
        			}elseif ($messages->has('customer')) {
        				return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'商铺联系电话不能为空']]);
        			}elseif ($messages->has('cat')) {
        				return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'请重新选择主营类别']]);
        			}elseif ($messages->has('catName')) {
        				return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'主营类别不能为空']]);
        			}elseif ($messages->has('brandId')) {
        				return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'请重新选择对应的主营品牌并上传头像']]);
        			}elseif ($messages->has('brandName')) {
        				return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'主营品牌不能为空']]);
        			}elseif ($messages->has('brandUrl'))  {
                        return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'品牌授权书需要对应你的主营品牌上传']]);
                }
            }
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
                    'first'=>$param['first'],
        			'additional'=>$param['additional'],
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
                $propel->apppropel('18631767471','商铺开通审核','有人提交商铺申请了，快去审核吧');
            }catch (\Exception $e) {
                //返回给客户端数据
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData' => ['Message'=>'申请成功，请等待审核']]);
            }
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData' => ['Message'=>'申请成功，请等待审核']]);
        }catch (\Exception $e) {
            $uid=$request['guid'];
            $param=json_decode($request['param'],true);
            DB::beginTransaction();
            //验证用户传过来的数据是否合法
            $validator = Validator::make($param,
                [
                    'logo' => 'required',
                    'name' => 'required',
                    'introduction' => 'required',
                    'address' => 'required',
                    'free_price' => 'required',
                    'freight' => 'required',
                    'customer' => 'required',
                    'cat' => 'required',
                    'catName' => 'required',
                    'brandId' => 'required',
                    'brandName' => 'required',
                    'brandUrl' => 'required',
                ]
            );
            //如果出错返回出错信息，如果正确执行下面的操作
            if ($validator->fails()) {
                $messages = $validator->errors();
                if ($messages->has('logo')) {
        				//如果验证失败,返回验证失败的信息
        			    return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'商铺头像不能为空']]);
        			} elseif ($messages->has('name')) {
        				return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'商铺名称不能为空']]);
        			} elseif ($messages->has('introduction')) {
        				return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'商铺介绍不能为空']]);
        			}elseif ($messages->has('address')) {
        				return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'商铺经营地点不能为空']]);
        			}elseif ($messages->has('free_price')) {
        				return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'商铺免运费额度不能为空']]);
        			}elseif ($messages->has('freight')) {
        				return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'运费不能为空']]);
                    }elseif ($messages->has('customer')) {
        				return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'商铺联系电话不能为空']]);
        			}elseif ($messages->has('cat')) {
        				return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'请重新选择主营类别']]);
        			}elseif ($messages->has('catName')) {
        				return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'主营类别不能为空']]);
        			}elseif ($messages->has('brandId')) {
        				return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'请重新选择对应的主营品牌并上传头像']]);
        			}elseif ($messages->has('brandName')) {
        				return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'主营品牌不能为空']]);
        			}elseif ($messages->has('brandUrl'))  {
                        return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'品牌授权书需要对应你的主营品牌上传']]);
                }
            }
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
                $propel->apppropel('18631767471','商铺开通审核','有人提交商铺申请了，快去审核吧');
            }catch (\Exception $e) {
                //返回给客户端数据
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData' => ['Message'=>'申请成功，请等待审核']]);
            }
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData' => ['Message'=>'申请成功，请等待审核']]);
            // return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'请完善所有信息']]);
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
