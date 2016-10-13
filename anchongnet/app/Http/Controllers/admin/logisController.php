<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Shops_logistics;
use Gate;
use Cache;

/**
*   该控制器包含了物流模块的操作
*/
class logisController extends Controller
{
    private $logis;
    public function __construct()
    {
        $this->logis=new Shops_logistics();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas=$this->logis->paginate(8);
        return view('admin/shop/index_logis',array("datacol"=>compact("args","datas")));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //暂不提供手动添加，由第三方接口获得
        return back();
        //“添加物流”权限的判定
        if (Gate::denies('logis-add')) {
            return back();
        }
        return view("admin/shop/create_logis");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request('name'物流名)
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\StoreLogisRequest $request)
    {
        return '权限不足';
        //“添加物流”权限的判定
        if (Gate::denies('logis-add')) {
            return back();
        }
        $this->logis->name=$request->name;
        $result=$this->logis->save();
        if($result){
            $mes="保存成功！";
        }else{
            $mes="保存失败，请稍后再试";
        }
        return view("admin/shop/create_logis")->with("mes",$mes);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id物流ID
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data=$this->logis->find($id);
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
     * Update the specified resource in storage.
     *
     * @param  $request('name'物流名)
     * @param  int  $id物流ID
     * @return \Illuminate\Http\Response
     */
    public function update(\App\Http\Requests\StoreLogisRequest $request, $id)
    {
        return '权限不足';
        //"物流" 权限判定
        if (Gate::denies('logis-del')) {
            //特殊处理，不返回back();
            return '权限不足';
        }

        $data=$this->logis->find($id);
        $data->name=$request->name;
        $data->save();

        return response()->json(['mes' => '更新成功']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id物流ID
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return '权限不足';
        //"删除物流" 权限判定
        if (Gate::denies('logis-del')) {
            //特殊处理，不返回back();
            return '权限不足';
        }
        $data=$this->logis->find($id);
        $data->delete();
        return "删除成功";
    }

    /**
    *   获取所有物流的方法
    *
    * @param  无
    * @return \Illuminate\Http\Response
    */
    public function getAll()
    {
        //权限判定
        if (Gate::denies('order-ship')) {
            //特殊处理，不返回back();
            return '{}';
        }
        $obj=$this->logis;
        return Cache::remember('logisall',86400,function()use($obj){
            return $obj->get();
        });
    }
}
