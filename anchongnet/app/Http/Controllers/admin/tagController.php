<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Request as Requester;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tag;

class tagController extends Controller
{
    private $tag;

    /**
     * tagController constructor.
     * @param $tag
     */
    public function __construct()
    {
        $this->tag = new Tag();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keyType=Requester::input("type");
        if($keyType==""){
            $datas=$this->tag->paginate(8);
        }else{
            $datas = Tag::Type($keyType)->paginate(8);
        }
        $args=array("type"=>$keyType);
        return view('admin/tag/index',array("datacol"=>compact("args","datas")));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin/tag/create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\TagPostRequest $request)
    {
        $this->tag->type_id = $request->type;
        $this->tag->tag=$request->tag;
        $data=$this->tag->save();
        if($data){
            return view("admin/tag/create")->with('mes','添加成功！');
        }else{
            return view("admin/tag/create")->with('mes','添加失败！');
        }
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
        $data=$this->tag->find($id);
        $data->delete();
        return "删除成功";
    }

    /*
     * 异步获取所有标签的接口
     * */
    public function geTag()
    {
        $datas=$this->tag->get();
        return $datas;
    }
}
