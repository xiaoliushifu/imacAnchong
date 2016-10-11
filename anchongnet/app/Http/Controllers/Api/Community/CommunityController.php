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
    //定义变量
    private $user;
    private $propel;
    private $community_release;
    //初始化orm
    public function __construct(){
		$this->propel=new \App\Http\Controllers\admin\Propel\PropelmesgController();
		$this->user=new \App\Users();
        $this->community_release=new \App\Community_release();
	}

    /*
    *   该方法提供了聊聊发布的功能
    */
    public function release(Request $request)
    {
        try {
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
            if ($validator->fails()) {
                $messages = $validator->errors();
                if ($messages->has('title')) {
        				//如果验证失败,返回验证失败的信息
        			    return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'标题不能超过60个字']]);
        			} elseif ($messages->has('content')) {
        				return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'内容不能低于2个字']]);
        			} else {
                        return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'聊聊发布失败']]);
                }
            } else {
                //创建用户表通过电话查询出用户电话
                $users_message=new \App\Usermessages();
                $users_nickname=$users_message->quer(['nickname','headpic'],['users_id'=>$data['guid']])->toArray();
                //判断用户信息表中是否有联系人姓名
                try{
                    if(!$users_nickname[0]['nickname']){
                        return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'请完善个人信息中的昵称']]);
                    }
                }catch (\Exception $e) {
                    return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'请完善个人信息中的昵称']]);
                }
                $tags_arr=explode(' ',$param['tags']);
                $tags="";
                if(!empty($tags_arr)){
                    foreach ($tags_arr as $tag_arr) {
                        $tags.=bin2hex($tag_arr)." ";
                    }
                }
                //头像信息
                if(empty($users_nickname[0]['headpic'])){
                    $headpic="";
                }else{
                    $headpic=$users_nickname[0]['headpic'];
                }
                //定义图片变量
                $imgs="";
                //判断是否有图片
                if($param['pic']){
                    foreach ($param['pic'] as $pic) {
                        $urls = str_replace('.oss-','.img-',$pic);
                        $imgs.=$urls.'#@#';
                    }
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
                    'img' => $imgs,
                ];
                //创建ORM模型
                $community_release=new \App\Community_release();
                $result=$community_release->add($community_data);
                //插入成功继续插图片，插入失败则返回错误信息
                if($result){
                    return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'聊聊发布成功']]);
                }else{
                    return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'请重新发布聊聊']]);
                }

            }
        } catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   聊聊评论
    */
    public function comment(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //验证用户传过来的数据是否合法
            $validator = Validator::make($param,
                [
                    'content' => 'required|max:500',
                ]
            );
            //如果出错返回出错信息，如果正确执行下面的操作
            if ($validator->fails()) {
                return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'评论不能超过500个字']]);
            } else {
                //创建用户表通过电话查询出用户电话
                $users_message=new \App\Usermessages();
                $users_nickname=$users_message->quer(['account','nickname','headpic'],['users_id'=>$data['guid']])->toArray();
                //判断用户信息表中是否有联系人姓名
                try{
                    if(!$users_nickname[0]['nickname']){
                        return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'请完善个人信息中的昵称']]);
                    }
                }catch (\Exception $e) {
                    return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'请完善个人信息中的昵称']]);
                }
                //头像信息
                if(empty($users_nickname[0]['headpic'])){
                    $headpic="";
                }else{
                    $headpic=$users_nickname[0]['headpic'];
                }
                //定义插入数据库的数据
                $community_data=[
                    'name' => $users_nickname[0]['nickname'],
                    'content' => $param['content'],
                    'users_id' => $data['guid'],
                    'created_at' => date('Y-m-d H:i:s',$data['time']),
                    'headpic' => $headpic,
                    'chat_id' => $param['chat_id']
                ];
                //创建ORM模型
                $community_comment=new \App\Community_comment();
                $ture=$community_comment->add($community_data);
                if($ture){
                    //更新评论数量
                    DB::table('anchong_community_release')->where('chat_id','=',$param['chat_id'])->increment('comnum',1);
                    try{
                        //推送消息
                        $this->propel->apppropel($users_nickname[0]['account'],'聊聊评论',$users_nickname[0]['nickname'].'  评论了您的聊聊:'.$param['title']);
                    }catch (\Exception $e) {
                        //查出第一张图片
                        $picstr=$this->community_release->find($param['chat_id'])->img;
                        $img="";
                        //判断是否有图片并进行操作
                        if(strlen($picstr)>10){
                            $img_arr=explode('#@#',trim($picstr));
                            $img=$img_arr[0];
                        };
                        //将标题和图片放入数组
                        $community_data['users_id']=$param['users_id'];
                        $community_data['title']=$param['title'];
                        $community_data['img']=$img;
                        //插入聊聊信息提示表
                        DB::table('anchong_community_message')->insertGetId($community_data);
                        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'评论成功']]);
                    }
                    //查出第一张图片
                    $picstr=$this->community_release->find($param['chat_id'])->img;
                    $img="";
                    //判断是否有图片并进行操作
                    if(strlen($picstr)>10){
                        $img_arr=explode('#@#',trim($picstr));
                        $img=$img_arr[0];
                    };
                    //将标题和图片放入数组
                    $community_data['users_id']=$param['users_id'];
                    $community_data['title']=$param['title'];
                    $community_data['img']=$img;
                    //插入聊聊信息提示表
                    DB::table('anchong_community_message')->insertGetId($community_data);
                    return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'评论成功']]);
                }else{
                    return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'评论失败']]);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   聊聊评论回复
    */
    public function reply(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //验证用户传过来的数据是否合法
            $validator = Validator::make($param,
                [
                    'content' => 'required|max:500',
                ]
            );
            //如果出错返回出错信息，如果正确执行下面的操作
            if ($validator->fails()) {
                return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'评论不能超过500个字']]);
            } else {
                //创建用户表通过电话查询出用户电话
                $users_message=new \App\Usermessages();
                $users_nickname=$users_message->quer(['account','nickname','headpic'],['users_id'=>$data['guid']])->toArray();
                //判断用户信息表中是否有联系人姓名
                try{
                    if(!$users_nickname[0]['nickname']){
                        return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'请完善个人信息中的昵称']]);
                    }
                }catch (\Exception $e) {
                    return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'请完善个人信息中的昵称']]);
                }
                //头像信息
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
                    'users_id' => $data['guid'],
                    'comid' => $param['comid'],
                    'chat_id' =>$param['chat_id'],
                    'comname' =>$param['name'],
                ];
                //创建ORM模型
                $community_reply=new \App\Community_reply();
                $ture=$community_reply->add($community_data);
                if($ture){
                    try{
                        //推送消息
                        $this->propel->apppropel($users_nickname[0]['account'],'聊聊评论回复',$users_nickname[0]['nickname'].'  回复了您的评论:'.$param['reply_content']);
                    }catch (\Exception $e) {
                        //查出第一张图片与标题
                        $handle=$this->community_release->find($param['chat_id']);
                        $picstr=$handle->img;
                        $img="";
                        //判断是否有图片并进行操作
                        if(strlen($picstr)>10){
                            $img_arr=explode('#@#',trim($picstr));
                            $img=$img_arr[0];
                        };
                        //将用户id,标题和图片放入数组
                        $community_data['users_id']=$param['users_id'];
                        $community_data['title']=$handle->title;
                        $community_data['img']=$img;
                        unset($community_data['comid']);
                        unset($community_data['comname']);
                        //插入聊聊信息提示表
                        DB::table('anchong_community_message')->insertGetId($community_data);
                        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'回复成功']]);
                    }
                    //查出第一张图片与标题
                    $handle=$this->community_release->find($param['chat_id']);
                    $picstr=$handle->img;
                    $img="";
                    //判断是否有图片并进行操作
                    if(strlen($picstr)>10){
                        $img_arr=explode('#@#',trim($picstr));
                        $img=$img_arr[0];
                    };
                    //将用户id,标题和图片放入数组
                    $community_data['users_id']=$param['users_id'];
                    $community_data['title']=$handle->title;
                    $community_data['img']=$img;
                    unset($community_data['comid']);
                    unset($community_data['comname']);
                    //插入聊聊信息提示表
                    DB::table('anchong_community_message')->insertGetId($community_data);
                    return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'回复成功']]);
                }else{
                    return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'回复失败']]);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   聊聊显示
    */
    public function communityshow(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //默认每页数量
            $limit=20;
            //创建orm模型
            $community_release=new \App\Community_release();
            //查询数据
            $community_release_data=['chat_id','title','name','content','created_at','tags','headpic','comnum','img'];
            //判断是否是筛选
            if (empty($param['tags'])) {
                $sql="auth = 1";
            } else {
                $sql="MATCH(tags_match) AGAINST('".bin2hex($param['tags'])."') and auth = 1";
            }
            $community_release_result=$community_release->quer($community_release_data,$sql,(($param['page']-1)*$limit),$limit);
            //定义结果列表数组
            $list=null;
            //判断是否取出数据
            if ($community_release_result['total']>0) {
                //遍历聊聊数组
                foreach ($community_release_result['list'] as $release_results) {
                    //进行图片分隔操作
                    $img=trim($release_results['img'],"#@#");
                    //判断是否有图片
                    if (!empty($img)) {
                        $img_arr=explode('#@#',$img);
                        $release_results['pic']=$img_arr;
                    }
                    $list[]=$release_results;
                }
                //返回数据总数和具体数据
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['total'=>$community_release_result['total'],'list'=>$list]]);
            } else {
                return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>"查询失败"]]);
            }
        } catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   我的聊聊显示
    */
    public function mycommunity(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //默认每页数量
            $limit=20;
            //创建的orm模型
            $community_release=new \App\Community_release();
            //查询数据
            $community_release_data=['chat_id','title','name','content','created_at','tags','headpic','comnum','img'];
            //判断是否是筛选
            if (empty($param['tags'])) {
                $sql="users_id =".$data['guid']." and auth = 1";
            } else {
                $sql="users_id =".$data['guid']." and MATCH(tags_match) AGAINST('".bin2hex($param['tags'])."') and auth= 1";
            }
            $community_release_result=$community_release->quer($community_release_data,$sql,(($param['page']-1)*$limit),$limit);
            //定义结果列表数组
            $list=null;
            if ($community_release_result['total']>0) {
                //遍历聊聊数组
                foreach ($community_release_result['list'] as $release_results) {
                    $img=trim($release_results['img'],"#@#");
                    if (!empty($img)) {
                        $img_arr=explode('#@#',$img);
                        $release_results['pic']=$img_arr;
                    }
                    $list[]=$release_results;
                }
                //返回数据总数和具体数据
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['total'=>$community_release_result['total'],'list'=>$list]]);
            } else {
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['total'=>0,'list'=>[]]]);
            }
        } catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   该方法提供聊聊详情查询
    */
    public function communityinfo(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //创建ORM模型
            $community_release=new \App\Community_release();
            $community_collect=new \App\Community_collect();
            //定义需要的数据
            $community_release_data=['chat_id','users_id','headpic','name','created_at','title','tags','content','img'];
            //查询聊聊内容
            $community_release_result=$community_release->simplequer($community_release_data,'chat_id ='.$param['chat_id'])->toArray();
            //查询是否已收藏
            $count=$community_collect->countquer('users_id ='.$data['guid'].' and chat_id = '.$param['chat_id']);
            //定义结果
            $list=null;
            $img=null;
            if ($count>0) {
                $list['collresult']=1;
            } else {
                $list['collresult']=0;
            }
            //判断是否查到该条聊聊
            if (!empty($community_release_result)) {
                //将数据组合
                foreach ($community_release_result[0] as $key =>$release_result) {
                    $list[$key]=$release_result;
                }
                //进行图片操作
                $img=trim($community_release_result[0]['img'],"#@#");
                //判断是否有图片
                if (!empty($img)) {
                    $img_arr=explode('#@#',$img);
                    $list['pic']=$img_arr;
                }
                if (!empty($list)) {
                    return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$list]);
                } else {
                    return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>"查看详情失败，请刷新"]]);
                }
            } else {
                return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>"查看详情失败，请刷新"]]);
            }
        } catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   该方法提供聊聊详情评论查看
    */
    public function communitycom(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //默认每页数量
            $limit=10;
            //创建ORM模型
            $community_comment=new \App\Community_comment();
            $community_reply=new \App\Community_reply();
            $community_comment_data=['comid','users_id','name','headpic','content','created_at'];
            //定义评论数组
            $commentlist=null;
            $community_comment_results=$community_comment->quer($community_comment_data,'chat_id = '.$param['chat_id'],(($param['page']-1)*$limit),$limit);
            if ($community_comment_results['total'] > 0 ) {
                foreach ($community_comment_results['list'] as $commentarr) {
                    //查询评论回复
                    $community_reply_result=$community_reply->quer(['reid','users_id','name','content','comname'],"comid = ".$commentarr['comid'],0,2)->toArray();
                    //在评论内容数组中添加回复内容
                    $commentarr['reply']=$community_reply_result;
                    //组合数组
                    $commentlist[]=$commentarr;
                }
            }
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['total'=>$community_comment_results['total'],'list'=>$commentlist]]);
        } catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   该方法提供聊聊评论详情查询
    */
    public function commentinfo(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //创建ORM模型
            $community_comment=new \App\Community_comment();
            $community_reply=new \App\Community_reply();
            $community_comment_data=['comid','users_id','name','headpic','content','created_at'];
            $community_reply_data=['reid','users_id','name','content','headpic','created_at','comname'];
            //查询评论
            $community_comment_results=$community_comment->simplequer($community_comment_data,'comid = '.$param['comid'])->toArray();
            $community_reply_result=$community_reply->simplequer($community_reply_data,'comid = '.$param['comid'])->toArray();
            foreach ($community_comment_results as $result) {
                $result['reply']=$community_reply_result;
            }
            if (!empty($result) && !empty($community_reply_result)) {
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$result]);
            } else {
                return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>"查看详情失败，请刷新"]]);
            }
        } catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   我收藏的聊聊
    */
    public function mycollect(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            $limit=10;
            //创建的orm模型
            $community_release=new \App\Community_release();
            $community_collect=new \App\Community_collect();
            //查询数据
            $community_release_data=['chat_id','title','name','content','created_at','tags','headpic','comnum','img'];
            //定义结果数组
            $results=null;
            //查询收藏的聊聊id和数量
            $community_collect_result=$community_collect->totalquer('chat_id','users_id ='.$data['guid'],(($param['page']-1)*$limit),$limit);
            if ($community_collect_result['total'] == 0) {
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['total'=>$community_collect_result['total'],'list'=>[]]]);
            }
            $chatarr=null;
            //收藏的聊聊数组
            foreach ($community_collect_result['list'] as $chat_idarr) {
                $chatarr[]=$chat_idarr['chat_id'];
            }
            //查询所有收藏聊聊
            $community_release_result=$community_release->inquer($community_release_data,'chat_id',$chatarr)->toArray();
            //遍历数组
            foreach ($community_release_result as $release_results) {
                //进行图片分隔操作
                $img=trim($release_results['img'],"#@#");
                //判断是否有图片
                if(!empty($img)){
                    $img_arr=explode('#@#',$img);
                    $release_results['pic']=$img_arr;
                }
                //将结果数组填充
                $result[]=$release_results;
            }
            if($result){
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['total'=>$community_collect_result['total'],'list'=>$result]]);
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>"查询失败，请刷新"]]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   聊聊消息提示
    */
    public function message(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //查出数据
            $message_result=DB::table('anchong_community_message')->where('users_id',$data['guid'])->get();
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$message_result]);
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   聊聊消息统计
    */
    public function countmessage(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //查出数据
            $count=DB::table('anchong_community_message')->where('users_id',$data['guid'])->count();
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$count]);
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   聊聊消息删除
    */
    public function delmessage(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //删除数据
            $result=DB::table('anchong_community_message')->where('cm_id',$param['cm_id'])->delete();
            //判断是否删除成功
            if($result){
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'删除成功']]);
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'删除失败']]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   该方法提供收藏聊聊
    */
    public function addcollect(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //创建ORM模型
            $community_collect=new \App\Community_collect();
            $community_data=[
                'chat_id' => $param['chat_id'],
                'users_id' => $data['guid'],
                'created_at' => date('Y-m-d H:i:s',$data['time'])
            ];
            //查询是否已收藏
            $count=$community_collect->countquer('users_id ='.$data['guid'].' and chat_id = '.$param['chat_id']);
            //判断聊聊是否收藏
            if ($count > 0) {
                return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'该聊聊已收藏']]);
            } else {
                //收藏聊聊
                $result=$community_collect->add($community_data);
                if ($result) {
                    return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'收藏成功']]);
                } else {
                    return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'收藏失败']]);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   该方法提供聊聊取消收藏
    */
    public function delcollect(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //创建ORM模型
            $community_collect=new \App\Community_collect();
            $result=$community_collect->del('users_id ='.$data['guid'].' and chat_id = '.$param['chat_id']);
            if ($result) {
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'取消成功']]);
            } else {
                return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'取消失败']]);
            }
        } catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   该方法提供聊聊删除
    */
    public function communitydel(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //创建的orm模型
            $community_release=new \App\Community_release();
            $community_comment=new \App\Community_comment();
            $community_reply=new \App\Community_reply();
            $community_collect=new \App\Community_collect();
            //聊聊ID
            $chat_id=$param['chat_id'];
            //开启事务处理
            DB::beginTransaction();
            //将所有聊聊有关的都删除
            $community_release_result=$community_release->communitydel($chat_id);
            if($community_release_result){
                $community_comment_result=$community_comment->delcomment($chat_id);
                if($community_comment_result){
                    $community_comment_reply=$community_reply->delcomment($chat_id);
                    if($community_comment_reply){
                        $countnum=$community_collect->countquer('chat_id = '.$chat_id);
                        if($countnum > 1){
                            $result=$community_collect->del('chat_id = '.$chat_id);
                        }else{
                            $result=true;
                        }
                        if($result){
                            //将聊聊信息删除
                            DB::table('anchong_community_message')->where('chat_id',$chat_id)->delete();
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
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }
}
