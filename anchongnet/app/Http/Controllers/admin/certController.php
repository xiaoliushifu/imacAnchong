<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Auth;
use App\Qua;
use App\Http\Controllers\Controller;

/**
*   该控制器包含了会员认证模块的操作
*/
class certController extends Controller
{
	private $qua;
    /**
     * Display a listing of the resource.
     *
	 * @param  $request('id'资质ID,'auth_status'认证状态)
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $kId=$req["id"];
		$kStatus=$req["auth_status"];

        if ($kId) {
		    $datas = Auth::Users($kId)->orderBy("id","desc")->paginate(8);
		} elseif ($kStatus) {
			$datas = Auth::Status($kStatus)->orderBy("id","desc")->paginate(8);
		} else {
			$datas=Auth::orderBy("id","desc")->paginate(8);
		}
		$args=array("id"=>$kId,"auth_status"=>$kStatus);
		return view('admin/users/cert',array("datacol"=>compact("args","datas")));
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
     * @param  int  $id认证ID
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
	   return Qua::Ids($id)->get();
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
     * @param  $request('','','','','')
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
