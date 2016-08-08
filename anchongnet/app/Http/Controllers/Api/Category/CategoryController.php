<?php

namespace App\Http\Controllers\Api\Category;

//use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Request;
use Validator;
use DB;
use Cache;

/*
*   该控制器是操作商品分类，为API接口提供商品分类数据
*/
class CategoryController extends Controller
{

    /*
    *   该方法是调用第一级和第二级产品分类的接口
    */
    public function catinfo(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //判断缓存
            $result_cache=Cache::get('category_catinfo_result');
            if($result_cache){
                //将缓存取出来赋值给变量
                $result=$result_cache;
            }else{
                //创建ORM模型
                $category=new \App\Category();
                //将一级分类信息查询出来
                $result=$category->quer(['cat_id','cat_name'],'parent_id = '.$param['cat_id'].' and is_show = 1')->toArray();
                //将查询结果加入缓存
                Cache::add('category_catinfo_result', $result, 600);
            }
            //假如数据组装后不为空那么返回正确，否则返回错误
            if(!empty($result)){
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$result]);
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>9,'ResultData'=>['Message'=>'分类信息加载失败，请刷新']]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }
}
