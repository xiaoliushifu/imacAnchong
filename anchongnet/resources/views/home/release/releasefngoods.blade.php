<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>发布找货</title>
    <link rel="stylesheet" href="../home/css/releasefngoods.css">
    <script src="../home/js/jquery-3.1.0.min.js"></script>
    <link rel="stylesheet" href="{{asset('home/css/top.css')}}">
    <script src="{{asset('home/js/top.js')}}"></script>
</head>
<body>
@include('inc.home.top')
<div class="header-center">
    <div class="header-main">
        <div class="logo">
            <a href="{{url('/')}}"><img src="../home/images/release/7.jpg" alt=""></a>
        </div>
        <div class="search">
            <div class="searchbar">
                <input type="text" class="biaodan">
                <button type="button" class="btn">搜索</button>

            </div>

        </div>

    </div>
</div>
<div class="nav">
    <div class="navc">
        <div class="navcontent">
            <ul>
                <li><a href="#">首页</a></li>
                <li><a href="#">商机<img src="../home/images/release/9.jpg" alt=""></a></li>
                <li><a href="#">社区<img src="../home/images/release/9.jpg" alt=""></a></li>
                <li><a href="#">设备选购<img src="../home/images/release/9.jpg" alt="" style="left: 70px;"></a></li>
                <li><a href="#">资讯</a></li>
            </ul>
        </div>

    </div>

</div>
<div style="clear: both"></div>
<hr class="nav-underline">
<div class="centermain">
    <div class="submain">
        <div class="adress">
            <p>您的位置：首页>>我的发布>><span>发包工程</span></p>
            <h4>找货描述</h4>
            <div style="clear: both"></div>
            <hr>
        </div>

        <form action="" method="post">
        <div class="main">
            <div class="main-left">

                    <table>
                        <tr>
                            <th class="centitle">标题:</th>
                            <td>
                                <input type="text" name="cate_name">
                            </td>
                        </tr>
                        <tr>
                            <th class="cencontent">内容:</th>
                            <td>
                                <textarea  placeholder="输入详细内容"></textarea>
                            </td>
                        </tr>
                    </table>
            </div>

        </div>


                <div class="upload">
                    <div class="upload-title"><h3>上传照片</h3></div><p>选择装修过程中的照片，每张低于5M,支持JPG/JPEG/PNG格式，最多6张</p>
                    <div style="clear: both"></div>
                    <hr>
                </div>

            <div class="upload-pic">
                <ul>
                    <li><img src="../home/images/release/shch.png" alt=""></li>
                    <li><img src="" alt=""></li>
                    <li><img src="" alt=""></li>
                    <li><img src="" alt=""></li>
                </ul>
            </div>

<div class="publish"><input type="submit" value="找货"></div>

        </form>



    </div>
</div>


@include('inc.home.footer')
</body>
</html>