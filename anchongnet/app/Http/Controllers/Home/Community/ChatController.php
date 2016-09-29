<?php

namespace App\Http\Controllers\Home\Community;

use App\Http\Controllers\Home\CommonController;


class ChatController extends CommonController
{
    //发布聊聊页面
    public function index()
    {
        return view('home/release/releasechat');
    }
    //保存发布的聊聊
    public function store()
    {

    }
    //修改发布的聊聊
    public function edit()
    {

    }
    //更新聊聊的内容
    public function save()
    {

    }
    //删除聊聊
    public function destroy()
    {

    }
}
