<?php

namespace App\Http\Controllers\admin\Feedback;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Redirect;

/**
*   后台意见反馈模块
*/
class FeedbackController extends Controller
{
    //定义变量
    private $user;
    private $propel;
    private $feedback;
    private $uid;

    //初始化orm
    public function __construct()
    {
		$this->propel=new \App\Http\Controllers\admin\Propel\PropelmesgController();
		$this->user=new \App\Users();
        $this->feedback=new \App\Feedback();
    }

    /**
    *   后台意见反馈查看
    *
    * @param  无
    * @return \Illuminate\Http\Response
    */
    public function show()
    {
        //查出反馈
        $datas=$this->feedback->orderBy("state","asc")->orderBy("feed_id","desc")->paginate(8);
        //返回数据,all代表是否是查询所有聊聊
        return view('admin/feedback/index',array("datacol"=>compact("datas")));
    }

    /**
    *   反馈图片查看
    *
    * @param  int  $id图片ID
    * @return \Illuminate\Http\Response
    */
    public function imgshow($id)
    {
        //创建图片查询的orm模型
        $feedback_img=new \App\Feedback_img();
        $data=$feedback_img->quer(['id','img'],$id);
        return $data;
    }

    /**
    *   反馈图片查看
    *
    * @param  int  $id反馈ID
    * @return \Illuminate\Http\Response
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

    /**
    *   反馈用户已查看并修改状态
    *
    * @param  $request('feed_id'反馈ID,'users_id'用户ID,'title'标题)
    * @return \Illuminate\Http\Response
    */
    public function feedbackview(Request $request)
    {
        //开启事务处理
        DB::beginTransaction();
        //获得句柄
        $data=$this->feedback->find($request->feed_id);
        //修改状态
        $data->state=2;
        $result=$data->save();
        if($result){
            //向数据库插入回复
            $results = DB::table('anchong_feedback_reply')->insertGetId(
                [
                    'feed_id' => $request->feed_id,
                    'users_id' => $request->users_id,
                    'title' => "反馈问题：".$request->title,
                    'content' => "您好，您提交的问题我们已收到，感谢您对安虫的支持！",
                ]
            );
            //判断是否插入成功
            if($results){
                //推送消息
                $this->propel->apppropel($this->user->find($request->users_id)->phone,'您提交的意见反馈得到了回复',"您反馈的问题: ".$request->title." 我们已收到，感谢您对安虫的支持！");
                //假如成功就提交
                DB::commit();
                return "反馈成功";
            }else{
                //假如失败就回滚
                DB::rollback();
                return "反馈失败，请重新查看";
            }
        }else{
            //假如失败就回滚
            DB::rollback();
            return "反馈失败，请重新查看";
        }
    }

    /**
    *   修改状态
    *
    * @param  $request(无)
    * @param  int  $id
    * @return \Illuminate\Http\Response
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

    /**
    *   反馈回复
    *
    * @param  $request('feed_id'反馈ID,'users_id'用户ID,'title'标题,'content'内容,'reward'奖励)
    * @return \Illuminate\Http\Response
    */
    public function feedbackreply(Request $request)
    {
        //开启事务处理
        DB::beginTransaction();
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
            $data=$this->feedback->find($request->feed_id);
            if($request->reward){
                $data->reward=$request->reward;
                $content="感谢您的意见，我们将奖励您：".$request->reward;
            }else{
                $content="感谢您提出宝贵的建议，感谢您对安虫平台的支持!";
            }
            //修改状态
            $data->state=4;
            $result=$data->save();
            if($result){
                //推送消息
                $this->propel->apppropel($this->user->find($request->users_id)->phone,'您提交的意见反馈已得到回复',$content);
                //假如成功就提交
                DB::commit();
                return Redirect::intended('/feedback/show')->withInput()->with('commentresult','回复成功');
            }else{
                //假如失败就回滚
                DB::rollback();
                return Redirect::intended('/feedback/show')->withInput()->with('commentresult','回复失败');
            }
        }else{
            //假如失败就回滚
            DB::rollback();
            return Redirect::intended('/feedback/show')->withInput()->with('commentresult','回复失败');
        }
    }
}
