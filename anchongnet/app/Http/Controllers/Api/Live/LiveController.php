<?php

namespace App\Http\Controllers\Api\Live;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Qiniu\Utils;

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

    public function live(Request $request)
    {
        $url  = "https://api.netease.im/nimserver/chatroom/update.action";
        //$data = 'accid=13462344969&name=任先生&props={"a","b"}&icon=http://anchongres.img-cn-hangzhou.aliyuncs.com/headpic/1470306451.jpg';
        //$data="creator=13462344969&name=zhibo";
        //$data="roomid=4175618&msgId=13462344969".time()."&fromAccid=13462344969&msgType=0&attach=我是盗号的";
        //f9a4927ae3b9393dc905d694fcecf5ef
        //{"chatroom":{"roomid":4175618,"valid":true,"announcement":null,"name":"zhibo","broadcasturl":null,"ext":"","creator":"13462344969"},"code":200}
        $data="roomid=4175618&name=zhibo";
        list($return_code, $return_content) = $this->JsonPost->http_post_data($url, $data);
        var_dump($return_code);
        var_dump($return_content);
        // try {
        //     $title           = NULL;     // 选填，默认自动生成
        //     $publishKey      = NULL;     // 选填，默认自动生成
        //     $publishSecurity = NULL;     // 选填, 可以为 "dynamic" 或 "static", 默认为 "dynamic"
        //
        //     $stream = $this->hub->createStream($title, $publishKey, $publishSecurity); # => Stream Object
        //
        //     echo "createStream() =>\n";
        //     //var_export($stream);
        //     var_dump($stream);
        //     echo "\n\n";
        //     $publishUrl = $stream->rtmpPublishUrl();
        //     echo "Stream rtmpPublishUrl() =>\n";
        //     echo $publishUrl;
        //     echo "\n\n";
        //
        //     /*
        //     echo $stream->id;
        //     echo $stream->createdAt;
        //     echo $stream->updatedAt;
        //     echo $stream->title;
        //     echo $stream->hub;
        //     echo $stream->disabled;
        //     echo $stream->publishKey;
        //     echo $stream->publishSecurity;
        //     echo $stream->hosts;
        //     echo $stream->hosts["publish"]["rtmp"];
        //     echo $stream->hosts["live"]["rtmp"];
        //     echo $stream->hosts["live"]["http"];
        //     echo $stream->hosts["playback"]["http"];
        //     */
        //
        // } catch (Exception $e) {
        //     echo 'createStream() failed. Caught exception: ',  $e->getMessage(), "\n";
        // }
    }
}
