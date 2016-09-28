<?php

namespace App\Http\Controllers\Api\Live;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Qiniu\Utils;
use DB;

/*
*   该控制器包含了互动直播模块的操作
*/
class LiveController extends Controller
{
    //定义变量
    private $JsonPost;
    //七牛云直播公私钥
    private $ACCESS_KEY;
    private $SECRET_KEY;
    //定义七牛云空间实例化的对象
    private $hub;

    /*
    *   执行构造方法将orm模型初始化
    */
    public function __construct()
    {
        $this->JsonPost=new \App\JsonPost\JsonPost();
        $this->SECRET_KEY="X8fxGoXHSIyvt-H0k9kRWqvZjE5COGqQzMp_UJGD";
        $this->ACCESS_KEY="G4vcc2JpeWnVVYu4RIJhCWHb8Ck8zMfyDlB0k2mw";
        //创建七牛云直播的对象
        $credentials = new \Qiniu\Credentials($this->ACCESS_KEY, $this->SECRET_KEY);
        //实例化他的推流空间对象
        $this->hub = new \Pili\Hub($credentials, "chongzai");
    }

    public function createlive(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request->all();
        $param=json_decode($data['param'],true);

        //尝试运行开启七牛直播，并看该用户是否已开启直播
        try {
            $streams=$this->hub->getStream("z1.chongzai.".md5($data['guid']))->toJSONString();
        } catch (\Exception $e) {
            //假如用户未开始直播，尝试生成新直播
            try{
                //定义直播生成的数据
                $title           = md5($data['guid']);     // 选填，默认自动生成，定义为用户的ID
                $publishKey      = NULL;     // 选填，默认自动生成
                $publishSecurity = NULL;     // 选填, 可以为 "dynamic" 或 "static", 默认为 "dynamic"
                //生成Stream Object
                $stream = $this->hub->createStream($title, $publishKey, $publishSecurity);
                //将stream转成json
                $streams=$stream->toJSONString();
                //获取查看直播的地址
                $urls = $stream->rtmpLiveUrls();
                //判断是否有查看直播的地址
                if(!empty($urls) && $urls['ORIGIN']){
                    //将数据插入表中
                    DB::table('v_start')->insertGetId(
                        [
                            'users_id' => $data['guid'],
                            'room_url' => $urls['ORIGIN'],

                        ]
                    );
                }else{
                    return response()->json(['serverTime'=>time(),'ServerNo'=>18,'ResultData'=>['Message'=>"直播开启失败"]]);
                }
            } catch (\Exception $e) {
                return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>"直播开启失败"]]);
            }
        }
        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['stream'=>$streams]]);
    }

    /*
    *   网易云信聊天室创建
    */
    public function createroom(Request $request)
    {
        //创建orm
        $users_message=new \App\Usermessages();
        //查出用户的昵称和头像
        $usersmessage=$users_message->quer(['headpic','nickname'],['users_id'=>$data['guid']])->toArray();
        //判断用户是否完善信息
        try{
            if(!$usersmessage[0]['nickname']){
                return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'请完善个人信息中的昵称']]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>12,'ResultData'=>['Message'=>'请完善个人信息中的昵称']]);
        }
        //尝试创建网易云信
        try{
            //头像信息
            if(empty($usersmessage[0]['headpic'])){
                $headpic="http://anchongres.oss-cn-hangzhou.aliyuncs.com/headpic/placeholder120@3x.png";
            }else{
                $headpic=$usersmessage[0]['headpic'];
            }

            //网易云信
            $url  = "https://api.netease.im/nimserver/chatroom/create.action";
            //$data = 'accid='.$param['phone'].'&name='.$usersmessage[0]['nickname'].'&icon='.$headpic;
            $data="creator=13462344969&name=zhibo";
            list($return_code, $return_content) = $this->JsonPost->http_post_data($url, $data);
            //判断是否请求成功
            if($return_code != 200){
                return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>"直播聊天开启失败"]]);
            }
            var_dump($return_content);
        } catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>"直播开启失败"]]);
        }
    }
}
