<?php

namespace App\Http\Controllers\Api\Business;

//use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Request;
use Validator;

/*
*   该控制器包含了商机模块的操作
*/
class BusinessController extends Controller
{
    /*
    *   该方法提供了商机发布的功能
    */
    public function release(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //验证用户传过来的数据是否合法
        $validator = Validator::make($param,
            [
                'uid' => 'required',
                'type' => 'required',
                'title' => 'required|max:126',
                'content' => 'required|min:4',
                'tag' => 'required',
                'pic' => 'required|array'
            ]
        );
        //如果出错返回出错信息，如果正确执行下面的操作
        if ($validator->fails())
        {
            return response()->json(['serverTime'=>time(),'ServerNo'=>8,'ResultData'=>['Message'=>'标题长度不能超过60个字，工程简介不能低于4个字']]);
        }else{
            //创建插入方法
            $business=new \App\Business();
            $uesrs=new \App\Users();
            $business_data=[
                'users_id' => $param['uid'],
                'title' => $param['title'],
                'type' => $param['type'],
                'created_at' => strtotime($data['time']),
                'content' => $param['content'],
                'tag' => $param['tag'],
            ];
        }


    }

    /*
    *   该方法是向APP提供类型与标签
    */
    public function typetag()
    {
        //创建类型的orm模型
        $business_type=new \App\business_type();
        //创建标签的orm模型
        $business_tag=new \App\business_tag();
        //取出所有类型
        $business_type_data=$business_type->quer(['id','title'])->toArray();
        foreach ($business_type_data as $value) {
            foreach ($value as $value_data) {
                //因为取出的是数组所以要判断是否为id
                if(is_numeric($value_data)){
                    //取出所有标签
                    $business_tag_data=$business_tag->quer('title',$value_data)->toArray();
                    foreach ($business_tag_data as $business_tag_value) {
                        foreach ($business_tag_value as $business_tag_value1) {
                            $business_tag_data_value[]=$business_tag_value1;
                        }
                    }
                }else {
                    //通过拼接和组合将数据变成合格的json
                    $typetag_array[]=['type'=>$value_data,'tag'=>$business_tag_data_value];
                    $business_tag_data_value="";
                }
            }
        }
        //假如没有查出数据
        if(empty($typetag_array)){
            return response()->json(['serverTime'=>time(),'ServerNo'=>8,'ResultData'=>['Message'=>"查询失败"]]);
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$typetag_array]);
        }
    }
}
