<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Stock;
use App\Goods_specifications;
use DB;
use Gate;

/**
*   该控制器包含了区域仓储模块的操作
*/
class stockController extends Controller
{
    private $stock;
    private $Goods_specifications;
    public function __construct()
    {
        $this->stock=new Stock();
        $this->Goods_specifications=new Goods_specifications();
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
     * @param  $request('gid'货品ID,'location'货位号,'regionum'数量)
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //编辑页，新加仓储权限
        if (Gate::denies('stock')) {
            return response()->json(['message' => 'unauthorized']);
        }
        DB::beginTransaction();

        //向库存表插入数据
        $id = DB::table('anchong_goods_stock')->insertGetId(
            [
                'gid' => $request->gid,
                'location'=>$request->location,
                'region_num'=>$request->regionum,
            ]
        );

        //更新商品的总库存
        $this->total($request->gid);

        //提交事务
        DB::commit();

        if($id){
            $message="保存成功";
            $isSuccess=true;
        }else{
            $message="保存失败，请稍后再试";
            $isSuccess=false;
        }
        return response()->json(['message' => $message, 'isSuccess' => $isSuccess,'id'=>$id]);
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
     * @param  $request('location'货位号,'regionum'货品数量)
     * @param  int  $id货品ID
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //更新仓储权限
        if (Gate::denies('stock')) {
            return response()->json(['message' => 'unauthorized']);
        }
        DB::beginTransaction();

        //修改库存信息
        $data=$this->stock->find($id);
        $data->location=$request->location;
        $data->region_num=$request->regionum;
        $result=$data->save();

        //更新商品的总库存
        $this->total($request->gid);

        if($result){
            $message="更新成功";
            $isSuccess=true;
        }else{
            $message="更新失败，请稍后再试";
            $isSuccess=false;
        }
        //提交事务
        DB::commit();
        return response()->json(['message' => $message, 'isSuccess' => $isSuccess]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id库存ID
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //删除库存信息
        $data=$this->stock->find($id);
        $data->delete();
        return "删除成功";
    }

    /**
     * 更新货品的总库存
     *
     * @param  $request('货品ID')
     * @return \Illuminate\Http\Response
     */
    public function getTotal(Request $request)
    {
        $gid=$request->gid;
        $this->total($gid);
    }

    /**
     * 更新指定货品总库存的私有方法
     *
     * @param  int  $id货品ID
     * @return \Illuminate\Http\Response
     */
    private function total($gid)
    {
        $total=0;
        $datas=$this->stock->Good($gid)->get();
        for($i=0;$i<count($datas);$i++){
            $total=$total+$datas[$i]->region_num;
        }
        $good=$this->Goods_specifications->find($gid);
        $good->goods_num=$total;
        $good->save();
    }

    /**
     * 根据条件返回指定库存记录
     *
     * @param  $request('gid'货品ID)
     * @return \Illuminate\Http\Response
     */
    public function getStock(Request $request)
    {
        $data=Stock::Good($request['gid'])->get();
        return $data;
    }
}
