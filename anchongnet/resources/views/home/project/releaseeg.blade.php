<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>发布工程</title>
    <link rel="stylesheet" href="../home/css/releaseeg.css">
    <script src="../home/js/jquery-3.1.0.min.js"></script>
    <link rel="stylesheet" href="{{asset('home/css/top.css')}}">
    <script src="{{asset('home/js/top.js')}}"></script>
</head>
<body>
@include('inc.home.top')
<div class="header-center">
    <div class="header-main">
        <div class="logo">
            <a href="{{url('/')}}"><img src="../home/images/release/logo.jpg" alt=""></a>
        </div>
        <div class="search">
            <div class="searchbar">
                <input type="text" class="biaodan">
                <button type="button" class="btn">搜索</button>
            </div>
        </div>
    </div>
</div>
<div style="clear: both"></div>
<hr class="topline">
<div class="centermain">
    <div class="submain">
        <div class="adress">
            <p>您的位置：首页>>我的发布>><span>发布商机</span></p>
        </div>
        <form action="/project" method="post">
        <input type="hidden"  name="_token" value="{{csrf_token()}}"/>
        <div class="main">
            <div class="main-left">
                    <table>
                        <tr>
                            <th class="centitle">标题:</th>
                            <td>
                                <input type="text" name="title">
                            </td>
                        </tr>
                        <tr>
                            <th class="cencontent">内容:</th>
                            <td>
                                <textarea  placeholder="输入详细内容" name="content"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th class="centitle">联系人:</th>
                            <td>
                                <input type="text" name="contact">
                            </td>
                        </tr>
                        <tr>
                            <th class="centitle">电话:</th>
                            <td>
                                <input type="text" name="phone">
                            </td>
                        </tr>
                        <tr>
                            <th class="btype">类型:</th>
                            <td>
                            		<select name="type">
                            			<option value="1" checked>发布工程</option>
                            			<option value="2">承接工程</option>
                            			<option value="3">发布人才</option>
                            			<option value="4">招聘人才</option>
                            			<option value="5">找商品</option>
                            		</select>
                            </td>
                        </tr>
                    </table>
            </div>
            <div class="main-right">
                <div class="rgtitle">
                    <h4>选择商机标签</h4>
                    <p>制定整工程预算，寻找合适的承接方，签订合同后开工</p>
                </div>
                <ul class="title-list">
                     <li>探测监控</li>
                    <li>防护保障</li>
                    <li>探测报警</li>
                    <li>防护保障</li>
                    <li>探测监控</li>
                    <li>防护保障</li>
                    <li>探测报警</li>
                    <li>防护保障</li>
                    <li>探测监控</li>
                    <li>防护保障</li>
                    <li>探测报警</li>
                    <li>防护保障</li>
                </ul>
            </div>
            <div class="main-right">
                <div class="rgtitle">
                    <h4>选择区域标签</h4>
                    <p>选择服务所在区域，帮助您更快的找到合适的工程方</p>
                </div>
                <ul class="title-list">
                    <li>北京</li>
                    <li>昌平区</li>
                    <li>河北承德</li>
                    <li>保定市</li>
                    <li>任丘</li>
                    <li>衡水市</li>
                    <li>石家庄</li>
                    <li>武汉市</li>
                </ul>
            </div>
        </div>
            <div class="upload">
                <div class="upload-title"><h3>上传照片</h3><p>选择装修过程中的照片，每张低于5M,支持JPG/JPEG/PNG格式，最多6张</p></div>
                <div style="clear: both"></div>
            </div>
            <div class="upload-pic">
                <ul>
                    <li><img src="../home/images/release/shch.png" alt=""></li>
                    <li><img src="" alt=""></li>
                    <li><img src="" alt=""></li>
                    <li><img src="" alt=""></li>
                </ul>
            </div>
		<div class="publish"><input type="submit" value="发布"></div>
        </form>
    </div>
</div>
@include('inc.home.footer')
</body>
</html>