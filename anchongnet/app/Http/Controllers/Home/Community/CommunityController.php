<?php

namespace App\Http\Controllers\Home\Community;

use App\Community_comment;
use App\Community_release;
use App\Community_reply;
use App\Http\Controllers\Home\CommonController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Auth;

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
        $chat = Cache::remember('chat'.$page,600,function (){
            return Community_release::orderBy('created_at','desc')->paginate(12);
        });
        //通过id查询并统计评论数
        foreach ($chat as $value){
            $id = $value -> chat_id;
            $cnum[$id]= Cache::remember('cnum'.$id,600,function ()use($id){
               return Community_comment::where('chat_id',$id)->count();
            });
        }
        return view('home/community/index',compact('chat','cnum'));
    }
    /*
     * 社区详情页面
     */
    public function show($chat_id=null)
    {
        //获取主题
        $cminfo = Cache::tags('cminfo')->remember('cminfo'.$chat_id,600,function () use($chat_id){
            return Community_release::find($chat_id);
        });
        if (!$cminfo) {
            abort(404);
        }
        //获取评论
        $cmcomment = Cache::tags('cmcomment')->remember('cmcomment'.$chat_id,600,function () use ($chat_id){
           return Community_comment::where('chat_id',$chat_id)->orderBy('comid','desc')->get();
        });
        //评论数
        $cmnum = count($cmcomment);
        //对评论的回复
        foreach ($cmcomment as $value){
            $comid = $value -> comid;
            $cmreplay[$comid]  =  Community_reply::where('comid',$comid)->orderBy('reid','desc')->get();
        }
        return view('home/community/chat',compact('cminfo','cmcomment','cmreplay','cmnum'));
    }

   /*
    * 闲聊列表页面
    */
    public function talk()
    {
        $page = Input::get(['page']);
        $talk = Cache::tags('talk')->remember('talk'.$page,600,function (){
            return Community_release::where('tags','闲聊')->orderBy('created_at','desc')->paginate(12);
        });
        foreach ($talk as $value){
            $id = $value -> chat_id;
            $tnum[$id] =Cache::tags('tnum')->remember('tnum'.$id,600,function () use($id){
                return Community_comment::where('chat_id',$id)->count();
            });
        }
        return view('home/community/talk',compact('talk','tnum'));
    }
    /*
     * 问问列表页面
     */
    public function question()
    {
        $page = Input::get(['page']);
        $question = Cache::tags('question')->remember('question'.$page,'600',function (){
            return Community_release::where('tags','问问')->orderBy('created_at','desc')->paginate(12);
        });
        //评论
        foreach ($question as $value){
            $id = $value -> chat_id;
            $qnum[$id] =Cache::tags('qnum')->remember('qnum'.$id,'600',function () use($id){
                return Community_comment::where('chat_id',$id)->count();
            });
        }
        return view('home/community/question',compact('question','qnum'));
    }
    /*
     * 活动列表页面
     */
    public function activity()
    {
        $page = Input::get(['page']);
        $activity = Cache::tags('activity')->remember('activity'.$page,'600',function (){
           return Community_release::where('tags','活动')->orderBy('created_at','desc')->paginate(12);
        });
        foreach ($activity as $value){
            $id = $value -> chat_id;
            $anum[$id] =Cache::tags('anum')->remember('anum'.$id,'600',function () use($id){
                return Community_comment::where('chat_id',$id)->count();
            });
        }
        return view('home/community/activity',compact('activity','anum'));
    }
    /*
     * 提交一条评论
     */
    public function store()
    {
        $user = Auth::user();
        if (!$user) {
            return $msg =['status' => 1,'msg' => '先登录再说'];
        }
        if (!Input::get('content')) {
            return $msg =['status' => 1,'msg' => '评论为空'];
        }
        //ubb处理,因手持端不支持，故注释之
        //Input::offsetSet('content',$this->ubb(Input::get('content')));
        $re = Community_comment::create(Input::all());
        if ($re) {
            $msg =['status' => $re->getAttribute('comid'),'msg' => '发表评论成功'];
            //删除有关缓存
          Cache::tags('cmcomment')->forget('cmcomment'.Input::get('chat_id'));
        } else {
            $msg =['status' => 1,'msg' => '今日发布过多哦'];
        }
        return $msg;
    }
    /*
     * 提交回复信息
     */
    public function replay()
    {
        $user = Auth::user();
        if (!$user) {
            return $msg =['status' => 1,'msg' => '先登录再说'];
        }
        if (!Input::get('content')) {
            return $msg =['status' => 1,'msg' => '不能为空!'];
        }
        //ubb处理,因手持端不支持，故注释之
        //Input::offsetSet('content',$this->ubb(Input::get('content')));
        $re = Community_reply::create(Input::all());
        if ($re) {
            $msg =['status' => 0,'msg' => '发表评论成功'];
            //删除有关缓存
            Cache::tags('cmcomment')->forget('cmcomment'.Input::get('chat_id'));
        } else {
            $msg =['status' => 1,'msg' => '今日发布过多哦'];
        }
        return $msg;
    }
    /**
     * Ubb码服务端替换
     * @param unknown $str
     */
    private function ubb($str)
    {
        //$str = str_replace( ">", '<；', $str );
        //$str = str_replace( "\n", '>；br/>；', $str );
        $str = preg_replace ( "#\[em_([0-9]*)\]#", "<img src=\"/home/org/qqface/face/$1.gif\" />", $str );
        return $str;
    }
}
