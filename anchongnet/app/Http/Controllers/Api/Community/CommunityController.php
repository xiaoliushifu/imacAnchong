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
    *   该方法提供了聊聊发布的功能
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
                    DB::table('anchong_community_release')->where('chat_id','=',$param['chat_id'])->increment('comnum',1);
                    return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'评论成功']]);
                }else{
                    return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'评论失败']]);
                }
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'请完善个人信息中的昵称']]);
            }
        }
    }

    /*
    *   聊聊评论回复
    */
    public function reply(Request $request)
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
                    'comid' => $param['comid'],
                    'chat_id' =>$param['chat_id'],
                    'comname' =>$param['name'],
                ];
                //创建ORM模型
                $community_reply=new \App\Community_reply();
                $ture=$community_reply->add($community_data);
                if($ture){
                    return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'回复成功']]);
                }else{
                    return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'回复失败']]);
                }
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'请完善个人信息中的昵称']]);
            }
        }
    }

    /*
    *   聊聊显示
    */
    public function communityshow(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //默认每页数量
        $limit=20;
        //创建orm模型
        $community_release=new \App\Community_release();
        //查询数据
        $community_release_data=['chat_id','title','name','content','created_at','tags','headpic','comnum'];
        //判断是否是筛选
        if(empty($param['tags'])){
            $sql="auth =1";
        }else{
            $sql="MATCH(tags_match) AGAINST('".bin2hex($param['tags'])."') and auth=1";
        }
        $community_release_result=$community_release->quer($community_release_data,$sql,(($param['page']-1)*$limit),$limit);
        //定义结果列表数组
        $list=null;
        if($community_release_result){
            //创建图片查询的orm模型
            $community_img=new \App\Community_img();
            foreach ($community_release_result['list'] as $community_data){
                $value_1=$community_img->quer('img',$community_data['chat_id']);
                //判断是否为空,如果是空表明没有图片
                if(empty($value_1)){
                    $list[]=$community_data;
                }else{
                    //假如不为空表明有图片，开始查询拼凑数据
                    foreach ($value_1 as $value_2) {
                        foreach ($value_2 as $value_3) {
                            $img[]=$value_3;
                        }
                    }
                    //重构数组，加上键值
                    $img_data=['pic'=>$img];
                    $list[]=array_merge($community_data,$img_data);
                    $img=null;
                }
            }
            //返回数据总数和具体数据
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['total'=>$community_release_result['total'],'list'=>$list]]);
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>8,'ResultData'=>['Message'=>"查询失败"]]);
        }
    }

    /*
    *   我的聊聊显示
    */
    public function mycommunity(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //默认每页数量
        $limit=20;
        //创建的orm模型
        $community_release=new \App\Community_release();
        //查询数据
        $community_release_data=['chat_id','title','name','content','created_at','tags','headpic','comnum'];
        //判断是否是筛选
        if(empty($param['tags'])){
            $sql="users_id =".$data['guid']." and auth =1";
        }else{
            $sql="users_id =".$data['guid']." and MATCH(tags_match) AGAINST('".bin2hex($param['tags'])."') and auth=1";
        }
        $community_release_result=$community_release->quer($community_release_data,$sql,(($param['page']-1)*$limit),$limit);
        //定义结果列表数组
        $list=null;
        if($community_release_result){
            //创建图片查询的orm模型
            $community_img=new \App\Community_img();
            foreach ($community_release_result['list'] as $community_data){
                $value_1=$community_img->quer('img',$community_data['chat_id']);
                //判断是否为空,如果是空表明没有图片
                if(empty($value_1)){
                    $list[]=$community_data;
                }else{
                    //假如不为空表明有图片，开始查询拼凑数据
                    foreach ($value_1 as $value_2) {
                        foreach ($value_2 as $value_3) {
                            $img[]=$value_3;
                        }
                    }
                    //重构数组，加上键值
                    $img_data=['pic'=>$img];
                    $list[]=array_merge($community_data,$img_data);
                    $img=null;
                }
            }
            //返回数据总数和具体数据
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['total'=>$community_release_result['total'],'list'=>$list]]);
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>8,'ResultData'=>['Message'=>"查询失败"]]);
        }
    }

    /*
    *   该方法提供聊聊详情查询
    */
    public function communityinfo(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //创建ORM模型
        $community_release=new \App\Community_release();
        $community_img=new \App\Community_img();
        //定义需要的数据
        $community_release_data=['chat_id','headpic','name','created_at','title','tags','content'];
        //查询聊聊内容
        $community_release_result=$community_release->simplequer($community_release_data,'chat_id ='.$param['chat_id'])->toArray();
        //定义结果
        $list=null;
        $img=null;
        //判断是否查到该条聊聊
        if(!empty($community_release_result)){
            $community_img_result=$community_img->quer('img',$param['chat_id']);
            //将数据组合
            foreach ($community_release_result[0] as $key =>$release_result) {
                $list[$key]=$release_result;
            }
            //判断是否有图片
            if(empty($community_img_result)){
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$list]);
            }else{
                //假如不为空表明有图片，开始查询拼凑数据
                foreach ($community_img_result as $value_2) {
                    foreach ($value_2 as $value_3) {
                        $img[]=$value_3;
                    }
                }
                //重构数组，加上键值
                $list['pic']=$img;
            }
            if(!empty($list)){
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$list]);
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>"查看详情失败，请刷新"]]);
            }
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>"查看详情失败，请刷新"]]);
        }
    }

    /*
    *   该方法提供聊聊详情评论查看
    */
    public function communitycom(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //默认每页数量
        $limit=10;
        //创建ORM模型
        $community_comment=new \App\Community_comment();
        $community_reply=new \App\Community_reply();
        $community_comment_data=['comid','name','headpic','content','created_at'];
        //定义评论数组
        $commentlist=null;
        $community_comment_results=$community_comment->quer($community_comment_data,'chat_id = '.$param['chat_id'],(($param['page']-1)*$limit),$limit);
        if($community_comment_results['total'] > 0 ){
            foreach ($community_comment_results['list'] as $commentarr) {
                //查询评论回复
                $community_reply_result=$community_reply->quer(['reid','name','content','comname'],"comid = ".$commentarr['comid'],0,2)->toArray();
                //在评论内容数组中添加回复内容
                $commentarr['reply']=$community_reply_result;
                //组合数组
                $commentlist[]=$commentarr;
            }
        }
        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['total'=>$community_comment_results['total'],'list'=>$commentlist]]);
    }
    /*
    *   该方法提供聊聊评论详情查询
    */
    public function commentinfo(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //创建ORM模型
        $community_comment=new \App\Community_comment();
        $community_reply=new \App\Community_reply();
        $community_comment_data=['comid','name','headpic','content','created_at'];
        $community_reply_data=['reid','name','content','headpic','created_at','comname'];
        //查询评论
        $community_comment_results=$community_comment->simplequer($community_comment_data,'comid = '.$param['comid'])->toArray();
        $community_reply_result=$community_reply->simplequer($community_reply_data,'comid = '.$param['comid'])->toArray();
        foreach ($community_comment_results as $result) {
            $result['reply']=$community_reply_result;
        }
        if(!empty($result) && !empty($community_reply_result)){
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$result]);
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>"查看详情失败，请刷新"]]);
        }
    }

    /*
    *   该方法提供聊聊删除
    */
    public function communitydel(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //创建的orm模型
        $community_release=new \App\Community_release();
        $community_img=new \App\Community_img();
        $community_comment=new \App\Community_comment();
        $community_reply=new \App\community_reply();
        //开启事务处理
        DB::beginTransaction();
        $community_release_result=$community_release->communitydel($param['chat_id']);
        if($community_release_result){
            $community_img_result=$community_img->delimg($param['chat_id']);
            if($community_img_result){
                $community_comment_result=$community_comment->delcomment($param['chat_id']);
                if($community_comment_result){
                    $community_comment_reply=$community_reply->delcomment($param['chat_id']);
                    if($community_comment_reply){
                        //假如成功就提交
                        DB::commit();
                        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'删除成功']]);
                    }else{
                        //假如失败就回滚
                        DB::rollback();
                        return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'删除失败']]);
                    }
                }else{
                    //假如失败就回滚
                    DB::rollback();
                    return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'删除失败']]);
                }
            }else{
                //假如失败就回滚
                DB::rollback();
                return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'删除失败']]);
            }
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'删除失败']]);
        }
    }
}
