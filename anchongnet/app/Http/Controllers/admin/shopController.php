<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Request as Requester;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Shop;

class shopController extends Controller
{
    private $shop;

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

        if($keyName=="" && $keyAudit==""){
            $datas=$this->shop->paginate(8);
        }else if(empty($keyAudit)){
            $datas = Shop::Name($keyName)->paginate(8);
        }else if(empty($keyName)){
            $datas = Shop::Audit($keyAudit)->paginate(8);
        }else{
            $datas = Shop::Name($keyName)->Audit($keyAudit)->paginate(8);
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
}
