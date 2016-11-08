<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Community_comment;
use Gate;
use DB;
/**
*   该控制器包含了聊聊评论模块的操作
*/
class commentController extends Controller
{
    private $comment;
    public function __construct()
    {
        $this->comment=new Community_comment();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $chat=$request['chat'];
        //验证所属关系
        $data = DB::table('anchong_community_release')->where('chat_id',$chat)->get();
        if (!$data || Gate::denies('comres',$data)) {
            return redirect('/release');
        }
        $datas=$this->comment->Chat($chat)->paginate(30);
        return view("admin/release/comment")->with("datas",$datas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request('','','','','')
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $request('','','','','')
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id评论ID
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $com=$this->comment->find($id);
        $data = DB::table('anchong_community_release')->where('chat_id',$com->chat_id)->get();
        if (!$data || Gate::denies('comres',$data)) {
            return 'N';
        }
        $com->delete();
        return "删除成功";
    }
}
