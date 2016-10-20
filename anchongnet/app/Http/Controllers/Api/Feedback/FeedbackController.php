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
        try{
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
                }else{
                    return response()->json(['serverTime'=>time(),'ServerNo'=>17,'ResultData'=>['Message'=>'反馈失败']]);
                }
            }else{
                //创建用户表通过电话查询出用户电话
                $users=new \App\Users();
                $users_phone=$users->quer('phone',['users_id'=>$data['guid']])->toArray();
                //判断用户数据表中是否有电话联系方式
                if($users_phone[0]['phone']){
                    $users_message=new \App\Usermessages();
                    $users_contact=$users_message->quer('contact',['users_id'=>$data['guid']])->toArray();
                    if(!$users_contact){
                        $users_contact[0]['contact']="";
                    }
                    $feedback_data=[
                        'users_id' => $data['guid'],
                        'title' => $param['title'],
                        'created_at' => date('Y-m-d H:i:s',$data['time']),
                        'content' => $param['content'],
                        'phonemodel' => $param['phonemodel'],
                        'phone' => $users_phone[0]['phone'],
                        'contact' => $users_contact[0]['contact'],
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
                }else{
                    return response()->json(['serverTime'=>time(),'ServerNo'=>17,'ResultData'=>['Message'=>'请重新提交信息']]);
                }
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   该方法提供了意见反馈回复的功能
    */
    public function reply(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //创建ORM模型
        $feedback_reply=new \App\Feedback_reply();
        //查出数据
        $result=$feedback_reply->quer(['freply_id','title','content','state'],$data['guid']);
        if(empty($result)){
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>[]]);
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$result]);
        }
    }

    /*
    *   该方法提供了意见反馈操作的功能
    */
    public function replyedit(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //创建ORM模型
        $feedback_reply=new \App\Feedback_reply();
        //判断操作
        if($param['action'] == 1){
            //修改回复信息查看状态
            $result=$feedback_reply->replyupdate($param['freply_id'],['state'=>1]);
        }elseif($param['action'] == 2){
            //删除回复信息
            $result=$feedback_reply->replydel($param['freply_id']);
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>17,'ResultData'=>['Message'=>'非法操作']]);
        }
        //判断是否操作成功
        if($result){
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'操作成功']]);
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>17,'ResultData'=>['Message'=>'操作失败']]);
        }
    }

    /*
    *   该方法提供了意见反馈回复未查看数量
    */
    public function replycount(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //创建ORM模型
        $feedback_reply=new \App\Feedback_reply();
        //修改回复信息查看状态
        $num=$feedback_reply->countquer($data['guid']);
        //返回数量
        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$num]);
    }

    /*
    *   该方法提供了APP更新
    */
    public function androidupdate(Request $request)
    {
        return response()->json(['varsionName'=>"2.0.1",'varsionCode'=>22,'Description'=>"更新介绍:
1.新增钱袋模块-余额、签到、虫豆、优惠券
2.优化了加入购物车界面
3.加入了清除缓存功能
4.新增了支付设置的功能
5.还有其他功能等着您来发现",'downloadUrl'=>"http://anchongres.oss-cn-hangzhou.aliyuncs.com/android/app-anchong-new-2.0.1.encrypted_signed_Aligned.apk"]);
    }
}
