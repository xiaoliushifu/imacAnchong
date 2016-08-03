<?php

namespace App\Http\Controllers\Api\Feedback;

//use Illuminate\Http\Request;
use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use DB;

/*
*   该控制器包含了意见反馈的操作
*/
class FeedbackController extends Controller
{
    /*
    *   该方法提供了意见反馈发布的功能
    */
    public function release(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //验证用户传过来的数据是否合法
        $validator = Validator::make($param,
            [
                'title' => 'required|max:255',
                'content' => 'required|min:4',
                'pic' => 'array',
            ]
        );
        //如果出错返回出错信息，如果正确执行下面的操作
        if ($validator->fails())
        {
            return response()->json(['serverTime'=>time(),'ServerNo'=>17,'ResultData'=>['Message'=>'请填写完整，并且标题长度不能超过126个字，反馈内容不能低于4个字']]);
        }else{
            $feedback_data=[
                'users_id' => $data['guid'],
                'title' => $param['title'],
                'created_at' => date('Y-m-d H:i:s',$data['time']),
                'content' => $param['content']
            ];
            //开启事务处理
            DB::beginTransaction();
            //创建插入方法
            $feedback=new \App\Feedback();
            $id=$feedback->add($feedback_data);
            //插入成功继续插图片，插入失败则返回错误信息
            if(!empty($id)){
                if($param['pic']){
                    $ture=false;
                    foreach ($param['pic'] as $pic) {
                        $urls = str_replace('.oss-','.img-',$pic);
                        $feedback_img=new \App\Feedback_img();
                        $ture=$feedback_img->add(['feed_id'=>$id,'img'=> $urls]);
                        //假如有一张图片插入失败就返回错误
                        if(!$ture){
                            //假如失败就回滚
                            DB::rollback();
                            return response()->json(['serverTime'=>time(),'ServerNo'=>17,'ResultData'=>['Message'=>'提交反馈失败，请重新提交']]);
                        }
                    }
                    //orm模型操作数据库会返回true或false,如果操作失败则返回错误信息
                    if($ture){
                        //假如成功就提交
                        DB::commit();
                        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'提交成功']]);
                    }else{
                        //假如失败就回滚
                        DB::rollback();
                        return response()->json(['serverTime'=>time(),'ServerNo'=>17,'ResultData'=>['Message'=>'请重新提交信息']]);
                    }
                }else{
                    //假如成功就提交
                    DB::commit();
                    return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'提交成功']]);
                }
            }else{
                //假如失败就回滚
                DB::rollback();
                return response()->json(['serverTime'=>time(),'ServerNo'=>17,'ResultData'=>['Message'=>'请重新提交信息']]);
            }
        }
    }

    /*
    *   该方法提供了APP更新
    */
    public function androidupdate(Request $request)
    {
        return response()->json(['varsionName'=>"2.0",'varsionCode'=>2,'Description'=>"这是新版本修复了bug",'downloadUrl'=>"http://anchongres.oss-cn-hangzhou.aliyuncs.com/android/app-anchong-net-1.06.apk"]);
    }
}
