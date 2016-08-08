<?php

namespace App\Http\Controllers\admin\Feedback;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;

/*
*   后台意见反馈模块
*/
class FeedbackController extends Controller
{
    private $feedback;
    private $uid;

    public function __construct()
    {
        $this->feedback=new \App\Feedback();
    }

    /*
    *   后台意见反馈查看
    */
    public function show()
    {
        //查出反馈
        $datas=$this->feedback->orderBy("feed_id","desc")->paginate(8);
        //返回数据,all代表是否是查询所有聊聊
        return view('admin/feedback/index',array("datacol"=>compact("datas")));
    }

    /*
    *   反馈图片查看
    */
    public function imgshow($id)
    {
        //创建图片查询的orm模型
        $feedback_img=new \App\Feedback_img();
        $data=$feedback_img->quer(['id','img'],$id);
        return $data;
    }

    /*
    *   反馈图片查看
    */
    public function feedbackdel($id)
    {
        //开启事务处理
        DB::beginTransaction();
        $data=$this->feedback->find($id);
        $data->delete();
        //创建图片查询的orm模型
        $feedback_img=new \App\Feedback_img();
        $result=$feedback_img->delimg($id);
        if($result){
            //假如成功就提交
            DB::commit();
            return "删除成功";
        }else{
            //假如失败就回滚
            DB::rollback();
            return "删除失败";
        }
    }

    /*
    *   修改状态
    */
    public function feedbackedit(Request $request,$id)
    {
        //获得句柄
        $data=$this->feedback->find($id);
        //修改状态
        $data->state=3;
        $result=$data->save();
        if($result){
            return "修改成功";
        }else{
            return "修改失败";
        }
    }

    /*
    *   反馈回复
    */
    public function feedbackreply(Request $request,$id)
    {
        $gid = DB::table('anchong_feedback_reply')->insertGetId(
            [
                'feed_id' => $request['feed_id'],
                'users_id' => $request['users_id'],
                'title' => $request['title'],
                'content' => $request['content'],
            ]
        );
        if($gid){
            //获得句柄
            $data=$this->feedback->find($id);
            //修改状态
            $data->state=2;
            $result=$data->save();
            if($result){
                return
                response()->json(['Message'=>'回复成功']);
            }else{
                return
                response()->json(['Message'=>'回复失败']);
            }
        }else{
            return
            response()->json(['Message'=>'回复失败']);
        }

    }
}
