<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>工程列表</title>
		<script src="../home/js/jquery-3.1.0.min.js"></script>
		<script src="../home/js/businessjs.js"></script>
		<script src="../home/js/talent.js" type="text/javascript" charset="utf-8"></script>
		<link rel="stylesheet" type="text/css" href="../home/css/talent.css"/>
		<link rel="stylesheet" href="home/css/businessjs.css">
		<link rel="stylesheet" href="home/css/footer.css">
		<link rel="stylesheet" href="{{asset('home/css/top.css')}}">
		<script src="{{asset('home/js/top.js')}}"></script>
	</head>
	<body>
	@include('inc.home.top')
		<div class="header">
			<div class="header-container">
				<div class="logo">
					<a href="{{url('/')}}"><img src="../home/images/gongchengxq/logo.jpg"/></a>
				</div>
				<div class="search">
					<form class="search-form" method="post">
						<input type="text" name="search" class="search-text" placeholder="找工程&nbsp;找人才&nbsp;聊生活" />
						<input type="submit" value="搜索" class="search-btn"/>
					</form>
				</div>
				<div class="cl"></div>

			</div>	
		</div>
		<div class="navm">
			<div class="navc">
				<div class="navcontent">
					<ul>
						<li><a href="{{url('/')}}">首页</a></li>
						<li id="change"><a href="{{url('/business')}}">商机</a><img src="home/images/zhaohuo/9.jpg" alt="" class="buslist">
							<div class="cart">
								<p><a href="{{url('/project')}}">工程</a></p>
								<p><a href="{{url('/sergoods')}}">找货</a></p>
								<p><a href="{{url('/talent')}}">人才</a></p>
							</div>
						</li>

						<li id="change1"><a href="{{url('/community')}}">社区</a>
						</li>

						<li id="change2"><a href="{{url('/equipment')}}">设备选购</a><img src="home/images/zhaohuo/9.jpg" alt="" style="right: 15px;"  class="buslist2">
							<div class="cart2">
								<p><a href="{{url('/equipment')}}">安虫自营</a></p>
							</div>
						</li>

						<li><a href="{{url('/info')}}">资讯</a></li>
					</ul>
				</div>

			</div>
		</div>
		<div style="clear: both"></div>
		<hr class="nav-underline">

		<div class="banner">
			<img src="../home/images/gongchengxq/banner.jpg"/>
		</div>
		<div class="site-middle">
			<div class="middle-container">
				<div class="work">
					<a class="contract-work" href=""><img src="../home/images/gongchengxq/发包工程.png"/></a>
					<a class="package" href=""><img src="../home/images/gongchengxq/承接工程.png"/></a>
					<a class="release" href="{{url('/project/create')}}"><img src="../home/images/gongchengxq/发布工程.png"/></a>
				</div>
				<div class="nav">
					<div class="server">
						<ul class="server-type">
							<li class="type-title" style="width:180px">服务类别</li>
							<li class="type-list">探测监控</li>
							<li class="type-list">防护保障</li>
							<li class="type-list">探测报警</li>
							<li class="type-list">弱电工程</li>
							<li class="type-list">呼救器</li>
							<li class="type-list">楼宇对讲</li>
							<li class="type-list">快速通道</li>
							<li class="show-list"><span id="flip">展开 <b class="caret"></b></span></li>
                            <div class="cl"></div>
						</ul>
						<ul class="server-type" id="yy" style="display: none;">
							<li><a href="#">按时打算</a></li>
							<li><a href="#">探测监视</a></li>
							<li><a href="#">防护保障</a></li>
							<li><a href="#">探测报警</a></li>
							<li><a href="#">弱电工程</a></li>
							<li><a href="#">呼救器</a></li>
							<li><a href="#">楼宇对讲</a></li>
							<li ><a href="#">快速通道</a></li>
							<li><a href="#">楼宇对讲</a></li>
							<li ><a href="#">快速通道</a></li>
						</ul>
						<ul class="server-area">
							<li class="area-title" style="width:180px">区&nbsp;&nbsp;域</li>
							<li class="area-list">北京市</li>
							<li class="area-list">上海市</li>
							<li class="area-list">武汉市</li>
							<li class="area-list">保定市</li>
							<li class="area-list">石家庄</li>
							<li class="area-list">衡水市</li>
							<li class="area-list">邢台市</li>
							<li class="show-list"><span id="show">展开<b class="caret"></b></span></li>
                            <div class="cl"></div>
						</ul>
						<ul class="server-type" id="adress" style="display: none">
							<li><a href="#">北京市</a></li>
							<li><a href="#">上海市</a></li>
							<li><a href="#">武汉市</a></li>
							<li><a href="#">保定市</a></li>
							<li><a href="#">石家庄市</a></li>
							<li><a href="#">衡水市</a></li>
							<li><a href="#">邢台市</a></li>
							<li><a href="#">北京市</a></li>
							<li><a href="#">上海市</a></li>
							<li><a href="#">武汉市</a></li>
						</ul>

					</div>
				</div>
				<div class="project-list">
					<div class="sort">
						<span class="rank">排序</span>
						<span class="hot-rank">热门排序</span>
						<ul class="pages-turn">
                            <a href="{{$projectlist->previousPageUrl()}}" class="pageup">
                                <span class=""><</span>
                                <span class="">&nbsp;上一页</span>
                            </a>
                            <a href="{{$projectlist->nextPageUrl()}}" class="pagedown">
                                <span class="">下一页&nbsp;</span>
                                <span class="">></span>
                            </a>
                    </div>

					<div class="project-info">
						@foreach($projectlist as $g)
						<ul>
                            <li class="project-preview">
                                <p class="title"><a href="{{url('project/'.$g->bid)}}">{{$g->title}}</a></p>
                                <p class="digest"><nobr>{{$g->content}}</nobr></p>
                            </li>
                            <li class="image"><img src="{{$g->img}}"></li>
                            <li class="cl"></li>
                        </ul>
						@endforeach

					</div>
					<div class="pages">
						{{$projectlist->links()}}
                        <ul class="page-skip">
                            <i>共有{{$projectlist->lastpage()}}页，</i>
                            <i class="blank">
                                去第
                                <input class="page-num" type="text">
                                页
                            </i>
                            <input class="page-btn" type="button" value="确定">
                        </ul>
                        <div class="cl"></div>
					</div>
				</div>
			</div>
		</div>
	@include('inc.home.footer')
		<script src="home/js/orderlist.js"></script>
	</body>
</html>
