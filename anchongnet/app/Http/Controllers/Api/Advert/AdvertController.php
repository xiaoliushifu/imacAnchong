<?php

namespace App\Http\Controllers\Api\Advert;

use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

/*
*   该控制器包含了广告模块的操作
*/
class AdvertController extends Controller
{
    /*
    *   该方法是广告轮播图的功能
    */
    public function businessadvert(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //创建ORM模型
        $ad=new \App\Ad();
        $ad_result=$ad->quer('ad_code','position_id = 2 and media_type = 0 and enabled = 1',0,4)->toArray();
        //定义图片数组
        $pic=null;
        //遍历数组组合
        foreach ($ad_result as $results) {
            //将图片放入数组
            $pic[]=$results['ad_code'];
        }
        //判断结果是否为空
        if(!empty($pic)){
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$pic]);
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>16,'ResultData'=>['Message'=>'加载失败，请刷新']]);
        }
    }

    /*
    *   该方法是广告轮播图的功能
    */
    public function goodsadvert(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //创建ORM模型
        $ad=new \App\Ad();
        $ad_result=$ad->quer('ad_code','position_id = 3 and media_type = 0 and enabled = 1',0,4)->toArray();
        //定义图片数组
        $pic=null;
        //遍历数组组合
        foreach ($ad_result as $results) {
            //将图片放入数组
            $pic[]=$results['ad_code'];
        }
        //判断结果是否为空
        if(!empty($pic)){
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$pic]);
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>16,'ResultData'=>['Message'=>'加载失败，请刷新']]);
        }
    }

    /*
    *   该方法是广告轮播图的功能
    */
    public function communityadvert()
    {
        //获得APP端传过来的json格式数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],ture);
        //创建ORM模型
        $ad_result=$ad->quer('ad_code','position_id = 3 and media_type = 0',0,4)->toArray();
        //定义图片数组
        $pic=null;
        //遍历数组组合
        foreach ($ad_result as $results) {
            //将图片放入数组
            $pic[]=$results['ad_code'];
        }
        //判断结果是否为空
        if(!empty($pic)){
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$pic]);
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>16,'ResultData'=>['Message'=>'加载失败，请刷新']]);
        }
    }
}
