<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Request as Requester;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Catag;
use DB;

class caTagController extends Controller
{
    private $catag;
    public function __construct()
    {
        $this->catag=new catag();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keyCat= Requester::input("cat");
        if ($keyCat=="") {
            $datas=$this->catag->paginate(8);
        } else {
            $datas = Catag::Cat($keyCat)->paginate(8);
        }
        $args=array("cat"=>$keyCat);
        return view('admin/tag/index_cat',array("datacol"=>compact("args","datas")));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin/tag/create_cat");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$arr=explode(" ",$request->tag);
		for($i=0;$i<count($arr);$i++){
			DB::table('anchong_goods_tag')->insert(
                [
                    'tag' => $arr[$i],
                    'cat_id' => $request->midselect,
                    'cat_name'=>$request->catname,
                ]
            );
		};
        return view("admin/tag/create_cat")->with('mes','添加成功！');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data=$this->catag->find($id);
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
        $data=$this->catag->find($id);
        $data->tag=$request->tag;
        $data->cat_id=$request->midselect;
        $data->cat_name=$request->catname;
        $data->save();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$data=$this->catag->find($id)) {
            return "删除成功";
        }
        $data->delete();
        return "删除成功";
    }

    /*
     * 获取同一个分类的所有路由的方法
     * */
    public function getSiblings(Request $request)
    {
        $datas=$this->catag->Cat($request->cid)->get();
        return $datas;
    }
}
