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
    *   该方法是商机的首页
    */
    public function businessadvert(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //创建ORM模型
        $ad=new \App\Ad();
        $business=new \App\Business();
        $information=new \App\Information();
        $businessinfo=['bid','phone','contact','title','content','tag','tags','created_at','endtime'];
        //轮播图查询
        $ad_result_pic=$ad->quer(['ad_code','ad_name','ad_link'],'position_id = 2 and media_type = 0 and enabled = 1',0,5)->toArray();
        $ad_infor_result=$information->firstquer(['infor_id','title','img'],'added =1');
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
        if(!empty($ad_result_pic) && !empty($list) && !empty($ad_result_area) && !empty($list_all)){
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['pic'=>$ad_result_pic,'information'=>$ad_infor_result,'informationurl'=>'http://www.anchong.net/information/','recommend'=>$list,'recent'=>$ad_result_area,'hotproject'=>$list_all,'showphone'=>$showphone]]);
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>16,'ResultData'=>['Message'=>'加载失败，请刷新']]);
        }
    }

    /*
    *   该方法是商城的首页
    */
    public function goodsadvert(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //创建ORM模型
        $ad=new \App\Ad();
        $ad_position=new \App\Ad_position();
        $goods_type=new \App\Goods_type();
        //查询轮播图
        $ad_result_pic=$ad->quer(['ad_code','ad_name','ad_link'],'position_id = 3 and media_type = 0 and enabled = 1',0,4)->toArray();
        //查询商城广告模块
        $ad_result=$ad->simplequer(['position_id','ad_code','ad_name','ad_link'],'site_ad = 2 and enabled = 1')->toArray();
        //查询模块定义名称
        $ad_name=$ad_position->simplequer(['position_id','position_desc'],'site_ad = 2')->toArray();
        //需要查的字段
        $goods_data=['gid','title','price','sname','pic','vip_price','goods_id'];
        //设置随机偏移量
        $num=rand(10,99);
        //推荐商品
        $goods_result=$goods_type->simplequer($goods_data,"added = 1",$num,10)->toArray();
        //定义结果数组
        $list=null;
        $ad_one=null;
        $ad_two=null;
        $ad_three=null;
        $ad_four=null;
        $ad_five=null;
        $ad_six=null;
        $ad_one_list=null;
        $ad_two_list=null;
        $ad_three_list=null;
        $ad_four_list=null;
        $ad_five_list=null;
        $ad_six_list=null;
        //遍历数据数组分门别类
        foreach ($ad_result as $ad_result_arr) {
            switch ($ad_result_arr['position_id']) {
                //第一块的广告
                case '5':
                    $ad_one_list[]=$ad_result_arr;
                    break;
                //第二块的广告
                case '6':
                    $ad_two_list[]=$ad_result_arr;
                    break;
                //第三块的广告
                case '7':
                    $ad_three_list[]=$ad_result_arr;
                    break;
                //第四块的广告
                case '8':
                    $ad_four_list[]=$ad_result_arr;
                    break;
                //第五块的广告
                case '9':
                    $ad_five_list[]=$ad_result_arr;
                    break;
                //第六块的广告
                case '10':
                    $ad_six_list[]=$ad_result_arr;
                    break;
                default:
                    break;
            }
        }
        //遍历标题数组
        foreach ($ad_name as $ad_name_arr) {
            switch ($ad_name_arr['position_id']) {
                //第一块的广告
                case '5':
                    $ad_one['name']=$ad_name_arr['position_desc'];
                    $ad_one['list']=$ad_one_list;
                    break;
                //第二块的广告
                case '6':
                    $ad_two['name']=$ad_name_arr['position_desc'];
                    $ad_two['list']=$ad_two_list;
                    break;
                //第三块的广告
                case '7':
                    $ad_three['name']=$ad_name_arr['position_desc'];
                    $ad_three['list']=$ad_three_list;
                    break;
                //第四块的广告
                case '8':
                    $ad_four['name']=$ad_name_arr['position_desc'];
                    $ad_four['list']=$ad_four_list;
                    break;
                //第五块的广告
                case '9':
                    $ad_five['name']=$ad_name_arr['position_desc'];
                    $ad_five['list']=$ad_five_list;
                    break;
                //第六块的广告
                case '10':
                    $ad_six['name']=$ad_name_arr['position_desc'];
                    $ad_six['list']=$ad_six_list;
                    break;
                default:
                    break;
            }
        }
        //判断结果是否为空
        if(!empty($ad_result_pic) && !empty($ad_one) && !empty($ad_one) && !empty($ad_three) && !empty($ad_four) && !empty($ad_five) && !empty($ad_six)){
            //判断是否有权限查看会员价，也就是判断是否审核通过
            $showprice=0;
            if($data['guid'] == 0){
                $showprice=0;
            }else{
                $users=new \App\Users();
                //查询用户是否认证
                $users_auth=$users->quer('certification',['users_id'=>$data['guid']])->toArray();
                if($users_auth[0]['certification'] == 3){
                    $showprice=1;
                }
            }
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['pic'=>$ad_result_pic,'one'=>$ad_one,'two'=>$ad_two,'three'=>$ad_three,'four'=>$ad_four,'five'=>$ad_five,'six'=>$ad_six,'goods'=>$goods_result,'showprice'=>$showprice]]);
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>16,'ResultData'=>['Message'=>'加载失败，请刷新']]);
        }
    }

    /*
    *   更多资讯
    */
    public function information(Request $request)
    {
        //获得APP端传过来的json格式数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //默认每页数量
        $limit=20;
        //创建ORM方法
        $information=new \App\Information();
        $infor_result=$information->quer(['infor_id','title','img'],'added =1',(($param['page']-1)*$limit),$limit);
        //定义结果数组
        $list=null;
        $list['total']=$infor_result['total'];
        $list['list']=$infor_result['list'];
        $list['url']='http://www.anchong.net/information/';
        if($infor_result['total']>0){
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$list]);
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>16,'ResultData'=>['Message'=>'加载失败，请刷新']]);
        }
    }

    /*
    *   该方法是商机内部的轮播图
    */
    public function projectadvert(Request $request)
    {
        //获得APP端传过来的json格式数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //创建ORM模型
        $ad=new \App\Ad();
        //定义sql语句
        $sql=null;
        //匹配是哪个轮播图
        switch ($param['type']) {
            //第一块的广告
            case '1':
                $sql='position_id = 11 and enabled = 1';
                break;
            //第二块的广告
            case '2':
                $sql='position_id = 12 and enabled = 1';
                break;
            //第三块的广告
            case '3':
                $sql='position_id = 13 and enabled = 1';
                break;
            //默认的内容
            default:
                return response()->json(['serverTime'=>time(),'ServerNo'=>16,'ResultData'=>['Message'=>'非法操作']]);
                break;
        }
        //创建ORM模型
        $ad_result=$ad->quer(['ad_code','ad_name','ad_link'],$sql,0,6)->toArray();
        //判断结果是否为空
        if(!empty($ad_result)){
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$ad_result]);
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>16,'ResultData'=>['Message'=>'加载失败，请刷新']]);
        }
    }
}
