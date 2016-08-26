<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Request as Requester;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Shop;
use App\Mainbrand;
use App\ShopCat;
use Gate;

class shopController extends Controller
{
    private $shop;
    private $mb;
    private $shopcat;

    /**
     * shopController constructor.
     * @param $shop
     */
    public function __construct()
    {
        $this->shop = new Shop();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keyName=Requester::input("name");
        $keyAudit=Requester::input("audit");

        if ($keyName=="" && $keyAudit=="") {
            $datas=$this->shop->orderBy("sid","desc")->paginate(8);
        } elseif (empty($keyAudit)) {
            $datas = Shop::Name($keyName)->orderBy("sid","desc")->paginate(8);
        } elseif (empty($keyName)) {
            $datas = Shop::Audit($keyAudit)->orderBy("sid","desc")->paginate(8);
        } else {
            $datas = Shop::Name($keyName)->Audit($keyAudit)->orderBy("sid","desc")->paginate(8);
        }
        $args=array("name"=>$keyName,"audit"=>$keyAudit);
        return view('admin/shop/index',array("datacol"=>compact("args","datas")));
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
        //
    }

    /*
     * 根据店铺id获取店铺的主营品牌
     * */
    public function getbrand(Request $request)
    {
        $this->mb=new Mainbrand();
        $sid=$request['sid'];
        $datas=$this->mb->Shop($sid)->get();
        return $datas;
    }

    /*
     * 根据店铺id查找店铺的主营类别
     * */
    public function getcat(Request $request)
    {
        $this->shopcat=new ShopCat();
        $sid=$request['sid'];
        $datas=$this->shopcat->Shop($sid)->get();
        return $datas;
    }

    /*
    *   修改店铺状态
    */
    public function shopstate(Request $request)
    {
        //商铺开关的权限判定
        if (Gate::denies('shop-toggle')) {
            return 'unauthorized';
        }
        //得到操作商铺的句柄
        $data=$this->shop->find($request->sid);
        //改变商铺状态
        $data->audit=$request->state;
        //保存
        $data->save();
        return "操作成功";
    }
}
