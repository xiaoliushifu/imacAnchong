<?php

namespace App\Http\Controllers\Api\Category;

//use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Request;
use Validator;
use DB;

/*
*   该控制器是操作分类，为API接口提供分类数据
*/
class CategoryController extends Controller
{
    /*
    *   该方法是调用第一级产品分类的接口
    */
    public function catone(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //创建ORM模型
        $category=new \App\Category();
        //进行数据查询
        $result=$category->quer(['cat_id','cat_name'],'parent_id = 0');
        //为了判断将数据转成数组格式
        $resultarr=$result->toArray();
        //判断后如果不为空返回集合格式的数据，否则返回错误
        if(!empty($resultarr)){
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$result]);
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>9,'ResultData'=>['Message'=>'分类信息加载失败，请刷新']]);
        }
    }

    /*
    *   该方法是调用第二级和第三级产品分类的接口
    */
    public function catinfo(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //创建ORM模型
        $category=new \App\Category();
        $category_type=new \App\Category_type();
        //将二级分类信息查询出来
        $resultarr=$category->quer(['cat_id','cat_name'],'parent_id = '.$param['cat_id'])->toArray();
        //定义两个变量来存储最后的结果
        $catarr=null;
        $catresults=null;
        //通过便利将一级分类下的二级和三级分类全部查出来并处理数据格式
        foreach ($resultarr as $variable) {
            foreach ($variable as $value) {
                //判断查出来的数据是否为ID
                if(is_numeric($value)){
                    //使用二级分类的id进行三级分类的查询
                    $cattow=$category_type->quer('cat_name','parent_id = '.$value)->toArray();
                    foreach ($cattow as $cat3) {
                        foreach ($cat3 as $catresult) {
                            //进行数据组装
                            $catarr[]=$catresult;
                        }
                    }
                }else{
                    //进行数据组装
                    $catresults[]=['name'=>$value,'list'=>$catarr];
                    $catarr=null;
                }
            }
        }
        //假如数据组装后不为空那么返回正确，否则返回错误
        if(!empty($catresults)){
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$catresults]);
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>9,'ResultData'=>['Message'=>'分类信息加载失败，请刷新']]);
        }
    }
}
