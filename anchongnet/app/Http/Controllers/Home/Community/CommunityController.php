<?php

namespace App\Http\Controllers\Home\Community;

use App\Community_comment;
use App\Community_release;
use App\Community_reply;
use App\Http\Controllers\Home\CommonController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;

/*
 * 社区前端控制器
 */
class CommunityController extends CommonController
{
    /*
     * 社区首页
     */
    public function index()
    {
        $page = Input::get(['page']);
        $chat = Cache::remember('chat'.$page,'600',function (){
            return Community_release::orderBy('created_at','desc')->paginate(12);
        });
        //通过id查询并统计评论数
        foreach ($chat as $value){
            $id = $value -> chat_id;
            $cnum[$id]= Cache::remember('cnum'.$id,'600',function ()use($id){
               return Community_comment::where('chat_id',$id)->count();
            });
        }
        return view('home/community/index',compact('chat','cnum'));
    }
    /*
     * 社区详情页面
     */
    public function show($chat_id)
    {
        //获取主题
        $info    = Community_release::find($chat_id);
        //获取评论
        $comment = Community_comment::where('chat_id',$chat_id)->orderBy('comid','desc')->get();
        //评论数
        $num = count($comment);
        foreach ($comment as $value){
            $comid = $value -> comid;
            $replay[$comid]  = Community_reply::where('comid',$comid)->orderBy('reid','desc')->get();
        }
        return view('home/community/chat',compact('info','comment','replay','num'));
    }

   /*
    * 闲聊页面
    */
    public function talk()
    {
        $page = Input::get(['page']);
        $talk = Cache::remember('talk'.$page,'600',function (){
            return Community_release::where('tags','闲聊')->orderBy('created_at','desc')->paginate(12);
        });
        foreach ($talk as $value){
            $id = $value -> chat_id;
            $tnum[$id] =Cache::remember('tnum'.$id,'600',function () use($id){
                return Community_comment::where('chat_id',$id)->count();
            });
        }
        return view('home/community/talk',compact('talk','tnum'));
    }
    /*
     * 问答页面
     */
    public function question()
    {
        $page = Input::get(['page']);
        $question = Cache::remember('question'.$page,'600',function (){
            return Community_release::where('tags','问问')->orderBy('created_at','desc')->paginate(12);
        });
        foreach ($question as $value){
            $id = $value -> chat_id;
            $qnum[$id] =Cache::remember('qnum'.$id,'600',function () use($id){
                return Community_comment::where('chat_id',$id)->count();
            });
        }
        return view('home/community/question',compact('question','qnum'));
    }
    /*
     * 活动页面
     */
    public function activity()
    {
        $page = Input::get(['page']);
        $activity = Cache::remember('activity'.$page,'600',function (){
           return Community_release::where('tags','活动')->orderBy('created_at','desc')->paginate(12);
        });
        foreach ($activity as $value){
            $id = $value -> chat_id;
            $anum[$id] =Cache::remember('anum'.$id,'600',function () use($id){
                return Community_comment::where('chat_id',$id)->count();
            });
        }
        return view('home/community/activity',compact('activity','anum'));
    }
    /*
     * 提交主题评论
     */
    public function store()
    {
        $input = Input::except('_token');
        $re = Community_comment::create($input);
        if($re){
            $msg =[
                'status' => 0,
                'msg' => '发表评论成功'
            ];
        }else{
            $msg =[
                'status' => 1,
                'msg' => '发表评论失败，请稍后再试'
            ];
        }
        return $msg;
    }
}
