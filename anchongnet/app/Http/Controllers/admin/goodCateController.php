<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use Cache;

class goodCateController extends Controller
{
    private $cat;
    /*
     * 构造方法
     * */
    public function __construct()
    {
        $this->cat=new Category();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $k=$req['keyName'];
        if ($k) {
            $datas = Category::Name($k)->paginate(8);
        } else {
            $datas=$this->cat->paginate(8);
        }
        $args=array("keyName"=>$k);
        return view('admin/cate/index',array("datacol"=>compact("args","datas")));
    }

    /*
    * 由二级分类获取同一个父分类下的所有二级分类的方法
    * */
   public function getSiblings(Request $request)
   {
       $pid=$this->cat->find($request['cid'])->parent_id;
       //使用缓存
       return Cache::remember($pid,'600',function () use ($pid) {
                        return $this->cat->Pids( $pid )->get();
                  });
   }

   /*
    * 获取指定分类的子分类的方法
    * */
   public function getsubLevel(Request $req)
   {
       $pid=$req['pid'];
      return Cache::remember($pid,'600',function () use ($pid) {
                    return $this->cat->Pids( $pid )->get();
                 });
   }


    /*
     * 获取所有非顶级分类的方法，目前只有两级分类
     * */
    public function getLevel2()
    {
        //加入缓存
        return Cache::remember('level2',600,function() {
                        return Category::Level2()->get();
                   });
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.cate.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $mess = ['unique' => '分类已重复'];
        $this->validate($request, [
            'catname' =>'unique:anchong_goods_cat,cat_name',
        ],$mess);
        
        $this->cat->cat_name=$request['catname'];
        $this->cat->keyword=$request['keyword'];
        $this->cat->sort_order=$request['sort'];
        $this->cat->cat_desc=$request['description'];
        $this->cat->is_show=$request['ishow'];
        $this->cat->parent_id=$request['parent'];
        $result=$this->cat->save();
        if ($result) {
            Cache::forget('category_catinfo_result');
            return redirect()->back();
        } else {
            dd("修改失败，请返回重试");
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
        $data=$this->cat->find($id);
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
        $data=$this->cat->find($id);
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
        $mess = ['unique' => '分类已重复'];
        //排除cat_id=$id的记录
        $this->validate($request, [
            'catname' =>"unique:anchong_goods_cat,cat_name,$id,cat_id"
        ],$mess);
        $data=$this->cat->find($id);
        $data->cat_name=$request['catname'];
        $data->keyword=$request['keyword'];
        $data->cat_desc=$request['description'];
        $data->sort_order=$request['sort'];
        $data->is_show=$request['ishow'];
        //$data->parent_id=$request['parent']; //分类层级暂不修改
        $result=$data->save();
        if($result){
          //清除缓存
            Cache::forget('category_catinfo_result'.$request['parent']);
            return redirect()->back();
        }else{
            dd("修改失败，请返回重试");
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
        $data=$this->cat->find($id);
        //顶级分类不可删除
        if ($data['parent_id'] == 0) {
            return '顶级分类不可删除';
        }
        //该分类是否有子分类
        if (Category::Pids($id)->get()->toArray()) {
            return '该分类下仍有子分类信息';
        }
        //该分类下是否有商品
        $goods = new \App\Goods();
        if ($goods->getGoodsByType($id)->toArray()) {
            return  '该分类下仍有商品信息';
        }
        $result=$data->delete();
        if($result){
          //清除缓存
            Cache::forget('category_catinfo_result1');
          //清除缓存
            Cache::forget('category_catinfo_result2');
          //清除缓存
            Cache::forget('category_catinfo_result3');
          //清除缓存
            Cache::forget('category_catinfo_result4');
          //清除缓存
            Cache::forget('category_catinfo_result5');
          //清除缓存
            Cache::forget('category_catinfo_result6');
          //清除缓存
            Cache::forget('category_catinfo_result7');
          //清除缓存
            Cache::forget('category_catinfo_result8');
            return "删除成功";
        }else{
            return "删除失败";
        }
    }
}
