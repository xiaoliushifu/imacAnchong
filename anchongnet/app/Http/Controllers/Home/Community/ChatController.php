<?php

namespace App\Http\Controllers\Home\Community;

use App\Http\Controllers\Home\CommonController;
use Cache;
use Auth;
use App\Usermessages;
use App\Community_release;
use Input;

class ChatController extends CommonController
{
    
    public function __construct()
    {
        $this->middleware('loginhome');
    }
    /*
     * 发布聊聊页面
     */
    public function index()
    {
        $msg = Cache::remember('all',10,function (){
            return Usermessages::where('users_id', Auth::user()['users_id'])->first();
        });
        return view('home/release/releasechat',['msg'=>$msg]);
    }

    public function show()
    {
        
    }
    /*
     * 提交聊聊信息
     */
    public function store()
    {
        $data = Input::all();
        //dd(Input::all());
        if(!in_array($data['tag'],['闲聊','问问','活动'])){
            return back();
        }
        $encode_tag=bin2hex($data['tag']);
        $imgs = '';
        if(isset($data['pic'])){
            foreach ($data['pic'] as $pic) {
                $imgs.=$pic.'#@#';
            }
        }
        //用户信息
        $user = Cache::remember('all',10,function (){
            return Usermessages::where('users_id', Auth::user()['users_id'])->first();
        });
        $model=new Community_release();
        //每日限制
        if ($model->where('users_id',$user['users_id'])->where('created_at','>',date('Y-m-d'))->count()>5) {
           return back();
        }
        //定义插入数据库的数据
        $community_data=[
            'users_id' => $user['users_id'],
            'title' => $data['title'],
            'name' => $user['nickname'],
            'content' => $data['content'],
            'created_at' => date('Y-m-d H:i:s'),
            'headpic' => $user['headpic'],
            'tags' => $data['tag'],
            'tags_match' => $encode_tag,
            'img' => $imgs,
        ];
        $ret=$model->add($community_data);
        return back();
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
    public function update()
    {

    }
    /*
     * 删除聊聊
     */
    public function destroy()
    {

    }
}
