<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>上传干货</title>
    <link rel="stylesheet" type="text/css" href="{{asset('home/css/upload.css')}}"/>
    <script src="/home/js/jquery-3.1.0.js"></script>
    <script src="/home/js/webuploader.js"></script>
    <link rel="stylesheet" href="{{asset('home/css/top.css')}}">
    <script src="../home/js/top.js"></script>
</head>
<body>
@include('inc.home.top')
<div class="header">
    <div class="header-container">
        <div class="logo">
            <a href="{{url('/')}}"><img src="/home/images/logo.jpg"/></a>
        </div>
        <div class="site-nav">
            <ul class="navigation">
                <li class="home nav-item"><a href="{{url('/')}}">首页</a></li>
                <li class="business nav-item">
                    <a href="{{url('/business')}}">商机</a>
                    <span class="business-triangle"></span>
                    <div class="business-list">
                        <p><a href="">工程</a></p>
                        <p><a href="">人才</a></p>
                        <p><a href="">找货</a></p>
                    </div>
                </li>
                <li class="community nav-item"><a href="{{url('/community')}}">社区</a></li>
                <li class="equipment nav-item"><a href="{{url('/equipment')}}">设备选购</a></li>
                <li class="news nav-item"><a href="{{url('/info')}}">资讯</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="site-middle">
    <div class="middle-cont">
        <div class="middle-top">
            <i class="site-location">您的位置:</i>
            <i class="index">首页</i>
            <span class ="connector">></span>
            <i class="personal">资讯</i>
            <span class ="connector">></span>
            <i class="upload">上传干货</i>
        </div>
        <div class="upload-status">
            <img src="/home/images/info/uploading.png">
        </div>
        <div class="upload-content">
            <div id="fileList" class="uploader-list"></div>
            <div id="picker"></div>
            <p>从我的电脑选择要上传的文档：按住CTRL可以上传多份文档</p>
        </div>
        <div class="tips">
            <h3>温馨提示</h3>
            <p>1.你可以上传日常积累和撰写的文档资料，或者施工案例，支持多种文档类型：doc，docx，ppt，ppts，xls，xlsx，wps，PDF，txt。</p>
            <p>2.上传侵权内容的文档会被移除。</p>
            <p>3.为营造绿色的网络环境，严禁上传淫秽色情集低俗信息文档，让我们携手共同打造健康技术干货</p>
        </div>
    </div>
</div>
@include('inc.home.site-foot')
</body>
<script>
        //初始化
        var $list=$("#thelist");

        var uploader = WebUploader.create({

            // 选完文件后，是否自动上传。
            auto: true,

            // swf文件路径
            swf: 'Uploader.swf',

            // 文件接收服务端。
            server: '',

            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: {
                id:'#picker',
                innerHTML:'<img src="/home/images/info/selected_text.png">',
                multiple:true
            },
            //控制上传文件类型
            accept:{
                title:'Doucments',
                extensions:'doc,docx,ppt,ppts,xls,xlsx,wps,pdf,txt',
                mimeTypes:'application/pdf,text/plain,application/msword,application/vnd.ms-excel,application/vnd.ms-powerpoint'
            },
        });
        //上传进度
        uploader.on( 'uploadProgress', function( file, percentage ) {
            var $li = $( '#'+file.id ),
                    $percent = $li.find('.progress .progress-bar');

            // 避免重复创建
            if ( !$percent.length ) {
                $percent = $('<div class="progress progress-striped active">' +
                        '<div class="progress-bar" role="progressbar" style="width: 0%">' +
                        '</div>' +
                        '</div>').appendTo( $li ).find('.progress-bar');
            }

            $li.find('p.state').text('上传中');

            $percent.css( 'width', percentage * 100 + '%' );
        });
        //上传成功时调用
        uploader.on( 'uploadSuccess', function( file ) {
            $( '#'+file.id ).find('p.state').text('已上传');
        });
		//上传失败时调用
        uploader.on( 'uploadError', function( file ) {
            $( '#'+file.id ).find('p.state').text('上传出错');
        });
		//文件上传完后调用
        uploader.on( 'uploadComplete', function( file ) {
            $( '#'+file.id ).find('.progress').fadeOut();
        });
</script>
</html>