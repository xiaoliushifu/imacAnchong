<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Orderinfo;
use Gate;

class orderinfoController extends Controller
{
    private $orderinfo;
    public function __construct()
    {
        $this->orderinfo=new Orderinfo();
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function orderdetail(Request $request)
    {
        if (Gate::denies('order-ship')) {
            //因作为ajax返回，返回空对象
            return '{}';
        }
        //创建ORM模型
        $orderinfo=new \App\Orderinfo();
        //定义查询数据
        $orderinfo_data=['order_num','goods_name','goods_num','goods_price','goods_type','goods_numbering','model','oem'];
        //根据订单号查到该订单的详细数据
        $datas=$orderinfo->quer($orderinfo_data,'order_num ='.$request->num)->toArray();
        return $datas;
    }
}
