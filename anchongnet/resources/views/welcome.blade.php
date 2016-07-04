<form class="form form-horizontal" action="/userregister" method="post">
 <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <div class="row cl">
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
  <div class="row">
    <div class="formControls col-8 col-offset-3">
      <input name="" type="submit" class="btn btn-success radius size-L" value="&nbsp;注&nbsp;&nbsp;&nbsp;&nbsp;测&nbsp;">
      <input name="" type="reset" class="btn btn-default radius size-L" value="&nbsp;取&nbsp;&nbsp;&nbsp;&nbsp;消&nbsp;">
    </div>
  </div>
</form>
