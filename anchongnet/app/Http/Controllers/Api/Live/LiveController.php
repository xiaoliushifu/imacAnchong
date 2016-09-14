<?php

namespace App\Http\Controllers\Api\Live;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/*
*   该控制器包含了互动直播模块的操作
*/
class LiveController extends Controller
{
    //定义变量
    private $JsonPost;

    /*
    *   执行构造方法将orm模型初始化
    */
    public function __construct()
    {
        $this->JsonPost=new \App\JsonPost\JsonPost();
    }

    public function live(Request $request)
    {
        $url  = "https://test.tim.qq.com/v3/openim/videorelay?usersig=1234567&apn=1&identifier=eqwe&sdkappid=1400014686&random=1223&contenttype=json";
        $data = json_encode(array('a'=>1, 'b'=>2));

        list($return_code, $return_content) = $this->JsonPost->http_post_data($url, $data);
        var_dump($return_code);
        var_dump($return_content);
    }
}
