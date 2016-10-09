<?php

namespace App\Http\Controllers\Home\Community;

use App\Http\Controllers\Home\CommonController;


class ChatController extends CommonController
{
    /*
     * 发布聊聊页面
     */
    public function index()
    {
        return view('home/release/releasechat');
    }
    /*
     * 提交聊聊信息
     */
    public function store()
    {

    }
    /*
     * 编辑已发布的聊聊
     */
    public function edit()
    {

    }
    /*
     * 保存编辑后的聊聊信息
     */
    public function save()
    {

    }
    /*
     * 删除聊聊
     */
    public function destroy()
    {

    }
}
