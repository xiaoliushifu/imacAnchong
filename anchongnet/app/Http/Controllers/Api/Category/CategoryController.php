<?php

namespace App\Http\Controllers\Api\Category;

//use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Request;
use Validator;
use DB;

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
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //创建ORM模型
        $category=new \App\Category();
        //将一级分类信息查询出来
        $resultarr=$category->quer(['cat_id','cat_name'],'parent_id = 0 and is_show = 1')->toArray();
        //定义两个变量来存储最后的结果
        $catarr=null;
        $catresults=null;
        $twocat=null;
        //通过便利将一级分类下的二级分类全部查出来并处理数据格式
        foreach ($resultarr as $variable) {
            foreach ($variable as $value) {
                //判断查出来的数据是否为ID
                if(is_numeric($value)){
                    $twocat['cat_id']=$value;
                    //使用一级分类的id进行二级分类的查询
                    $cattow=$category->quer(['cat_id','cat_name'],'parent_id = '.$value.' and is_show = 1')->toArray();
                    foreach ($cattow as $cat3) {
                        //组装数组
                        $catarr[]=$cat3;
                    }
                }else{
                    $twocat['cat_name']=$value;
                    //进行数据组装
                    $catresults[]=['name'=>$twocat,'list'=>$catarr];
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
