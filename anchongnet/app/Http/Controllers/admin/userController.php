<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Request as Requester;
use App\Users;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;

class userController extends Controller
{
	private $user;
	public function __construct(){
		$this->user=new Users();
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$keyPhone=Requester::input("phone");
		$keyLevel=Requester::input("users_rank");

        if($keyPhone=="" && $keyLevel==""){
		    $datas=$this->user->orderBy("users_id","desc")->paginate(8);
		}else if(empty($keyLevel)){
			$datas = Users::Phone($keyPhone)->orderBy("users_id","desc")->paginate(8);
		}else if(empty($keyPhone)){
			$datas = Users::Level($keyLevel)->orderBy("users_id","desc")->paginate(8);
		}else{
			$datas = Users::Phone($keyPhone)->Level($keyLevel)->orderBy("users_id","desc")->paginate(8);
		}
		$args=array("phone"=>$keyPhone,"users_rank"=>$keyLevel);
		return view('admin/users/index',array("datacol"=>compact("args","datas")));
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
