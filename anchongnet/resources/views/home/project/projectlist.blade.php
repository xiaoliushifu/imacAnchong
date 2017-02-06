<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>工程列表</title>
		<link rel="stylesheet" type="text/css" href="../home/css/talent.css"/>
		<link rel="stylesheet" href="home/css/businessjs.css">
		<link rel="stylesheet" href="home/css/footer.css">
		<link rel="stylesheet" href="{{asset('home/css/top.css')}}">
	</head>
	<body>
	@include('inc.home.top')
		<div class="header">
			<div class="header-container">
				<div class="logo">
					<a href="{{url('/')}}"><img src="../home/images/gongchengxq/logo.jpg"/></a>
				</div>
<!-- 				<div class="search"> -->
<!-- 					<form class="search-form"> -->
<!-- 						<input type="text" name="search" class="search-text" placeholder="找工程&nbsp;找人才&nbsp;聊生活" /> -->
<!-- 						<input type="submit" value="搜索" class="search-btn"/> -->
<!-- 					</form> -->
<!-- 				</div> -->
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
						<li id="change1"><a href="{{url('/community')}}">社区</a></li>
						<li id="change2"><a href="{{url('/equipment')}}">设备选购</a></li>
						<li><a href="{{url('/info')}}">资讯</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div style="clear: both"></div>
		<hr class="nav-underline">
		<div class="banner">
			<img src="/home/images/gongchengxq/banner.jpg"/>
		</div>
		<div class="site-middle">
			<div class="middle-container">
				<div class="work">
					<a class="contract-work" href="{{url('project')}}"><img src="/home/images/gongchengxq/发包工程.png"/></a>
					<a class="package" href="{{url('serproject/lepro')}}"><img src="/home/images/gongchengxq/承接工程.png"/></a>
					<a class="release" href="{{url('project/create')}}"><img src="/home/images/gongchengxq/发布工程.png"/></a>
				</div>
				<div class="nav">
					<div class="server">
						<hr style="border-bottom: 5px #9b9b9b solid;">
						<ul class="server-type" style="border-bottom: 1px #9b9b9b solid;height: 50px;">
							<li class="type-title"><span>服务类别</span></li>
							@foreach($serprocate as $s)
								<li><a href="{{url('serproject/listcate/'.$s->id)}}">{{$s->tag}}</a></li>
							@endforeach
							<li class="downmenue" style="width: 80px;height: 50px;float: right;font-size: 14px;color:#606060;"><span  id="flip" >展开 <b class="caret"></b></span> </li>
						</ul>
						<ul class="server-type" id="yy" style="display: none; float: left;">
							@foreach($lastadpro as $m)
								<li style="border-bottom: 1px #9b9b9b solid;"><nobr><a href="{{url('serproject/listcate/'.$m->id)}}">{{$m->tag}}</a></nobr></li>
							@endforeach
						</ul>
						<ul class="server-type" style="float: left">
							<li class="type-title-1"><span>区域</span></li>
							@foreach($serpro as $a)
								<li><a href="{{url('serproject/listcate/'.$a->id)}}">{{$a->tag}}</a></li>
							@endforeach
							<li class="downmenue" style="width: 80px;height: 50px;float: right;font-size: 14px;color:#606060;"><span  id="show" >展开 <b class="caret"></b></span></li>
						</ul>
						<ul class="server-type" id="adress" style="display: none;float: left;overflow: hidden;">
							@foreach($lastserpro as $d)
								<li style="border-bottom: 1px #9b9b9b solid;"><a href="{{url('serproject/listcate/'.$d->id)}}">{{$d->tag}}</a></li>
							@endforeach

						</ul>
						<div style="clear: both;"></div>
						<hr style="border-bottom: 1px #9b9b9b solid;">
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
							<form action="{{url('gopage/gcpage')}}" method="post">
								{{csrf_field()}}
                            <i>共有{{$projectlist->lastpage()}}页，</i>
                            <i class="blank">
                                去第
                                <input class="page-num" type="text" name="page">
                                页
                            </i>


							<button class="busb" type="submit">确定</button>
							</form>
                        </ul>
                        <div class="cl"></div>
					</div>
				</div>
			</div>
		</div>
	@include('inc.home.footer')
	<script src="/home/js/jquery-3.1.0.min.js"></script>
	<script src="/home/js/businessjs.js"></script>
	<script src="/home/js/talent.js" type="text/javascript" charset="utf-8"></script>
	<script src="/home/js/orderlist.js"></script>
	</body>
</html>
