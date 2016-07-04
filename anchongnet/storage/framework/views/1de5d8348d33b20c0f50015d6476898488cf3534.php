<!doctype html>
<html>
<head>
    <title>test</title>
    <meta charset="utf-8">
</head>
<body>
<form action="/shop" method="post" enctype="multipart/form-data">
    <input type="text" name="uid" value="23">
    <input type="text" name="logo" value="www.baidu.com">
    <input type="text" name="name" value="棋谱狼">
    <input type="text" name="introduction" value="这里是一家黑店">
    <input type="text" name="address" value="北京">
    <input type="text" name="cat[]" value="1">
    <input type="text" name="cat[]" value="2">
    <input type="text" name="brandId[]" value="1">
    <input type="text" name="brandId[]" value="2">
    <input type="text" name="brandUrl[]" value="www.brand1.com">
    <input type="text" name="brandUrl[]" value="www.brand2.com">
    <button type="submit">提交</button>
</form>
</body>
</html>