<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Request as Requester;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Community_release;
use Auth;

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
        $this->release->users_id=$request['uid'];
        $this->release->title=$request['title'];
        $this->release->name=$request['name'];
        $this->release->content=$request['content'];
        $this->release->auth=1;
        $this->release->headpic=$request['headpic'];
        $this->release->tags=$request['tag'];
        $this->release->tags_match=bin2hex($request['tag']);
        $this->release->comnum=0;
        $this->release->save();
        return "发布成功";
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
