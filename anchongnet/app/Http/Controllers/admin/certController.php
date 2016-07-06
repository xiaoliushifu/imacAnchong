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
	public function __construct(){
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

        if($keyId=="" && $keyStatus==""){
		    $datas=$this->auth->orderBy("id","desc")->paginate(4);
		}else if(empty($keyStatus)){
			$datas = Auth::Ids($keyId)->orderBy("id","desc")->paginate(4);
		}else if(empty($keyId)){
			$datas = Auth::Status($keyStatus)->orderBy("id","desc")->paginate(4);
		}else{
			$datas = Auth::Ids($keyId)->Status($keyStatus)->orderBy("id","desc")->paginate(4);
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
		/*$auth=Auth::Users($id)->get();
		$auth_name=$auth[0]['auth_name'];
		$auth_con=[];
		$auth_obj=[];
		for($i=0;$i<count($auth);$i++){
			$auth_obj['qua_name']=$auth[$i]['qua_name'];
			$auth_obj['explanation']=$auth[$i]['explanation'];
			$auth_obj['credentials']=$auth[$i]['credentials'];
			array_push($auth_con,$auth_obj);
		}
		return response()->json([
		    'auth_name' => $auth_name,
			'auth_con' => $auth_con
		]);*/
		$data=Qua::Ids($id)->get();
        return $data;
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
