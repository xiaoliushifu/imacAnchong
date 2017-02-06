<?php

namespace App\Http\Controllers\admin;

use \Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

/**
*   该控制器操作后台虫豆模块
*/
class BeansController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas=DB::table('anchong_beans_recharge')->get();
        return view('admin/beans/index',["datacol"=>compact("datas")]);
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
     * @param  $request('','','','','')
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
     * @param  $request('beans'虫豆数量,'money'金额)
     * @param  int  $id虫豆注册表ID主键
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //判断是否是更新
        if($id != 0){
            $result=DB::table('anchong_beans_recharge')->where('beans_id',$id)->update(['beans'=>$request->beans,'money'=>$request->money]);
            if($result){
                return "修改成功";
            }else {
                return "修改失败";
            }
        }else{
            $id = DB::table('anchong_beans_recharge')->insertGetId(
                [
                    'beans'=>$request->beans,
                    'money'=>$request->money
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
     * @param  int  $id虫豆注册表ID主键
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //根据ID进行删除
        $result=DB::table('anchong_beans_recharge')->where('beans_id',$id)->delete();
        if($result){
            return "删除成功";
        }else{
            return "删除失败";
        }
    }
}
