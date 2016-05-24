<?php

namespace App\Http\Controllers\Api\Community;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Request;
use DB;
use Validator;

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
            return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'请填写完整，并且标题长度不能超过60个字，内容不能低于2个字']]);
        }else{
            //创建用户表通过电话查询出用户电话
            $users_message=new \App\Usermessages();
            $users_nickname=$users_message->quer(['nickname','headpic'],['users_id'=>$data['guid']])->toArray();
            //判断用户信息表中是否有联系人姓名
            if(!empty($users_nickname)){
                $tags_arr=explode(' ',$param['tags']);
                $tags="";
                if(!empty($tags_arr)){
                    foreach ($tags_arr as $tag_arr) {
                        $tags.=bin2hex($tag_arr)." ";
                    }
                }
                if(empty($users_nickname[0]['headpic'])){
                    $headpic="";
                }else{
                    $headpic=$users_nickname[0]['headpic'];
                }
                //定义插入数据库的数据
                $community_data=[
                    'users_id' => $data['guid'],
                    'title' => $param['title'],
                    'name' => $users_nickname[0]['nickname'],
                    'content' => $param['content'],
                    'created_at' => date('Y-m-d H:i:s',$data['time']),
                    'headpic' => $headpic,
                    'tags' => $param['tags'],
                    'tags_match' => $tags,
                ];
                //开启事务处理
                DB::beginTransaction();
                //创建ORM模型
                $community_release=new \App\Community_release();
                $id=$community_release->add($community_data);
                //插入成功继续插图片，插入失败则返回错误信息
                if(!empty($id)){
                    if($param['pic']){
                        $ture=false;
                        foreach ($param['pic'] as $pic) {
                            $community_img=new \App\Community_img();
                            $ture=$community_img->add(['chat_id'=>$id,'img'=> $pic]);
                            //假如有一张图片插入失败就返回错误
                            if(!$ture){
                                //假如失败就回滚
                                DB::rollback();
                                return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'聊聊发布失败,请重新发布']]);
                            }
                        }
                        //orm模型操作数据库会返回true或false,如果操作失败则返回错误信息
                        if($ture){
                            //假如成功就提交
                            DB::commit();
                            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'聊聊发布成功']]);
                        }else{
                            //假如失败就回滚
                            DB::rollback();
                            return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'请重新发布聊聊']]);
                        }
                    }else{
                        //假如成功就提交
                        DB::commit();
                        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'聊聊发布成功']]);
                    }
                }else{
                    //假如失败就回滚
                    DB::rollback();
                    return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'请重新发布聊聊']]);
                }
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'请完善个人信息中的昵称']]);
            }
        }
    }

    /*
    *   聊聊评论
    */
    public function comment(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //验证用户传过来的数据是否合法
        $validator = Validator::make($param,
            [
                'content' => 'required|max:126',
            ]
        );
        //如果出错返回出错信息，如果正确执行下面的操作
        if ($validator->fails())
        {
            return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'评论不能超过126个字']]);
        }else{
            //创建用户表通过电话查询出用户电话
            $users_message=new \App\Usermessages();
            $users_nickname=$users_message->quer(['nickname','headpic'],['users_id'=>$data['guid']])->toArray();
            //判断用户信息表中是否有联系人姓名
            if(!empty($users_nickname)){
                if(empty($users_nickname[0]['headpic'])){
                    $headpic="";
                }else{
                    $headpic=$users_nickname[0]['headpic'];
                }
                //定义插入数据库的数据
                $community_data=[
                    'name' => $users_nickname[0]['nickname'],
                    'content' => $param['content'],
                    'created_at' => date('Y-m-d H:i:s',$data['time']),
                    'headpic' => $headpic,
                    'chat_id' => $param['chat_id']
                ];
                //创建ORM模型
                $community_comment=new \App\Community_comment();
                $ture=$community_comment->add($community_data);
                if($ture){
                    return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'评论成功']]);
                }else{
                    return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'评论失败']]);
                }
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'请完善个人信息中的昵称']]);
            }
        }
    }

}
