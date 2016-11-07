<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Brand;
use Cache;

/**
*   该控制器包含了商品品牌模块的操作
*/
class brandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $k=$req['kn'];
        $model = new Brand();
        if ($k) {
            $datas = Brand::where('brand_name','like',"%$k%")->paginate(8);
        } else {
            $datas=Brand::paginate(8);
        }
        $args=array("kn"=>$k);
        return view('admin/brand/index',array("datacol"=>compact("args","datas")));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.brand.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request('catname'品牌名,'pic'品牌logo)
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        if(!$req['pic']) {
            return redirect()->back()->with('status', '图片必须上传');
        }
        $mess = ['unique' => '品牌已重复'];
        $this->validate($req, [
            'brand_name' =>'unique:anchong_goods_brand,brand_name',
        ],$mess);
        $model = new Brand();
        $model->brand_name=$req['brand_name'];
        $model->brand_logo=$req['pic'][0]['url'];
        $model->save();
        return redirect()->back()->with('status', '添加成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id分类ID
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id分类ID
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return;
        $model = new Brand();
        $data=$model->find($id);
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $mess = ['unique' => ':attribute 品牌名已重复'];
        $this->validate($req, [
            'brand_name' =>"unique:anchong_goods_brand,brand_name,$id,brand_id"
        ],$mess);
        $model = new Brand();
        $data=$model->find($id);
        $data->brand_name=$req['brand_name'];
        $data->save();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id分类ID
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return ;
    }
}
