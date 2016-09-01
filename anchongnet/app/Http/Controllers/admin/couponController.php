<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Auth;
class couponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $this->auth = new Auth();
        $keyId = $req->get("id");
        $keyStatus=$req->get("auth_status");
        if ($keyId=="" && $keyStatus=="") {
            $datas=$this->auth->orderBy("auth_status","asc")->orderBy("id","desc")->paginate(8);
        } elseif (empty($keyStatus)) {
            $datas = Auth::Users($keyId)->orderBy("id","desc")->paginate(8);
        } elseif (empty($keyId)) {
            $datas = Auth::Status($keyStatus)->orderBy("auth_status","asc")->orderBy("id","desc")->paginate(8);
        } else {
            $datas = Auth::Users($keyId)->Status($keyStatus)->orderBy("id","desc")->paginate(8);
        }
        $args=array("id"=>$keyId,"auth_status"=>$keyStatus);
        return view('admin/coupon/index',array("datacol"=>compact("args","datas")));
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
