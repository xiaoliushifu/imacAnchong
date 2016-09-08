<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\GoodSupporting;
use DB;

class goodSupportingController extends Controller
{
    private $gs;
    public function __construct()
    {
        $this->gs=new GoodSupporting();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $id = DB::table('anchong_goods_supporting')->insertGetId(
            [
                'goods_id'=>$request->goodsid,
                'gid'=>$request->gid,
                'title'=>$request->title,
                'price'=>$request->price,
                'img'=>$request->img,
                'assoc_gid'=>$request->agid,
                'goods_name'=>$request->goodsname,
            ]
        );

        return response()->json(['id' => $id,'name'=>$request->goodsname,'message'=>'保存成功']);
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
        $data=$this->gs->find($id);
        $data->delete();
        return "删除成功";
    }
    
    /**
     * 商品编辑页，ajax获得配套商品
     * @param Request $request
     */
    public function getSupcom(Request $request)
    {
        $field=['goods_name','supid'];
        return $this->gs->Good($request->gid)->get($field);
    }
}
