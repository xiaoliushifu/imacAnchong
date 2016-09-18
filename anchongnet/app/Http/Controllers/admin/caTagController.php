<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Request as Requester;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Goods_tag;
use DB;

class caTagController extends Controller
{
    private $catag;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->catag=new Goods_tag();
        $keyCat= Requester::input("cat");
        if ($keyCat=="") {
            $datas=$this->catag->paginate(8);
        } else {
            $datas = Goods_tag::Cat($keyCat)->paginate(8);
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
    public function store(Request $req)
    {
        
        //判重,由于unique{tag,cat_id}。即同一个二级分类下不允许有重复标签。
        if (DB::table('anchong_goods_tag')->whereTagAndCat_id($req->tag, $req->midselect)->first()) {
            return view("admin/tag/create_cat")->with('mes','标签不可重复！');
        }
		DB::table('anchong_goods_tag')->insert(
            [
                'tag' => $req->tag,
                'cat_id' => $req->midselect,
                'cat_name'=>$req->catname,
            ]
        );
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
        $this->catag=new Goods_tag();
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
        if (DB::table('anchong_goods_tag')->whereTagAndCat_id($request->tag, $request->midselect)->first()) {
            return redirect()->back();
        }
        $this->catag=new Goods_tag();
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
        $this->catag=new Goods_tag();
        if (!$data=$this->catag->find($id)) {
            return "删除成功";
        }
        $data->delete();
        return "删除成功";
    }

    /*
     * 获取同一个分类的所有路由的方法
     * */
    public function getagByCat(Request $request)
    {
        $datas=Goods_tag::Cat($request->cid)->get();
        return $datas;
    }
}
