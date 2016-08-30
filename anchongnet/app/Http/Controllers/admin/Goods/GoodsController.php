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
    
    /**
     * 商品及货品的级联删除
     */
    public function delhuobyGoods()
    {
        $id = Request::get('npx');
        \Log::info($id,array('this is goods_id'));
        try{
            //还有更好的办法
            DB::beginTransaction();
            //先删货品相关的
           //找出该商品下的所有货品ID--,
            $gid = DB::table('anchong_goods_specifications')->where('goods_id',$id)->pluck('gid');
            //\Log::info($gid);
                //根据gid删除下列两表
                $res['stock'] = DB::table('anchong_goods_stock')->whereIn('gid',$gid)->delete();
                $res['thumb'] = DB::table('anchong_goods_thumb')->whereIn('gid',$gid)->delete();
                //根据gid找到下表的cat_id
                $cid = DB::table('anchong_goods_type')->whereIn('gid',$gid)->pluck('cat_id');
                //\Log::info($cid);
                    //根据cat_id删除下列表
                    $res['keyword'] = DB::table('anchong_goods_keyword')->whereIn('cat_id',$cid)->delete();
            //深度搜索表
            $res['search'] = DB::table('anchong_goods_search')->where('goods_id',$id)->delete();
            $res['specifi'] = DB::table('anchong_goods_specifications')->where('goods_id',$id)->delete();
            
            //再删商品相关的
            $res['goods'] = DB::table('anchong_goods')->where('goods_id',$id)->delete();
            $res['oem'] = DB::table('anchong_goods_oem')->where('goods_id',$id)->delete();
            $res['attr'] = DB::table('anchong_goods_attribute')->where('goods_id',$id)->delete();
            $res['supp'] = DB::table('anchong_goods_supporting')->where('assoc_gid',$id)->delete();
            //\Log::info($res,array('this is shangpin'));
            DB::commit();
            return '删除商品成功';
        } catch (Exception $e) {
            return '商品删除有误';
        }
    }
}
