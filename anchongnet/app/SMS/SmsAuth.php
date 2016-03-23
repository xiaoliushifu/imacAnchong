<?php

namespace App\SMS;

use Redis;
/**
*   使用方法:为手机短信验证服务
*/
class smsAuth {
    /**
    *   生成手机验证码
    *   短信签名：大鱼测试   活动验证    变更验证    登录验证    注册验证    身份验证
    *   常用短信模板：
    *       身份验证验证码     模板ID: SMS_6135744     模板内容: 验证码${code}，您正在进行${product}身份验证，打死不要告诉别人哦！
    *       用户注册验证码     模板ID: SMS_6135740     模板内容: 验证码${code}，您正在注册成为${product}用户，感谢您的支持！
    *       修改密码验证码     模板ID: SMS_6135738     模板内容: 验证码${code}，您正在尝试修改${product}登录密码，请妥善保管账户信息。
    *       登录确认验证码     模板ID: SMS_6135742     模板内容: 验证码${code}，您正在登录${product}，若非本人操作，请勿泄露。
    */
    public function smsAuth($action, $phone)
    {
        //阿里大鱼的两个key
        $appkey='23327955';
        $secretkey='0a01baddfb5b3a18cb5fdc9c8c4ebefa';
        //创建短信验证类
        $alisms = new \App\SMS\AliSms($appkey, $secretkey, '', '');
        //生成随机的验证码
        $code = rand(100000,999999);
        //创建短信内容信息数组
        $smsarr=array();
        //判断用户行为
        switch ($action) {
            case '注册验证':
                $smsarr=['data' => ['code' => strval($code), 'product' => '安虫平台'], 'code' => 'SMS_6135740'];
                break;
            case '登录验证':
                $smsarr=['data' => ['code' => strval($code), 'product' => '安虫平台'], 'code' => 'SMS_6135742'];
                break;
            case '修改密码':
                $smsarr=['data' => ['code' => strval($code), 'product' => '安虫平台'], 'code' => 'SMS_6135738'];
                break;
            case '身份验证':
                $smsarr=['data' => ['code' => strval($code), 'product' => '安虫平台'], 'code' => 'SMS_6135744'];
                break;
            default:
                return '数据出错,发送失败！';
                break;
        }
        //得到结果
        $result = $alisms->sign($action)->data($smsarr['data'])->code($smsarr['code'])->send($phone);
        //将返回的json数据转成数组
        $result = json_decode($result,true);
        //根据返回的json数据信息判断是否发送成功，并输出内容
        foreach ($result as $key => $value) {
            if($key == 'error_response'){
                return [false,'发送失败，'.$value['sub_msg'].'，请重新发送！'];
            }elseif($key == 'alibaba_aliqin_fc_sms_num_send_response' && $value['result']['success'] == '1'){
                $redis = Redis::connection();
                $redis->set($phone, $code);
                return [true,1];
            }else{
                return [false,'发送失败，请重新发送！'];
            }
        }
    }
}
