<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>用户登录</title>
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
            <a class="active" data-pjax="true" href="/user/login">登录</a>
            <b>·</b>
            <a class="" data-pjax="true" href="/user/register">注册</a>
          </span>
        </h4>
        <div id="pjax-container">

    <div class="sign-in">
      <form class="form-horizontal" data-js-module="sign-in" action="/user/login" accept-charset="UTF-8" method="post">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <p id="signin_errors" class="signin_error"> <font color="red">{{ Session::get('errormessage') }}</font> </p>

    <div class="input-prepend domestic ">
      <input type="text" name="username" id="sign_in_name" value="" class="span2" placeholder="手机号码" />
    </div>

    <div class="input-prepend password ">
      <input type="password" name="password" id="sign_in_password" class="span2" placeholder="密码" />
    </div>

    <div class="input-prepend authnum" style="text-align: left;">
        <input type="text" name="captchapic" id="authnum" style="padding-right:20px;width:160px;" class="span2" placeholder="请输入验证码" onfocus="javascript:this.value=''" onclick="if(this.value=='验证码:'){this.value='';}" style="margin-bottom:20px;" required="required"/>
            <img src="/home/images/captcha.png" id="captchapic" onclick="captcha()">
            <input type="hidden" name="captchanum" id="captchanum" value="">
    </div>

    <button class="ladda-button submit-button" style="width:100%;height:40px;padding-top:5px;" data-color="blue">
      <span class="ladda-label">登 录</span>
    </button>

    <div class="control-group text-left">
      <input type="checkbox" name="remember_me" id="remember_me" value="true" checked="checked" /> 记住我
      <a href="/user/forgetpwd">忘记密码</a>
    </div>
    </form></div>
        </div>
      </div>
        </div>
        <script src="/home/js/jquery-3.0.0.min.js"></script>
        <script src="/home/js/bootstrap.min.js"></script>
        <script>
        function captcha() {
        	$url = "{{ URL('/captcha') }}";
                num=Math.random();
                $url = $url + "/" + num;
                document.getElementById('captchapic').src=$url;
                document.getElementById('captchanum').value=num;
          }
        </script>
    </body>
</html>
