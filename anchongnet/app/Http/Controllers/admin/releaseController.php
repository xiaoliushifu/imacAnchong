<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Request as Requester;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Community_release;
use Auth;
use DB;

class releaseController extends Controller
{
    private $release;
    private $uid;

    public function __construct()
    {
        $this->release=new Community_release();
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
        $keyTag=Requester::input("tag");
        if($keyTag==""){
            $datas=$this->release->User($this->uid)->paginate(8);
        }else{
            $datas = $this->release->Tag($this->uid,$keyTag)->paginate(8);
        }
        $args=array("user"=>$this->uid,"tag"=>$keyTag);
        return view('admin/release/index',array("datacol"=>compact("args","datas")));
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
     * @param  \Illuminate\Http\Request  $request
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
        ];
        //创建ORM模型
        $community_release=new \App\Community_release();
        $id=$community_release->add($community_data);
        //插入社区图片
        if(!empty($id)){
            if($request['pic']){
                $ture=false;
                foreach ($request['pic'] as $pic) {
                    $community_img=new \App\Community_img();
                    $ture=$community_img->add(['chat_id'=>$id,'img'=> $pic]);
                    //假如有一张图片插入失败就返回错误
                    if(!$ture){
                        //假如失败就回滚
                        DB::rollback();
                        return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'聊聊发布失败,请重新发布']]);
                    }
                }
                //orm模型操作数据库会返回true或false,如果操作失败则返回错误信息
                if($ture){
                    //假如成功就提交
                    DB::commit();
                    return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'聊聊发布成功']]);
                }else{
                    //假如失败就回滚
                    DB::rollback();
                    return response()->json(['serverTime'=>time(),'ServerNo'=>13,'ResultData'=>['Message'=>'请重新发布聊聊']]);
                }
            }else{
                //假如成功就提交
                DB::commit();
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'聊聊发布成功']]);
            }
        }else{
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data=$this->release->find($id);
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data=$this->release->find($id);
        $data->title=$request->title;
        $data->content=$request['content'];
        $data->save();
        return "更新成功";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data=$this->release->find($id);
        $data->delete();
        return "删除成功";
    }
}
