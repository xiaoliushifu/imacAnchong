<?php

namespace App\Http\Controllers\Api\Community;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Request;
use DB;

/*
*   该控制器包含了社区模块的操作
*/
class CommunityController extends Controller
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
                'title' => 'required|max:120',
                'content' => 'required|min:4',
                'pic' => 'array',
            ]
        );
        //如果出错返回出错信息，如果正确执行下面的操作
        if ($validator->fails())
        {
            return response()->json(['serverTime'=>time(),'ServerNo'=>8,'ResultData'=>['Message'=>'请填写完整，并且标题长度不能超过60个字，内容不能低于2个字']]);
        }else{
            //创建用户表通过电话查询出用户电话
            $users_message=new \App\Usermessages();
            $users_nickname=$users_message->quer('nickname',['users_id'=>$data['guid']])->toArray();
            //判断用户信息表中是否有联系人姓名
            print_r($users_nickname);
            if($users_contact){

            }
        }
    }
}
