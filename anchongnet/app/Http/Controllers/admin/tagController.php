<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Request as Requester;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tag;
use Cache;

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
        //清除缓存
        switch ($request->type) {
            //地区标签
            case '0':
                Cache::forget('business_search_result_area');
                break;
            //发布工程标签
            case '1':
                Cache::forget('business_search_result_tag1');
                break;
            //承接工程标签
            case '2':
                Cache::forget('business_search_result_tag2');                                
                break;
            //发布人才
            case '3':
                Cache::forget('business_search_result_tag3');
                break;
            //招聘人才
            case '4':
                Cache::forget('business_search_result_tag4');
                break;
            //默认的内容
            default:
                break;
        }
        Cache::forget('business_typetag_typetag_array');
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
        //清除缓存
        switch ($request->type) {
            //地区标签
            case '0':
                Cache::forget('business_search_result_area');
                break;
            //发布工程标签
            case '1':
                Cache::forget('business_search_result_tag1');
                break;
            //承接工程标签
            case '2':
                Cache::forget('business_search_result_tag2');
                break;
            //发布人才
            case '3':
                Cache::forget('business_search_result_tag3');
                break;
            //招聘人才
            case '4':
                Cache::forget('business_search_result_tag4');
                break;
        }
        Cache::forget('business_typetag_typetag_array');
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
