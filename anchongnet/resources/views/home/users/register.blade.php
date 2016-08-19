<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>用户注册</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="/home/css/bootstrap.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="/home/css/zhuce.css">
        <link rel="stylesheet" type="text/css" href="/home/css/base.css">
    </head>
    <body>
        <div class="container">

      <div class="login-page" style="padding:100px;">
        <div class="logopic"><img src="/home/images/logo.png" alt="Img logo" /></div>
        <div class="titles"><h1>安虫</h1></div>
        <h4 class="title" style="margin-top:40px">
          <span>
            <a class="" data-pjax="true" href="/user/login">登录</a>
            <b>·</b>
            <a class="active" data-pjax="true" href="/user/register">注册</a>
          </span>
        </h4>
        <div id="pjax-container">

    <div class="sign-in">
      <form class="form-horizontal" data-js-module="sign-in" action="/user/register" accept-charset="UTF-8" method="post">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <p id="signin_errors" class="signin_error"><font color="red">{{ Session::get('errormessage') }}</font></p>

    <div class="input-prepend domestic ">
      <input type="text" name="phone" id="sign_in_name" value="" class="span2" placeholder="手机号码" />
    </div>

    <div class="input-prepend password ">
      <input type="password" name="password" id="sign_in_password" class="span2" placeholder="密码:     6~16个英文字母、符号或数字"  required="required"/>
    </div>

    <div class="input-prepend authnum" style="text-align: left;">
        <input type="text" name="phonecode" id="authnum" style="padding-right:20px" class="span2" placeholder="请输入验证码" />
        <button class="ladda-button" type="button" style="font-size:14px;width:130px;height:40px;padding-top:8px;margin-left:25px" data-color="blue" id="authnumbutton">
          <span class="ladda-label" id="authnumfont">获取验证码</span>
        </button>
    </div>

    <div class="control-group text-left" style="text-align: center;padding-bottom: 20px;padding-top: 10px;">
      <input type="checkbox" value="true" checked="true"/> 我已阅读并同意
      <a href="#" style="float:none">安虫用户协议</a>
    </div>

    <button class="ladda-button submit-button" style="width:100%;height:40px;padding-top:5px;" data-color="blue">
      <span class="ladda-label">注册</span>
    </button>

      </form>
    </div>
        </div>
      </div>
        </div>
        <script src="/home/js/jquery-3.0.0.min.js"></script>
        <script src="/home/js/bootstrap.min.js"></script>
        <script src="/home/js/users.js"></script>
    </body>
</html>
