<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Request as Requester;
use App\Http\Requests;
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
    public function index()
    {
      $keyName=Requester::input('keyName');
        if($keyName==""){
            $datas=$this->cat->paginate(8);
        }else{
            $datas = Category::Name($keyName)->paginate(8);
        }
        $args=array("keyName"=>$keyName);
        return view('admin/cate/index',array("datacol"=>compact("args","datas")));
    }

    /*
     * 获取某个二级分类的所有兄弟分类的方法
     * 即获取同一个一级分类下的所有二级分类的方法
     * */
    public function newgetSiblings(Request $request)
    {
        $cid=$request['cid'];
        $pid=$this->cat->find($cid)->parent_id;
        //缓存使用
        if (!$datas = Cache::get($pid)) {
            $datas=$this->cat->Pids($pid)->get();
            Cache::add($pid,$datas,'60');
        }
        $datas = $datas->toArray();
        $result['cnum']=$request['id'];
        $result['datas']=$datas;
        $result['cid']=$cid;
        $result['parent_id']=$pid;
        return $result;
    }

    /*
     * 获取指定一级或二级分类的方法
     * */
    public function newgetsubLevel(Request $request)
    {
        $pid=$request['pid'];
        //缓存的使用
        if (!$datas = Cache::get($pid)) {
            $datas = Category::Pids($pid)->get();
            Cache::add($pid,$datas,'60');
        }
        $result['cnum']=$request['id'];
        $result['datas']=$datas;
        return $result;
    }

    /*
    * 获取某个二级分类的所有兄弟分类的方法
    * 即获取同一个一级分类下的所有二级分类的方法
    * */
   public function getSiblings(Request $request)
   {
       $cid=$request['cid'];
       $pid=$this->cat->find($cid)->parent_id;
       //使用缓存
       if (!$datas = Cache::get($pid)) {
           $datas=$this->cat->Pids($pid)->get();
           Cache::add($pid,$datas,'60');
       }
       return $datas;
   }

   /*
    * 获取指定分类的子分类的方法
    * */
   public function getsubLevel(Request $request)
   {
       $pid=$request['pid'];
       //使用缓存，获取pid=0-8
       if (!$datas = Cache::get($pid)) {
           $datas = Category::Pids($pid)->get(['cat_id','cat_name']);
           Cache::add($pid,$datas,'60');
       }
       return $datas;
   }


    /*
     * 获取所有二级分类的方法
     * */
    public function getLevel2()
    {
        //加入缓存
        if (!$datas = Cache::get('level2')) {
            $datas = Category::Level2()->get();
            Cache::add('level2',$datas,'60');
        }
        return $datas;
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
        $this->cat->cat_name=$request['catname'];
        $this->cat->keyword=$request['keyword'];
        $this->cat->sort_order=$request['sort'];
        $this->cat->cat_desc=$request['description'];
        $this->cat->is_show=$request['ishow'];
        $this->cat->parent_id=$request['parent'];
        $result=$this->cat->save();
        if ($result) {
            //清除缓存
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
        $data=$this->cat->find($id);
        $data->cat_name=$request['catname'];
        $data->keyword=$request['keyword'];
        $data->cat_desc=$request['description'];
        $data->sort_order=$request['sort'];
        $data->is_show=$request['ishow'];
        $data->parent_id=$request['parent'];
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
