<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Request as Requester;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Good;
use App\Shop;
use Auth;

class commodityController extends Controller
{
    private $good;
    private $uid;
    private $sid;
    public function __construct()
    {
        $this->good=new Good();
        //通过Auth获取当前登录用户的id
        $this->uid=Auth::user()['users_id'];
        //通过用户获取商铺id
        $this->sid=Shop::Uid($this->uid)->sid;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keyName=Requester::input('keyName');
        if($keyName==""){
            $datas=$this->good->paginate(8);
        }else{
            $datas = Good::Name($keyName)->paginate(8);
        }
        $args=array("keyName"=>$keyName);
        return view('admin/good/index_commodity',array("datacol"=>compact("args","datas")));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin/good/create_commodity")->with('sid', $this->sid);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //向goods表中插入数据
        $this->good->sid=$this->sid;
        $this->good->type=$request->backselect;
        $this->good->title=$request->name;
        $this->good->desc=$request->description;
        $this->good->save();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data=$this->good->find($id);
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
        $data=$this->good->find($id);
        return $data;
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
        $data=$this->good->find($id);
        $data->type=$request->backselect;
        $data->title=$request->title;
        $data->desc=$request->description;
        $result=$data->save();
        if($result){
            return redirect()->back();
        }else{
            return "更新失败，请返回重试";
        }
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
     * 获取同一个分类下的商品的方法
     * */
    public function getSiblings(Request $request){
        $data=Good::Type($request['pid'],$request['sid'])->get();
        return $data;
    }
}
