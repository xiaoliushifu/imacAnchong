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
}
