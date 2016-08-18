<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>重置密码</title>
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
            <a class="active" data-pjax="true" href="#">找回密码</a>
          </span>
        </h4>
        <div id="pjax-container">

    <div class="sign-in">
      <form class="form-horizontal" data-js-module="sign-in" action="/user/forgetpwd" accept-charset="UTF-8" method="post">

    <p id="signin_errors" class="signin_error"> <font color="red">{{ Session::get('errormessage') }}</font></p>

    <div class="input-prepend domestic">
      <input type="text" name="phone" id="sign_in_name" value="" class="span2" placeholder="手机号码" />
    </div>

    <div class="input-prepend authnum" style="text-align: left;">
        <input type="text" name="phonecode" id="authnum" style="padding-right:20px" class="span2" placeholder="请输入验证码" />
        <button type="button" class="ladda-button submit-button" style="font-size:14px;width:130px;height:40px;padding-top:8px;margin-left:25px" data-color="blue" id="resetpwd">
          <span class="ladda-label" id="resetpwdfont">获取验证码</span>
        </button>
    </div>

    <div class="input-prepend password ">
      <input type="password" name="password" id="sign_in_password" value="" class="span2" placeholder="新密码:     6~16个英文字母、符号或数字" />
    </div>

    <div class="input-prepend password " style="padding-bottom:15px;">
      <input type="password" name="password_confirmation" id="sign_in_repassword" class="span2" placeholder="确认密码" />
    </div>

    <button class="ladda-button submit-button" style="width:100%;height:40px;padding-top:5px;" data-color="blue">
      <span class="ladda-label">验证</span>
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
