<?php

namespace App\Http\Controllers\Home\Community;

use App\Community_comment;
use App\Community_release;
use App\Community_reply;
use App\Http\Controllers\Home\CommonController;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;

/*
 * 社区前端控制器
 */
class CommunityController extends CommonController
{
    //    社区首页
    public function index()
    {
        $chat = Community_release::orderBy('created_at','desc')->paginate(12);
        //通过id查询并统计评论数
        foreach ($chat as $value){
            $id = $value -> chat_id;
            $num[$id] = Community_comment::where('chat_id',$id)->count();
        }
        return view('home/community/index',compact('chat','num'));
    }
    //社区详情页面
    public function show($chat_id)
    {
        //获取主题
        $info    = Community_release::find($chat_id);
        //获取评论
        $comment = Community_comment::where('chat_id',$chat_id)->orderBy('comid','desc')->get();
        //评论数
        $num=Community_comment::where('chat_id',$chat_id)->count();
        foreach ($comment as $value){
            $comid = $value -> comid;
            $replay[$comid]  = Community_reply::where('comid',$comid)->orderBy('comid','desc')->get();
        }
        return view('home/community/chat',compact('info','comment','replay','num'));
    }

    //闲聊
    public function talk()
    {
        $talk = Community_release::where('tags','闲聊')->orderBy('created_at','desc')->paginate(12);
        foreach ($talk as $value){
            $id = $value -> chat_id;
            $num[$id] = Community_comment::where('chat_id',$id)->count();
        }
        return view('home/community/talk',compact('talk','num'));
    }
    //问问
    public function question()
    {
        $question = Community_release::where('tags','问问')->orderBy('created_at','desc')->paginate(12);
        foreach ($question as $value){
            $id = $value -> chat_id;
            $num[$id] = Community_comment::where('chat_id',$id)->count();
        }
        return view('home/community/question',compact('question','num'));
    }
    //活动
    public function activity()
    {
        $activity = Community_release::where('tags','活动')->orderBy('created_at','desc')->paginate(12);
        foreach ($activity as $value){
            $id = $value -> chat_id;
            $num[$id] = Community_comment::where('chat_id',$id)->count();
        }
        return view('home/community/activity',compact('activity','num'));
    }
}
