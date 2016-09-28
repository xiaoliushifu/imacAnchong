<?php

namespace App\Http\Controllers\admin\Propel;

use Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use JPush\Client;
use Redirect;

/*
*   该控制器包含了消息推送模块的操作
*/
class PropelController extends Controller
{
    /**
     *  该方法返回消息推送的编辑页面
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.propel.create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=$request::all();
        //定义需要的参数
        $app_key="5cfcdf6659fca3e33dde79cc";
        $master_secret="b6d1612108cbd489e379e25e";
        //点三个参数可以传日志位置
        $client = new \JPush\Client($app_key, $master_secret, $_SERVER['DOCUMENT_ROOT'].'/../storage/jpush.log');
        $push = $client->push();
        //设置推送的平台
        $platform = array('ios', 'android');
        //设置弹出消息
        //通知栏屏幕显示内容
        $alert = $data['content'];
        //设置标签
        $tag = array('tag1', 'tag2');
        $regId = array('rid1', 'rid2');
        //设置别名
        $alias=$data['contact'];
        //设置ios的通知
        $ios_notification = array(
            //通知栏屏幕显示标题
            'sound' => 'hello jpush',
            'content-available' => true,
            'category' => 'jiguang',
            // 'extras' => array(
            //     'key' => 'value',
            //     'jiguang'
            // ),
        );
        //设置Android的通知
        $android_notification = array(
            'title' => $data['title'],
            'build_id' => 2,
            // 'extras' => array(
            //     'key' => 'value',
            //     'jiguang'
            // ),
        );
        //设置信息内容
        $content = '您有新消息了';
        $message = array(
            'title' => '安虫平台',
            'content_type' => 'text',
            // 'extras' => array(
            //     'key' => 'value',
            //     'jiguang'
            //),
        );
        //设置推送选项
        $options = array(
            'sendno' => 101,
            'time_to_live' => 86400,
            // 'override_msg_id' => 100,
            'apns_production' => false,
            'big_push_duration' => 0
        );
        //匹配不同的推送
        switch ($data['type']) {
            //1 为广播
            case '1':
            $response = $push->setPlatform($platform)
                ->addAllAudience()
                ->iosNotification($alert, $ios_notification)
                ->androidNotification($alert, $android_notification)
                ->message($content, $message)
                ->options($options)
                ->send();
                return Redirect::back()->withInput()->with('errormessage','广播推送成功');
                break;
            //2 为个人
            case '2':
            //当用户未登陆时，无法为个人推送消息，这时会发生异常，捕获异常并处理
                try{
                    $response = $push->setPlatform($platform)
                        ->addAlias($alias)
                        ->iosNotification($alert, $ios_notification)
                        ->androidNotification($alert, $android_notification)
                        ->message($content, $message)
                        ->options($options)
                        ->send();
                        return Redirect::back()->withInput()->with('errormessage','个人推送成功');
                }catch (\Exception $e) {
                    return Redirect::back()->withInput()->with('errormessage','该用户未登陆');
                }
                break;
            default:
                return Redirect::back()->withInput()->with('errormessage','非法推送');
                break;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
