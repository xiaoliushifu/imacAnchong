<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Session;
use Gregwar\Captcha\CaptchaBuilder;

/**
*
*   该类属于验证码的专用类负责生成验证码
*
*/
class CaptchaController extends Controller
{
    /**
    *   验证码的生成
    */
    public function captcha($num)
    {
       $builder = new CaptchaBuilder;
       //可以设置图片宽高及字体
       $builder->build($width = 100, $height = 34, $font = null);
       //获取验证码的内容
       $phrase = $builder->getPhrase();
       //把内容存入session
       Session::flash($num.'adminmilkcaptcha', $phrase);
       //生成图片
       header("Cache-Control: no-cache, must-revalidate");
       header('Content-Type: image/jpeg');
       return $builder->output();
    }
}
