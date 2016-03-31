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
            $business_data=[
                'users_id' => $param['uid'],
                'title' => $param['title'],
                'type' => $param['type'],
                'ctime' => $data['time'],
            ];
        }


    }

    /*
    *   该方法是向APP提供类型与标签
    */
    public function typetag()
    {
        $business_type=new \App\business_type();
        $business_tag=new \App\business_tag();
        $business_type_data=$business_type->quer(['id','title'])->toArray();
        foreach ($business_type_data as $value) {
            foreach ($value as $value_data) {
                if(is_numeric($value_data)){
                    $business_tag_data=$business_tag->quer('title',$value_data)->toArray();
                    foreach ($business_tag_data as $business_tag_value) {
                        foreach ($business_tag_value as $business_tag_value1) {
                            $business_tag_data_value[]=$business_tag_value1;
                        }
                    }
                }else {
                    $typetag_array[]=['type'=>$value_data,'tag'=>$business_tag_data_value];
                    $business_tag_data_value="";
                }
            }
        }
        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$typetag_array]);
    }
}
