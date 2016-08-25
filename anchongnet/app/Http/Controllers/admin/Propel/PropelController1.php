<?php

namespace App\Http\Controllers\admin\Propel;

use Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use JPush\Client;

/*
*   该控制器包含了消息推送模块的操作
*/
class PropelController1 extends Controller
{
    /*
    *   该方法提供了推送的功能
    */
    public function apppropel(Request $request)
    {
        //定义需要的参数
        $app_key="5cfcdf6659fca3e33dde79cc";
        $master_secret="b6d1612108cbd489e379e25e";
        $client = new \JPush\Client($app_key, $master_secret);
        $push = $client->push();
        //设置推送的平台
        $platform = array('ios', 'android');
        //设置弹出消息
        //通知栏屏幕显示内容
        $alert = '测试信息';
        //设置标签
        $tag = array('tag1', 'tag2');
        $regId = array('rid1', 'rid2');
        //设置ios的通知
        $ios_notification = array(
            //通知栏屏幕显示标题
            'sound' => 'hello jpush',
            'badge' => 2,
            'content-available' => true,
            'category' => 'jiguang',
            'extras' => array(
                'key' => 'value',
                'jiguang'
            ),
        );
        //设置Android的通知
        $android_notification = array(
            'title' => 'hello jpush',
            'build_id' => 2,
            'extras' => array(
                'key' => 'value',
                'jiguang'
            ),
        );
        //设置信息内容
        $content = 'Hello World';
        $message = array(
            'title' => '安虫平台',
            'content_type' => 'text',
            'extras' => array(
                'key' => 'value',
                'jiguang'
            ),
        );
        //设置推送选项
        $options = array(
            'sendno' => 101,
            'time_to_live' => 86400,
            // 'override_msg_id' => 100,
            'apns_production' => false,
            'big_push_duration' => 1
        );
        $response = $push->setPlatform($platform)
            ->addAlias('13718638641')
            ->iosNotification($alert, $ios_notification)
            ->androidNotification($alert, $android_notification)
            ->message($content, $message)
            ->options($options)
            ->send();
            var_dump($response);
    }
}
