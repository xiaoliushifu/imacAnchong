<?php

namespace App\Http\Controllers\Api\Goods;

//use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Request;
use Validator;
use DB;
use Illuminate\Support\Collection;
/*
*   该控制器包含了商品模块的操作
*/
class GoodsController extends Controller
{
    /*
    *   商品发布
    */
    public function goodsrelease(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //验证用户传过来的数据是否合法
        $validator = Validator::make($param,
            [
                'sid' => 'required',
                'title' => 'required|max:66',
                'sname' => 'required',
                'desc' => 'required',
                'cat_id' => 'required',
                'spec' => 'array',
            ]
        );
        if ($validator->fails())
        {
            return response()->json(['serverTime'=>time(),'ServerNo'=>8,'ResultData'=>['Message'=>'请填写完整的商品内容！']]);
        }else{
            $goods_data=[
                'title' => $param['title'],
                'desc' =>$param['desc']
            ];

            //开启事务处理
            DB::beginTransaction();
            $goods=new \App\Goods();
            //插入商品表数据
            $goods_id=$goods->add($goods_data);
            //假如插入成功
            if(!empty($goods_id)){
                foreach ($param['spec'] as $spec) {
                    $goods_specifications_data=[
                        "goods_name"=> $spec['goods_name'],
                        "market_price"=> $spec['market_price'],
                        "goods_price"=> $spec['goods_price'],
                        "vip_price"=> $spec['vip_price'],
                        "goods_num"=> $spec['goods_num'],
                        "sid" => $param['sid'],
                        'goods_id' => $goods_id,
                        'cat_id' => $param['cat_id'],
                        'pic' => $spec['pic'],
                        'parameter' => $spec['parameter'],
                        'data' => $spec['data'],
                        'goods_img' => $spec['img'][0],
                    ];
                    $goods_specifications=new \App\Goods_specifications();
                    $goods_specifications_id=$goods_specifications->add($goods_specifications_data);
                    if(!empty($goods_specifications_id)){
                        $goods_type_data=[
                            'gid' => $goods_specifications_id,
                            'title' => $param['titless'].' '.$spec['goods_name'],
                            'price' => $spec['market_price'],
                            'sname' => $param['sname'],
                            'vip_price'=>$spec['vip_price'],
                            'cid' => $param['cat_id'],
                            'created_at' => date('Y-m-d H:i:s',$data['time']),
                            'pic' => $spec['img'][0],
                        ];
                        $goods_type=new \App\Goods_type();
                        $goods_type_result=$goods_type->add($goods_type_data);
                        if($goods_type_result){
                            foreach ($spec['img'] as $pic) {
                                $pic_data=[
                                    'gid'=> $goods_specifications_id,
                                    'img_url'=> $pic,
                                ];
                                $goods_thumb=new \App\Goods_thumb();
                                $result=$goods_thumb->add($pic_data);
                            }
                        }else{
                            //加入失败就回滚
                            DB::rollback();
                            return response()->json(['serverTime'=>time(),'ServerNo'=>8,'ResultData'=>['Message'=>'添加商品失败，请重新添加']]);
                        }
                    }else{
                        //加入失败就回滚
                        DB::rollback();
                        return response()->json(['serverTime'=>time(),'ServerNo'=>8,'ResultData'=>['Message'=>'添加商品失败，请重新添加']]);
                    }
                }
                if($result){
                    //假如成功就提交
                    DB::commit();
                    return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'添加商品成功']]);
                }else{
                    //加入失败就回滚
                    DB::rollback();
                    return response()->json(['serverTime'=>time(),'ServerNo'=>8,'ResultData'=>['Message'=>'添加商品失败，请重新添加']]);
                }
            }else{
                //加入失败就回滚
                DB::rollback();
                return response()->json(['serverTime'=>time(),'ServerNo'=>8,'ResultData'=>['Message'=>'添加商品失败，请重新添加']]);
            }
        }
    }

    /*
    *   商品列表查看
    */
    public function goodslist(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //默认每页数量
        $limit=20;
        //创建ORM模型
        $goods_type=new \App\Goods_type();
        //需要查的字段
        $goods_data=['gid','title','price','sname','pic','vip_price'];
        //查询商品列表的信息
        $result=$goods_type->quer($goods_data,'cid = '.$param['cid'],(($param['page']-1)*$limit),$limit);
        //将结果转成数组
        $results=$result['list']->toArray();
        //判断是否取出结果
        if(!empty($results)){
            //判断是否有权限查看会员价，也就是判断是否审核通过
            $showprice=0;
            if($data['guid'] == 0){
                $showprice=0;
            }else{
                $users=new \App\Users();
                $users_auth=$users->quer('certification',['users_id'=>$data['guid']])->toArray();
                if($users_auth[0]['certification'] == 3){
                    $showprice=1;
                }
            }
            $result['showprice']=$showprice;
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$result]);
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>10,'ResultData'=>['Message'=>'商品信息获取失败，请刷新']]);
        }
    }

    /*
    *   商品详细信息
    */
    public function goodsinfo(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //创建ORM模型
        $goods_specifications=new \App\Goods_specifications();
        $goods_thumb=new \App\Goods_thumb();
        //需要查的字段
        $goods_data=['goods_id','goods_name','sid','pic','parameter','data'];
        //查询商品列表的信息
        $picresult=$goods_thumb->quer('img_url','gid = '.$param['gid'])->toArray();
        $results=$goods_specifications->quer($goods_data,'gid = '.$param['gid'])->toArray();
        $picarr=null;
        foreach ($picresult as $pic1) {
            foreach ($pic1 as $pic2) {
                $picarr[]=$pic2;
            }
        }
        $result=null;
        if(!empty($results) && !empty($picarr)){
            $shopid=$results[0]['sid'];
            $shop=new \App\Shop();
            $shopresult=$shop->quer(['name','img'],'sid = '.$shopid)->toArray();
            foreach ($results as $goods1) {
                foreach ($goods1 as $key=>$goods2) {
                    $result[$key]=$goods2;
                }
            }
            foreach ($shopresult as $shop1) {
                foreach ($shop1 as $key=>$shop2) {
                    $result[$key]=$shop2;
                }
            }
            $result['goodspic']=$picarr;
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$result]);
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>10,'ResultData'=>['Message'=>'商品信息获取失败，请刷新']]);
        }
    }

    /*
    *   商品规格信息
    */
    public function goodsformat(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //创建ORM模型
        $goods_specifications=new \App\Goods_specifications();
        $goods=new \App\Goods();
        //查询商品名称
        $title=$goods->quer('title','goods_id ='.$param['goods_id'])->toArray();
        $goods_data=['gid','goods_img','goods_price','vip_price','goods_name'];
        //查询商品类别
        $result=$goods_specifications->quer($goods_data,'goods_id = '.$param['goods_id'])->toArray();
        $results=null;
        foreach ($result as $result1) {
            $result1['title']=$title[0]['title'];
            $results[]=$result1;
        }
        if(!empty($results) && !empty($title)){
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$results]);
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>10,'ResultData'=>['Message'=>'规格信息获取失败，请刷新']]);
        }
    }
}
