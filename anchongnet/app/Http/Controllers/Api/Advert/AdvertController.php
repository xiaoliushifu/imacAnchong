<?php

namespace App\Http\Controllers\Api\Advert;

use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Cache;

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
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            $businessinfo=['bid','phone','contact','title','content','tag','tags','created_at','endtime','img'];
            //判断缓存
            $ad_result_pic_cache=Cache::get('advert_businessadvert_ad_result_pic');
            if($ad_result_pic_cache){
                //将缓存取出来赋值给变量
                $ad_result_pic=$ad_result_pic_cache;
            }else{
                //创建ORM模型
                $ad=new \App\Ad();
                //轮播图查询
                $ad_result_pic=$ad->quer(['ad_code','ad_name','ad_link'],'position_id = 2 and media_type = 0 and enabled = 1',0,5)->toArray();
                //将查询结果加入缓存
                Cache::add('advert_businessadvert_ad_result_pic', $ad_result_pic, 600);
            }
            //判断缓存
            $ad_result_area_cache=Cache::get('advert_businessadvert_ad_result_area');
            if($ad_result_area_cache){
                //将缓存取出来赋值给变量
                $ad_result_area=$ad_result_area_cache;
            }else{
                //创建ORM模型
                $ad=new \App\Ad();
                //最新招标项目
                $ad_result_area=$ad->quer(['ad_code','ad_name'],'position_id = 4 and media_type = 0 and enabled = 1',0,4)->toArray();
                //将查询结果加入缓存
                Cache::add('advert_businessadvert_ad_result_area', $ad_result_area, 600);
            }
            //判断缓存
            $ad_infor_result_cache=Cache::get('advert_businessadvert_ad_infor_result');
            if($ad_infor_result_cache){
                //将缓存取出来赋值给变量
                $ad_infor_result=$ad_infor_result_cache;
            }else{
                //创建ORM模型
                $information=new \App\Information();
                $ad_infor_result=$information->firstquer(['infor_id','title','img'],'added =1');
                //将查询结果加入缓存
                Cache::add('advert_businessadvert_ad_infor_result', $ad_infor_result, 600);
            }
            //判断缓存
            $list_cache=Cache::get('advert_businessadvert_list');
            if($list_cache){
                //将缓存取出来赋值给变量
                $list=$list_cache;
            }else{
                //创建ORM模型
                $business=new \App\Business();
                //热门招标查询
                $businessinfo_data=$business->simplequer($businessinfo,'recommend = 1 and type = 1',0,2);
                $list=null;
                if($businessinfo_data){
                    //通过数组数据的组合将数据拼凑
                    foreach ($businessinfo_data as $business_data) {
                      //进行图片分隔操作
                      $img=trim($business_data['img'],"#@#");
                      //判断是否有图片
                      if(!empty($img)){
                          $img_arr=explode('#@#',$img);
                          $business_data['pic']=$img_arr;
                      }
                      $list[]=$business_data;
                    }
                }
                //将查询结果加入缓存
                Cache::add('advert_businessadvert_list', $list, 600);
            }
            //判断缓存
            $list_all_cache=Cache::get('advert_businessadvert_list_all');
            if($list_all_cache){
                //将缓存取出来赋值给变量
                $list_all=$list_all_cache;
            }else{
                //创建ORM模型
                $business=new \App\Business();
                //热门工程
                $businessinfo_data_all=$business->simplequer($businessinfo,'recommend = 1 and type in (1,2)',0,3);
                $list_all=null;
                if($businessinfo_data_all){
                    //通过数组数据的组合将数据拼凑
                    foreach ($businessinfo_data_all as $business_data_all) {
                      //进行图片分隔操作
                      $img=trim($business_data_all['img'],"#@#");
                      //判断是否有图片
                      if(!empty($img)){
                          $img_arr=explode('#@#',$img);
                          $business_data_all['pic']=$img_arr;
                      }
                      $list_all[]=$business_data_all;
                    }
                }
                //将查询结果加入缓存
                Cache::add('advert_businessadvert_list_all', $list_all, 600);
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
            if(!empty($ad_result_pic) && !empty($ad_infor_result) && !empty($list) && !empty($ad_result_area) && !empty($list_all)){
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['pic'=>$ad_result_pic,'information'=>$ad_infor_result,'informationurl'=>'http://www.anchong.net/information/','recommend'=>$list,'recent'=>$ad_result_area,'hotproject'=>$list_all,'showphone'=>$showphone]]);
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>161,'ResultData'=>['Message'=>'加载失败，请刷新']]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   该方法是商城的首页
    */
    public function goodsadvert(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //判断缓存
            $ad_result_pic_cache=Cache::get('advert_goodsadvert_ad_result_pic');
            if($ad_result_pic_cache){
                //将缓存取出来赋值给变量
                $ad_result_pic=$ad_result_pic_cache;
            }else{
                //创建ORM模型
                $ad=new \App\Ad();
                //查询轮播图
                $ad_result_pic=$ad->quer(['ad_code','ad_name','ad_link'],'position_id = 3 and media_type = 0 and enabled = 1',0,4)->toArray();
                //将查询结果加入缓存
                Cache::add('advert_goodsadvert_ad_result_pic', $ad_result_pic, 600);
            }
            //判断缓存
            $ad_result_cache=Cache::get('advert_goodsadvert_ad_result');
            if($ad_result_cache){
                //将缓存取出来赋值给变量
                $ad_result=$ad_result_cache;
            }else{
                //创建ORM模型
                $ad=new \App\Ad();
                //查询商城广告模块
                $ad_result=$ad->simplequer(['position_id','ad_code','ad_name','ad_link'],'site_ad = 2 and enabled = 1')->toArray();
                //将查询结果加入缓存
                Cache::add('advert_goodsadvert_ad_result', $ad_result, 600);
            }
            //判断缓存是否存在
            $ad_name_cache=Cache::get('advert_goodsadvert_ad_name');
            if($ad_name_cache){
                //将缓存取出来赋值给变量
                $ad_name=$ad_name_cache;
            }else{
                //创建ORM模型
                $ad_position=new \App\Ad_position();
                //查询模块定义名称
                $ad_name=$ad_position->simplequer(['position_id','position_desc'],'site_ad = 2')->toArray();
                Cache::add('advert_goodsadvert_ad_name', $ad_name, 600);
            }
            //判断缓存是否存在
            $goods_result_cache=Cache::get('advert_goodsadvert_goods_result');
            if($goods_result_cache){
                //将缓存取出来赋值给变量
                $goods_result=$goods_result_cache;
            }else{
                //需要查的字段
                $goods_data=['gid','title','price','sname','pic','vip_price','goods_id'];
                //设置随机偏移量
                $num=rand(10,99);
                //创建ORM模型
                $goods_type=new \App\Goods_type();
                //推荐商品
                $goods_result=$goods_type->simplequer($goods_data,"added = 1",$num,10)->toArray();
                Cache::add('advert_goodsadvert_goods_result', $goods_result, 5);
            }
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
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   更多资讯
    */
    public function information(Request $request)
    {
        try{
            //获得APP端传过来的json格式数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //默认每页数量
            $limit=20;
            //只为第一页添加缓存
            if($param['page'] == 1){
                //定义所有货品的关联缓存
                $list_cache=Cache::get('business_information_list');
            }else{
                $list_cache=null;
            }
            //判断缓存
            if($list_cache){
                //将缓存取出来赋值给变量
                $list=$list_cache;
            }else{
                //创建ORM方法
                $information=new \App\Information();
                $infor_result=$information->quer(['infor_id','title','img'],'added =1',(($param['page']-1)*$limit),$limit);
                //定义结果数组
                $list=null;
                $list['total']=$infor_result['total'];
                $list['list']=$infor_result['list'];
                $list['url']='http://www.anchong.net/information/';
                //只为第一页添加缓存
                if($param['page'] == 1){
                    //将查询结果加入缓存
                    Cache::add('business_information_list', $list, 600);
                }
            }
            if($list['total']>0){
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$list]);
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>16,'ResultData'=>['Message'=>'加载失败，请刷新']]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   该方法是商机内部的轮播图
    */
    public function projectadvert(Request $request)
    {
       try{
			//获得APP端传过来的json格式数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            switch ($param['type']) {
                //第一块的广告
                case '1':
                    $ad_result_cache=Cache::get('business_projectadvert_ad_result1');
                    break;
                //第二块的广告
                case '2':
                    $ad_result_cache=Cache::get('business_projectadvert_ad_result2');
                    break;
                //第三块的广告
                case '3':
                    $ad_result_cache=Cache::get('business_projectadvert_ad_result3');
                    break;
                //默认的内容
                default:
                    $ad_result_cache=null;
                    break;
            }
            if($ad_result_cache){
                //将缓存取出来赋值给变量
                $ad_result=$ad_result_cache;
            }else{
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
                switch ($param['type']) {
                    //第一块的广告
                    case '1':
                        //将查询结果加入缓存
                        Cache::add('business_projectadvert_ad_result1', $ad_result, 600);
                        break;
                    //第二块的广告
                    case '2':
                        //将查询结果加入缓存
                        Cache::add('business_projectadvert_ad_result2', $ad_result, 600);
                        break;
                    //第三块的广告
                    case '3':
                        //将查询结果加入缓存
                        Cache::add('business_projectadvert_ad_result3', $ad_result, 600);
                        break;
                    //默认的内容
                    default:
                        break;
                }
            }
            //判断结果是否为空
            if(!empty($ad_result)){
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$ad_result]);
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>16,'ResultData'=>['Message'=>'加载失败，请刷新']]);
            }
        }catch (\Exception $e) {
           return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   资讯查看
    */
    public function informations($infor_id)
    {
        try{
            //创建ORM模型
            $information=new \App\Information();
            $data=$information->firstquer('content','infor_id ='.$infor_id);
            return $data['content'];
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }
}
