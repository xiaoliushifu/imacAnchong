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
            $messages = $validator->errors();
            if ($messages->has('title')) {
                //如果验证失败,返回验证失败的信息
                return response()->json(['serverTime'=>time(),'ServerNo'=>17,'ResultData'=>['Message'=>'标题不能超过126个字']]);
            }else if($messages->has('content')){
                return response()->json(['serverTime'=>time(),'ServerNo'=>17,'ResultData'=>['Message'=>'反馈内容不能低于4个字']]);
            }
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
        return response()->json(['varsionName'=>"1.0.8",'varsionCode'=>8,'Description'=>"更新介绍: 
1.优化界面，更加美观 
2.商城界面新增商品搜索功能，360度无死角搜索 
3.优化用户体验度 
4.快来下载体验吧",'downloadUrl'=>"http://anchongres.oss-cn-hangzhou.aliyuncs.com/android/app-anchong-net1.0.8.encrypted_signed_Aligned.apk"]);
    }
}
