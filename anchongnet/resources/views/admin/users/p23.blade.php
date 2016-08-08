<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>2000人获奖名单</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link href="/styles/css/winner.list.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/styles/css/bootstrap.min.css">

</head>
<body>
<div class="container" >
    <div class="container"><img src="/images/background-1.jpg" alt="这是背景图片"></div>
    <!--此处为背景-->
    <div class="container" id="background">
        <img src="/images/background-2.jpg" alt="这是背景图片">
        <!--此处主要内容绝对定位到背景图片上-->
        <div id="main">
            <div class="left-box ">
                <div class="box">
                     <div class="prize"><img src="/images/01_03.png" alt=""></div>
                     <div class="prize"><img src="/images/view_phone.png" alt=""></div>
                     <div class="prize" id="add"><img src="/images2/+_03.png" alt=""></div>
                     <div class="prize"><img src="/images/li1_03.png" alt=""></div>
                </div>
                <div class="box">
                    <div class="prize"><img src="/images/02_03.png" alt=""></div>
                    <div class="prize"><img src="/images/view_pad.png" alt=""></div>
                    <div class="prize" id="add"><img src="/images2/+_03.png" alt=""></div>
                    <div class="prize"><img src="/images/view_battery.png" alt=""></div>
                </div>
                <div class="box">
                    <div class="prize"><img src="/images/03_03.png" alt=""></div>
                    <div class="prize"><img src="/images/li1_03.png" alt=""></div>
                    <div class="prize" id="add"><img src="/images2/+_03.png" alt=""></div>
                    <div class="prize"><img src="/images/li4_03.png" alt=""></div>
                </div>
                <div class="box">
                    <div class="prize"><img src="/images/04_03.png" alt=""></div>
                    <div class="prize"><img src="/images/view_battery.png" alt=""></div>
                    <div class="prize" id="add"><img src="/images2/+_03.png" alt=""></div>
                     <div class="prize"><img src="/images/li1_03.png" alt=""></div>
                </div>
            </div>
            <div class="right-box">
                <div class="list"><img src="/images/ming_03.png"></div>
                <div class="list2">
                    <img src="/images/lan_03.png">
                    <table id="ulist" width="96%">
                        <tr><td width="40%">稍等</td><td width="30%">大奖</td><td width="20%">马上来</td></tr>
                    </table>
                </div>

            </div>
        </div>
    </div>
<script src="/admin/plugins/jQuery/jQuery-2.2.0.min.js"></script>
<script src="/styles/js/bootstrap.js"></script>
<script type="text/javascript">
//加载事件，用于获取原始用户名单
$(function(){
	 $.ajax({
		 url:'/prize/list',
		 success:function(data){
			 if(!data.length){
				 alert('捎带，中奖名单即将揭晓!');
				 return ;
		      }
			 $('#ulist').empty();
			 for (var i=0;i<data.length;i++) {
			 	$('#ulist').append("<tr><td width='40%'>"+data[i].user+"</td><td width='30%'>"+data[i].phone+"</td><td width='20%'>"+data[i].plevel+"</td></tr>");
			 }
		 },
		 error:function(xhr,text){
			 alert(text);
		 }
	 });
});
</script>
</body>
</html>