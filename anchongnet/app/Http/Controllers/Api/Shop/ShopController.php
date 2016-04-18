<?php

namespace App\Http\Controllers\Api\Shop;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Shop;

class ShopController extends Controller
{
    private $shop;
    /**
     * ShopController constructor.
     */
    public function __construct()
    {
        $this->shop=new Shop();
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->shop->users_id=$request['guid'];
        $this->shop->name =$request['name'];
        $this->shop->mainbrand=$request['mainbrand'];
        $this->shop->authorization =$request['authorization'];
        $this->shop->category =$request['category'];
        $this->shop->introduction =$request['introduction'];
        $this->shop->premises =$request['premises'];
        $this->shop->img =$request['img'];
        $this->shop->audit=1;
        $this->shop->save();
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
