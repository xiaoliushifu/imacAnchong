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
                'type' => 'required',
                'title' => 'required|max:126',
                'content' => 'required|min:4',
                'tag' => 'required',
                'pic' => 'array',
            ]
        );
        //如果出错返回出错信息，如果正确执行下面的操作
        if ($validator->fails())
        {
            return response()->json(['serverTime'=>time(),'ServerNo'=>8,'ResultData'=>['Message'=>'标题长度不能超过60个字，工程简介不能低于4个字']]);
        }else{
            //创建用户表通过电话查询出用户电话
            $users=new \App\Users();
            $users_phone=$users->quer('phone',['users_id'=>$data['guid']])->toArray();
            //判断用户数据表中是否有电话联系方式
            if($users_phone[0]['phone']){
                $users_message=new \App\Usermessages();
                $users_contact=$users_message->quer('contact',['users_id'=>$data['guid']])->toArray();
                //判断用户信息表中是否有联系人姓名
                if($users_contact[0]['contact']){
                    $business_data=[
                        'users_id' => $data['guid'],
                        'title' => $param['title'],
                        'type' => $param['type'],
                        'created_at' => date('Y-m-d H:i:s',$data['time']),
                        'content' => $param['content'],
                        'tag' => $param['tag'],
                        'phone' => $users_phone[0]['phone'],
                        'contact' => $users_contact[0]['contact']
                    ];
                    //创建插入方法
                    $business=new \App\Business();
                    $id=$business->add($business_data);
                    if($param['pic']){
                        //插入成功继续插图片，插入失败则返回错误信息
                        if(!empty($id)){
                            $ture=false;
                            foreach ($param['pic'] as $pic) {
                                $business_img=new \App\Business_img();
                                $ture=$business_img->add(['id'=>$id,'img'=> $pic]);
                            }
                            //orm模型操作数据库会返回true或false,如果操作失败则返回错误信息
                            if($ture){
                                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'发布信息成功']]);
                            }else{
                                return response()->json(['serverTime'=>time(),'ServerNo'=>8,'ResultData'=>['Message'=>'请重新发布信息']]);
                            }
                        }else{
                            return response()->json(['serverTime'=>time(),'ServerNo'=>8,'ResultData'=>['Message'=>'请重新发布信息']]);
                        }
                    }else{
                        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'发布信息成功']]);
                    }
                }else{
                    return response()->json(['serverTime'=>time(),'ServerNo'=>8,'ResultData'=>['Message'=>'请完善个人信息中的联系方式']]);
                }
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>8,'ResultData'=>['Message'=>'请完善个人信息中的联系方式']]);
            }
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
                    $business_tag_data_value=null;
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

    /*
    *   该方法提供商机查询
    */
    public function businessinfo(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //默认每页数量
        $limit=20;
        //创建商机表的orm模型
        $business=new \App\Business();
        $businessinfo=array('id','phone','contact','title','content','tag','created_at');
        $businessinfo_data=$business->quer($businessinfo,$param['type'],(($param['page']-1)*$limit),$limit);
        $list=null;
        if($businessinfo_data){
            //创建图片查询的orm模型
            $business_img=new \App\Business_img();
            //通过数组数据的组合将数据拼凑为{"total":3,"list":[{"id":1,"phone":"","contact":"","title":"","content":"","tag":"","created_at":"2016-02-24 08:02:50","pic":["1","2"]}格式
            foreach ($businessinfo_data['list'] as $business_data) {
                $value_1=$business_img->quer('img',$business_data['id']);
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
            //返回数据总数和具体数据
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['total'=>$businessinfo_data['total'],'list'=>$list]]);
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>8,'ResultData'=>['Message'=>"查询失败"]]);
        }
    }
}
