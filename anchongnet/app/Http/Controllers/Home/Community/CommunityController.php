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
    public function index()
    {
        $chat = Community_release::orderBy('created_at','desc')->paginate(12);

        return view('home/community/index',compact('chat'));
    }

    public function chat($chat_id)
    {
        $info    = Community_release::find($chat_id);
        $comment = Community_comment::where('chat_id',$chat_id)->get();
        $replay  = Community_reply::where('chat_id',$chat_id)->get();
        return view('home/community/chat',compact('info','comment','replay'));
    }
}
