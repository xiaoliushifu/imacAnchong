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
        $goods_data=['goods_name','sid','pic','parameter','data'];
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
}
