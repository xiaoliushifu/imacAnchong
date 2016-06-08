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
        $business=new \App\Business();
        $businessinfo=['bid','phone','contact','title','content','tag','tags','created_at'];
        //轮播图查询
        $ad_result_pic=$ad->quer(['ad_code','ad_name','ad_link'],'position_id = 2 and media_type = 0 and enabled = 1',0,5)->toArray();
        //最新招标项目
        $ad_result_area=$ad->quer(['ad_code','ad_name'],'position_id = 4 and media_type = 0 and enabled = 1',0,4)->toArray();
        //热门招标查询
        $businessinfo_data=$business->simplequer($businessinfo,'recommend = 1 and type = 1',0,2);
        $list=null;
        if($businessinfo_data){
            //创建图片查询的orm模型
            $business_img=new \App\Business_img();
            //通过数组数据的组合将数据拼凑
            foreach ($businessinfo_data as $business_data) {
                $value_1=$business_img->quer('img',$business_data['bid']);
                //判断是否为空,如果是空表明没有图片
                if(empty($value_1)){
                    $list[]=$business_data;
                }else{
                    //假如不为空表明有图片，开始查询拼凑数据
                    foreach ($value_1 as $value_2) {
                        foreach ($value_2 as $value_3) {
                            $img[]=$value_3;
                        }
                    }
                    //重构数组，加上键值
                    $img_data=['pic'=>$img];
                    $list[]=array_merge($business_data,$img_data);
                    $img=null;
                }
            }
        }
        //热门工程
        //热门招标查询
        $businessinfo_data_all=$business->simplequer($businessinfo,'recommend = 1 and type in (1,2)',0,3);
        $list_all=null;
        if($businessinfo_data_all){
            //创建图片查询的orm模型
            $business_img=new \App\Business_img();
            //通过数组数据的组合将数据拼凑
            foreach ($businessinfo_data_all as $business_data_all) {
                $value_1=$business_img->quer('img',$business_data_all['bid']);
                //判断是否为空,如果是空表明没有图片
                if(empty($value_1)){
                    $list_all[]=$business_data_all;
                }else{
                    //假如不为空表明有图片，开始查询拼凑数据
                    foreach ($value_1 as $value_2) {
                        foreach ($value_2 as $value_3) {
                            $img[]=$value_3;
                        }
                    }
                    //重构数组，加上键值
                    $img_data=['pic'=>$img];
                    $list_all[]=array_merge($business_data,$img_data);
                    $img=null;
                }
            }
        }
        $showphone=0;
        if($data['guid'] == 0){
            $showphone=0;
        }else{
            $users=new \App\Users();
            $users_auth=$users->quer('certification',['users_id'=>$data['guid']])->toArray();
            if($users_auth[0]['certification'] == 3){
                $showphone=1;
            }
        }
        //判断结果是否为空
        if(!empty($ad_result_pic && $list && $ad_result_area && $list_all)){
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['pic'=>$ad_result_pic,'recommend'=>$list,'recent'=>$ad_result_area,'hotproject'=>$list_all,'showphone'=>$showphone]]);
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
