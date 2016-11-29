<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class PromotioninfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $promotion_id=$request['promotion_id'];
        //查出该时段的促销数据
        $datas=DB::table('anchong_promotion_goods')->select('pg_id','gid','goods_numbering','promotion_price','sort')->where('promotion_id',$promotion_id)->get();
        return view("admin/promotion/promotioninfo")->with("datas",$datas);
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
        $result=DB::table('anchong_promotion_goods')->where('pg_id',$id)->update(['promotion_price'=>$request->promotion_price,'sort'=>$request->sort]);
        if($result){
            return "修改成功";
        }else{
            return "修改失败";
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
        $result=DB::table('anchong_promotion_goods')->where('pg_id',$id)->delete();
        //判断是否删除成功
        if($result){
            return "删除成功";
        }else{
            return "删除失败";
        }
    }
}
