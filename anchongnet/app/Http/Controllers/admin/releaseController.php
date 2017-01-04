<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Request as Requester;

use Exception;
use App\Http\Controllers\Controller;
use App\Community_release;
use Auth;
use DB;
use Gate;

/**
*   该控制器包含了社区聊聊模块的操作
*/
class releaseController extends Controller
{
    private $release;
    private $uid;

    public function __construct()
    {
        //通过Auth获取当前登录用户的id
        $this->uid=Auth::user()['users_id'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kt=Requester::input("tag");
        $this->release=new Community_release();
        //判断有无筛选标签
        if ($kt) {
            //查出该用户所有聊聊
            $datas = $this->release->Tag($this->uid,$kt)->orderBy("chat_id","desc")->paginate(8);
        } else {
            //根据标签查出该用户所有聊聊
            $datas=$this->release->User($this->uid)->orderBy("chat_id","desc")->paginate(8);
        }
        $args=array("tag"=>$kt);
        //返回数据,all代表是否是查询所有聊聊
        return view('admin/release/index',array("datacol"=>compact("args","datas"),'all'=>"0"));
    }

    /**
     * 查看所有的聊聊
     *从路由层面验证请求合法性
     * @return \Illuminate\Http\Response
     */
    public function releases()
    {
        $kt=Requester::input("tag");
        $this->release = new Community_release();
        //判断有无筛选标签
        if ($kt) {
            $datas = $this->release->Tags($kt)->orderBy("chat_id","desc")->paginate(8);
        } else {
            $datas = $this->release->orderBy("chat_id","desc")->paginate(8);
        }
        $args=array("tag"=>$kt);
        //返回数据,all代表是否是查询所有聊聊
        return view('admin/release/index',array("datacol"=>compact("args","datas"),'all'=>"1"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin/release/create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request('pic'图片数组,'uid'用户ID,'name'名字,'title'标题,'content'内容,'headpic'头像,'tag'标签)
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\StoreReleaseRequest $request)
    {
        //开启事务处理
        DB::beginTransaction();
        //转换标签
        $tags_arr=explode(' ',$request['tag']);
        $tags="";
        if(!empty($tags_arr)){
            foreach ($tags_arr as $tag_arr) {
                $tags.=bin2hex($tag_arr)." ";
            }
        }
        //定义图片变量
        $imgs="";
        //判断是否有图片
        if($request['pic']){
            foreach ($request['pic'] as $pic) {
                $imgs.=$pic.'#@#';
            }
        }
        //定义插入数据库的数据
        $community_data=[
            'users_id' => $request['uid'],
            'title' => $request['title'],
            'name' => $request['name'],
            'content' => $request['content'],
            'created_at' => date('Y-m-d H:i:s',time()),
            'headpic' => $request['headpic'],
            'tags' => $request['tag'],
            'tags_match' => $tags,
            'img' => $imgs,
        ];
        //创建ORM模型
        $community_release=new Community_release();
        $result=$community_release->add($community_data);
        //插入社区图片
        if ($result) {
            //假如成功就提交
            DB::commit();
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'聊聊发布成功']]);
        } else {
            //假如失败就回滚
            DB::rollback();
            return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'请重新发布聊聊']]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id聊聊ID
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->release = new Community_release();
        $data=$this->release->find($id);
        if (Gate::denies('comres',$data)) {
            return back();
        }
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $request('title'标题,'content'内容)
     * @param  int  $id聊聊ID
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->release = new Community_release();
        $data=$this->release->find($id);
        if (Gate::denies('comres',$data)) {
            return back();
        }
        $data->title=$request->title;
        $data->content=$request['content'];
        $data->save();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id聊聊ID
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res=array();
        try{
                //还有更好的办法
                DB::beginTransaction();
                $data = DB::table('anchong_community_release')->where('chat_id',$id)->get();
                if (!$data || Gate::denies('comres',$data)) {
                    return 'N';
                }
                $res[] = DB::table('anchong_community_release')->where('chat_id',$id)->delete();
                $res[] = DB::table('anchong_community_collect')->where('chat_id',$id)->delete();
                $res[] = DB::table('anchong_community_comment')->where('chat_id',$id)->delete();
                $res[] = DB::table('anchong_community_reply')->where('chat_id',$id)->delete();
                DB::commit();
                return '删除成功';
        } catch(Exception $e) {
            return '聊聊删除有误';
        }
    }

}
