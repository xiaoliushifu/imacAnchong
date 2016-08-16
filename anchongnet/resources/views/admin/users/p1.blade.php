<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>100人摇奖</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link href="/styles/css/prize.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/styles/css/bootstrap.min.css">
</head>
<body>
<div class="container" >
    <div class="container"><img src="/images/background-1.jpg" alt="这是背景图片"></div>
    <div class="container" id="background">
         <img src="/images/background-2.jpg" alt="这是背景图片">
         <div class="row" id="main">
             <div id="left-box" class="col-lg-8 col-md-8 col-xs-8">
             	<!-- 一等奖 图片 -->
                 <div id="level-pic" ><img id="flevel"  src="/images/fenlei_01.png" alt="这是分类图片"></div>
                 <div class="background">
                     <img src="/images/kuang_03.jpg" alt="这是中奖者背景">
                     <ul id="list">
                         <li><span> 等候抽奖</span></li>
                     </ul>
                 </div>
                 <div id="select-level">
                 	<!-- 操作按钮 -->
                     <a><img id="actbut" onclick="action('aaa')" src="/images/draw.png" alt=""></a>
                     <!--<a><img src="/images/1_03.png" ></a>&nbsp;&nbsp;
                     <a><img src="/images/2_03.png" ></a>&nbsp;&nbsp;
                     <a><img src="/images/3_03.png" ></a>&nbsp;&nbsp;
                     <a><img src="/images/4_03.png" ></a>-->
                 </div>
             </div>
             <div id="right-box" class="col-lg-4 col-md-4 col-xs-4">																							<!-- 奖品图 -->
                 <div><img id="prize-background" src="/images/prize—background.png" alt="这里是奖品背景图"><img id="prize" src="/images/battery.png"  alt="这里是奖品图"></div>
             </div>
         </div>
    </div>
</div>
<script src="/admin/plugins/jQuery/jQuery-2.2.0.min.js"></script>
<!-- <script src="//cdn.bootcss.com/jquery/3.1.0/core.js"></script> -->
<script src="/styles/js/bootstrap.js"></script>
<script>
var a=[[]];
var a2=[];
var plevel='';
 $(function(){
	 $.ajax({
		 url:'/prize/index',
		 success:function(data){
			 if (data.length < 10) {
				 alert('本次抽奖人员名单不足10人，请抓紧注册');
				window.history.go('-1');
		     }
			 a=data;
		 },
		 error:function(xhr,text){
			 alert(text);
		 }
	 });
 })
 /*
 */
function action(str)
{
		if (!a.length) {
			alert('人员名单不足,请刷新,让我们从新开始');
			$('#actbut').attr('src','/images/draw.png');
			return;
		}
		var src =$('#actbut').attr('src');
		src =src.substring(src.lastIndexOf('/')+1);
		if (src=="draw.png") {
			isRun=true;
			run();
			$('#actbut').attr('src','/images/stop.png');
			switch (a2.length) {
				case 0:
					$('#flevel').attr('src','/images/fenlei_01.png');
					plevel='一等奖';
					break;
				case 1:
					$('#flevel').attr('src','/images/fenlei_02.png');
					$('#prize').attr('src','/images/cup.png');
					plevel='二等奖';
					break;
				case 2:
					$('#flevel').attr('src','/images/fenlei_03.png');
					$('#prize').attr('src','/images/mingpianjia.png');
					plevel='三等奖';
					break;
				default:
					$('#flevel').attr('src','/images/fenlei_special-.png');
					$('#prize').attr('src','/images/phonetie.png');
					plevel='特别奖';
			}
		} else {
			isRun=false;
			$('#actbut').attr('src','/images/draw.png');
		}
}
/**
 */
function run()
{
	if (!a.length) {
		alert('中奖名单为空,请刷新,让我们从新开始');
		$('#actbut').attr('src','/images/draw.png');
		return;
	}
	var i = Math.floor(Math.random() * a.length+ 1)-1;
	$("li").replaceWith('<li><span>'+a[i][1]+'</span>&nbsp;&nbsp;&nbsp;&nbsp;<span>'+a[i][2]+'</span></li>');
	if(isRun==false){
		a2.push([a[i][0],plevel]);
		var tmpl=['this is a goodidea  ',
			  		'var a=a2=[]',
			  		'if (a2.length==a.length) {',
			  		'a2.push([a[i][0],plevel]);',
			  		'a.splice(m,1);}',
			  		'var i = Math.floor(Math.random() * a.length+ 1)-1;',
			  		'a.splice(m,1);',
			  		'src =src.substring(src.lastIndexOf('/')+1);',
			  		'!function(a,b){"object"==typeof module&&"object"==typeof module.exports?exports.length',
			  		'function(a,b,c){var d=b[0];return c&&(a=":not("+a+")")}',
			  		'function(a,b,c){var d=b[0];return c&&(a=":not("+a+")")}',
			  		'$.ajax({',
			  		'				type:"post",',
			  		'				 url:"/prize/list",',
			  		'				 data:{a2},',
			  		'				 success:function(data){',
			  		'					 alert("this is errorpage");',
			  		'					 location.href="/prize/p23";',
			  		'				 },',
			  	    ];
		if (a2.length==10) {
			$.ajax({
				type:'post',
				 url:'/prize/list',
				 data:{a2},
				 success:function(data){
					 alert('本轮抽奖结束');
					 location.href='/prize/p2';
				 },
				 error:function(xhr,text){
					 alert(text);
				 }
			 });
		}
		a.splice(i,1);
		return;
	}
	setTimeout("run()",30);
}
</script>
</body>
</html>
