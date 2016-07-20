<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<!--[if lt IE 9]>
<script type="text/javascript" src="lib/html5.js"></script>
<script type="text/javascript" src="lib/respond.min.js"></script>
<script type="text/javascript" src="lib/PIE_IE678.js"></script>
<![endif]-->
<link href="/admin/css/H-ui.min.css" rel="stylesheet" type="text/css" />
<link href="/admin/css/Hui-iconfont/1.0.6/iconfont.css" rel="stylesheet" type="text/css" />
<link href="/admin/css/H-ui.login.css" rel="stylesheet" type="text/css" />
<link href="/admin/css/style.css" rel="stylesheet" type="text/css" />
<!--[if IE 6]>
<script type="text/javascript" src="http://lib.h-ui.net/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>后台登录 - 安虫平台</title>
</head>
<body>
<input type="hidden" id="TenantId" name="TenantId" value="" />
<div class="loginWraper">
  <div id="loginform" class="loginBox">
    <form class="form form-horizontal" action="/checklogin" method="post">
     <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <div class="row cl">
          <font color="red">{{ Session::get('loginmes') }}{{ Session::get('loginmess') }}</font>
        <label class="form-label col-3"><i class="Hui-iconfont">&#xe60d;</i></label>
        <div class="formControls col-8">
          <input id="" name="username" type="text" placeholder="账户" class="input-text size-L" required="required">
        </div>
      </div>
      <div class="row cl">
        <label class="form-label col-3"><i class="Hui-iconfont">&#xe60e;</i></label>
        <div class="formControls col-8">
          <input id="" name="password" type="password" placeholder="密码" class="input-text size-L" required="required">
        </div>
      </div>
      <div class="row cl">
        <div class="formControls col-8 col-offset-3">
          <input class="input-text size-L" type="text" name="captchapic" placeholder="验证码" onfocus="javascript:this.value=''" onclick="if(this.value=='验证码:'){this.value='';}" value="验证码:" style="width:150px;" required="required">
          <img src="/captcha/110" id="captchapic" onclick="captcha()">  <font color="red">{{ Session::get('admincaptcha') }}</font> </div>
      </div>
      <div class="row">
        <div class="formControls col-8 col-offset-3">
          <input name="" type="submit" class="btn btn-success radius size-L" value="&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;录&nbsp;">
          <input name="" type="reset" class="btn btn-default radius size-L" value="&nbsp;取&nbsp;&nbsp;&nbsp;&nbsp;消&nbsp;">
        </div>
      </div>
    </form>
  </div>
</div>
<!-- <div class="footer">Copyright 你的公司名称 by H-ui.admin.v2.3</div> -->
<script type="text/javascript" src="/admin/plugins/jquery1/1.9.1/jquery.min.js"></script>
<script>
function captcha() {
	{{--一个自动生成url的laravel自定义函数--}}
	$url = "{{ URL('/captcha') }}";
        $url = $url + "/" + Math.random();
        document.getElementById('captchapic').src=$url;
  }
</script>
</body>
</html>
