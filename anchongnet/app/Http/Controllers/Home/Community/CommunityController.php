<?php

namespace App\Http\Controllers\Home\Community;

use App\Community_comment;
use App\Community_release;
use App\Community_reply;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

/*
 * 社区前端控制器
 */
class CommunityController extends Controller
{
//    社区首页
    public function index()
    {
        $chat = Community_release::orderBy('created_at','desc')->paginate(12);
////        从发布表中获取id
//        $chat_id = Community_release::select('chat_id')->orderBy('created_at','desc')->paginate(12);
////        通过id查询并统计评论数
//        foreach ($chat_id as $value){
//            $id = $value -> chat_id;
//            $num = Community_comment::where('chat_id',$id)->count();
//        }
        return view('home/community/index',compact('chat'));
    }
//    详情页面
    public function chat($chat_id)
    {
        $info    = Community_release::find($chat_id);
        $comment = Community_comment::where('chat_id',$chat_id)->get();
        $replay  = Community_reply::where('chat_id',$chat_id)->get();
        return view('home/community/chat',compact('info','comment','replay'));
    }
//    闲聊
    public function talk()
    {
        $talk = Community_release::where('tags','闲聊')->orderBy('created_at','desc')->paginate(12);
        return view('home/community/talk',compact('talk'));
    }
//    问问
    public function question()
    {
        $question = Community_release::where('tags','问问')->orderBy('created_at','desc')->paginate(12);
        return view('home/community/question',compact('question'));
    }
//    活动
    public function activity()
    {
        $activity = Community_release::where('tags','活动')->orderBy('created_at','desc')->paginate(12);
        return view('home/community/activity',compact('activity'));
    }
}
