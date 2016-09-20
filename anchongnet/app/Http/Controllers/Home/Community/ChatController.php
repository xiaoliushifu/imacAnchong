<?php

namespace App\Http\Controllers\Home\Community;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ChatController extends Controller
{
    //发布聊聊页面
    public function index()
    {
        return view('home/release/releasechat');
    }
}
