<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Request as Requester;
use App\Auth;
use App\Qua;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;

class certController extends Controller
{
	private $auth;
	private $qua;
	public function __construct()
	{
		$this->auth=new Auth();
		$this->qua=new Qua();
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keyId=Requester::input("id");
		$keyStatus=Requester::input("auth_status");

        if ($keyId=="" && $keyStatus=="") {
		    $datas=$this->auth->orderBy("auth_status","asc")->orderBy("id","desc")->paginate(8);
		} elseif (empty($keyStatus)) {
<<<<<<< HEAD
			$datas = Auth::Ids($keyId)->orderBy("auth_status","asc")->orderBy("id","desc")->paginate(8);
=======
			$datas = Auth::Users($keyId)->orderBy("id","desc")->paginate(8);
>>>>>>> 6cb148b5a4c9b1f7744c969565c8148d7390e6f3
		} elseif (empty($keyId)) {
			$datas = Auth::Status($keyStatus)->orderBy("auth_status","asc")->orderBy("id","desc")->paginate(8);
		} else {
<<<<<<< HEAD
			$datas = Auth::Ids($keyId)->Status($keyStatus)->orderBy("auth_status","asc")->orderBy("id","desc")->paginate(8);
=======
			$datas = Auth::Users($keyId)->Status($keyStatus)->orderBy("id","desc")->paginate(8);
>>>>>>> 6cb148b5a4c9b1f7744c969565c8148d7390e6f3
		}
		$args=array("id"=>$keyId,"auth_status"=>$keyStatus);
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
