<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Users;
use App\Http\Controllers\Controller;

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
    public function index(Request $req)
    {
		$keyPhone=$req["phone"];
		$keyLevel=$req["users_rank"];
		$keyID=$req["uid"];

        if ($keyID) {
            $datas = Users::IDs($keyID)->orderBy("users_id","desc")->paginate(8);
		} elseif ($keyPhone) {
		    $datas = Users::Phone($keyPhone)->orderBy("users_id","desc")->paginate(8);
		} elseif ($keyLevel) {
			$datas = Users::Level($keyLevel)->orderBy("users_id","desc")->paginate(8);
		} else {
			$datas = $this->user->orderBy("users_id","desc")->paginate(8);
		}
		$args=array("users_rank"=>$keyLevel);
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
    public function update(Request $req, $id)
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
