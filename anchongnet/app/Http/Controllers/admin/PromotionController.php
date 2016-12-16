<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Cache;
use DB;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas=DB::table('anchong_promotion')->get();
        return view('admin/promotion/index',["datacol"=>compact("datas")]);
    }

    /*
    *   到点促销开启
    */
    public static function promotion($id)
    {
        //判断是否有时间缓存
        if (Cache::has('anchong_promotion_time'))
        {
            //删除缓存
            Cache::forget('anchong_promotion_time');
        }
        
        //判断是否有促销缓存
        if (Cache::has('anchong_promotion_goods'))
        {
            //删除缓存
            Cache::forget('anchong_promotion_goods');
        }
        //取到当前时间，为了避免时间不准时加十秒
        $nowtime=time()+10;
        //查出促销时间段的商品
        $goods_data=DB::table('anchong_promotion_goods')->where('promotion_id',$id)->select('gid','promotion_price')->orderBy('sort','DESC')->get();
        //定义ORM模型
        $goods_specifications=new \App\Goods_specifications();
        //定义结果数组
        $results=[];
        //遍历数据并组合成新数据
        foreach ($goods_data as $goodsinfo) {
            //获得该货物信息的句柄
            $goods_handle=$goods_specifications->find($goodsinfo->gid);
            //修改其促销价
            $goods_handle->promotion_price=$goodsinfo->promotion_price;
            $save=$goods_handle->save();
            //如果修改成功就促销该货品
            if($save){
                //将内容装入结果数组
                $results[]=[
                            "gid" => $goods_handle->gid,
                            "title" => $goods_handle->title,
                            "price" => $goods_handle->market_price,
                            "sname" => $goods_handle->sname,
                            "pic" => $goods_handle->goods_img,
                            "promotion_price" => $goodsinfo->promotion_price,
                            "goods_id" => $goods_handle->goods_id
                          ];
            }
        }
        //如果结果不为空则永久保存
        if($results){
            Cache::forever('anchong_promotion_goods',$results);
        }
    }

    /*
    *   过点关闭上一波促销
    */
    public static function endpromotion($id)
    {
        //取到当前时间，为了避免时间不准时加十秒
        $nowtime=time()+10;
        //查出促销时间段的商品
        $goods_data=DB::table('anchong_promotion_goods')->where('promotion_id',$id)->select('pg_id','gid')->orderBy('sort','DESC')->get();
        //定义ORM模型
        $goods_specifications=new \App\Goods_specifications();
        //遍历数据并组合成新数据
        foreach ($goods_data as $goodsinfo) {
            //获得该货物信息的句柄
            $goods_handle=$goods_specifications->find($goodsinfo->gid);
            //修改其促销价
            $goods_handle->promotion_price=0;
            $save=$goods_handle->save();
            //如果修改成功就促销该货品
            if($save){
                DB::table('anchong_promotion_goods')->where('pg_id',$goodsinfo->pg_id)->delete();
            }
        }
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
     * 用于把实际的货品加入到促销列表
     * 将来促销计划启动时，促销列表生效
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!isset($request->promotion_id) || empty($request->promotion_id)) {
            return response()->json(['serverTime'=>1,'ServerNo'=>1,'ResultData'=>['Message'=>'暂无促销计划']]);
        }
        $num=DB::table('anchong_promotion_goods')->where('promotion_id', $request->promotion_id)->count();
        //判断是否达到该次促销数量的上限
        if($num > 19){
            return response()->json(['serverTime'=>time(),'ServerNo'=>19,'ResultData'=>['Message'=>'该时段的促销商品已达上限']]);
        }
        //将数据插入数据库
        $result=DB::table('anchong_promotion_goods')->insert(
            [
                'promotion_id' => $request->promotion_id,
                'gid' => $request->gid,
                'promotion_price' => $request->promotion_price,
                'sort' => $request->sort,
                'goods_numbering' => $request->goodsnum
            ]
        );
        //判断是否插入成功
        if($result){
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'添加成功']]);
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>19,'ResultData'=>['Message'=>'添加失败']]);
        }
    }

    /**
     * 用于获得促销时间段（未来）
     * 促销中，或过期的不可再操作
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $nowtime=time();
        $data=[];
        //获取促销时间数据
        $datas=DB::table('anchong_promotion')->select('promotion_id','start_time','end_time')->where('start_time','>',$nowtime)->take(5)->get();
        //将unix时间戳转成日期
        foreach ($datas as $value) {
            $data[]=['promotion_id'=>$value->promotion_id,'start_time'=>date("Y-m-d H:i:s",$value->start_time),'end_time'=>date("Y-m-d H:i:s",$value->end_time)];
        }
        return $data;
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
     * 添加或更新一个促销时间段
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //看看促销时间是否冲突
        $num=DB::table('anchong_promotion')->where('end_time','>',strtotime($request->start_time))->count();
        if($num){
            return "促销时间冲突，请检测重试";
        }
        //判断是否是更新
        if($id != 0){
            $result=DB::table('anchong_promotion')->where('promotion_id',$id)->update(['start_time'=>$request->start_time,'end_time'=>$request->end_time]);
            if($result){
                return "修改成功";
            }else {
                return "修改失败";
            }
        }else{
            $id = DB::table('anchong_promotion')->insertGetId(
                [
                    'start_time'=>strtotime($request->start_time),
                    'end_time'=>strtotime($request->end_time)+86399
                ]
            );
            if($id){
                return "添加成功";
            }else {
                return "操作失败";
            }
        }
    }

    /**
     * 清除促销时间段
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $num=DB::table('anchong_promotion_goods')->where('promotion_id',$id)->count();
        if($num){
            return "促销时间未结束，或该时段还有未下架的促销产品(请联系cto)！";
        }
        //根据ID进行删除
        $result=DB::table('anchong_promotion')->where('promotion_id',$id)->delete();
        if($result){
            return "删除成功";
        }else{
            return "删除失败";
        }
    }


}
