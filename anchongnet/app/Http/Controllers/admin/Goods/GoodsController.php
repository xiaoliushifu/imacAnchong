<?php

namespace App\Http\Controllers\admin\Goods;

use DB;
use Request;
use App\Http\Controllers\Controller;
use Gate;

/*
*   后台操作商品
*/
class GoodsController extends Controller
{
    /*
    *   货品删除
    */
    public function goodsdel(Request $request)
    {
        //只客服可以删除货品
        if (Gate::denies('del-good')) {
            return back();
        }
        //获得app端传过来的json格式的数据转换成数组格式
        $param=$request::all();
        //创建ORM模型
        $goods_specifications=new \App\Goods_specifications();
        $goods_type=new \App\Goods_type();
        $goods_thumb=new \App\Goods_thumb();
        $stock=new \App\Stock();
        //开启事务处理
        DB::beginTransaction();
        //删除货品表的数据
        $specresult=$goods_specifications->del($param['gid']);
        if($specresult){
            //删除goods_type表的数据
            $typeresult=$goods_type->del($param['gid']);
            if($typeresult){
                //删除该货品的主图
                $thumbresult=$goods_thumb->del($param['gid']);
                if($thumbresult){
                    $stockresult=$stock->del($param['gid']);
                    if($stockresult){
                        //假如成功就提交
                        DB::commit();
                        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'删除成功']]);
                    }else{
                        //假如失败就回滚
                        DB::rollback();
                        return response()->json(['serverTime'=>time(),'ServerNo'=>14,'ResultData'=>['Message'=>'商品删除失败']]);
                        }
                }else{
                    //假如失败就回滚
                    DB::rollback();
                    return response()->json(['serverTime'=>time(),'ServerNo'=>14,'ResultData'=>['Message'=>'商品删除失败']]);
                    }
            }else{
                //假如失败就回滚
                DB::rollback();
                return response()->json(['serverTime'=>time(),'ServerNo'=>14,'ResultData'=>['Message'=>'商品删除失败']]);
            }
        }else{
            //假如失败就回滚
            DB::rollback();
            return response()->json(['serverTime'=>time(),'ServerNo'=>14,'ResultData'=>['Message'=>'商品删除失败']]);
        }
    }
}
