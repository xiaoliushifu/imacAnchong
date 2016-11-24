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
    public static function promotion()
    {
        //判断是否有促销缓存
        if (Cache::has('anchong_promotion_goods'))
        {
            //删除缓存
            Cache::forget('anchong_promotion_goods');
        }
        //取到当前时间，为了避免时间不准时加十秒
        $nowtime=time()+10;
        //查出当前促销时间段
        $promotion_id=DB::table('anchong_promotion')->where('start_time','<',$nowtime)->where('end_time','>',$nowtime)->pluck('promotion_id');
        //查出促销时间段的商品
        $goods_data=DB::table('anchong_promotion_goods')->where('promotion_id',$promotion_id[0])->select('gid','promotion_price')->orderBy('sort','DESC')->get();
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
        //
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
        //看看促销时间是否冲突
        $num=DB::table('anchong_promotion')->where('end_time','>',strtotime($request->start_time))->count();
        if($num){
            return "促销时间冲突，请检测重试";
        }
        $result=DB::table('anchong_promotion')->where('promotion_id',$id)->update(['start_time'=>$request->start_time,'end_time'=>$request->end_time]);
        if($result){
            return "修改成功";
        }else{
            $id = DB::table('anchong_promotion')->insertGetId(
                [
                    'promotion_id'=>$id,
                    'start_time'=>strtotime($request->start_time),
                    'end_time'=>strtotime($request->end_time)+86399
                ]
            );
            if($id){
                return "修改成功";
            }else {
                return "修改失败";
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //根据ID进行删除
        $result=DB::table('anchong_promotion')->where('promotion_id',$id)->delete();
        if($result){
            return "删除成功";
        }else{
            return "删除失败";
        }
    }


}
