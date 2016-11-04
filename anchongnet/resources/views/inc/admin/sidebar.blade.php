<section class="sidebar">
	<!-- sidebar menu: : style can be found in sidebar.less -->
	{{--直接从模板分配变量--}}
	<ul class="sidebar-menu" attr="{{$ur = Auth::user()['user_rank']}}">
		@if( $ur ==3)
		<li class="treeview" id="treeuser">
			<a href="#">
				<i class="fa fa-user"></i> <span>用户管理</span> <i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">
				<li><a href="/user"><i class="fa fa-circle-o"></i> 用户浏览</a></li>
				<li><a href="/user/list"><i class="fa fa-circle-o"></i> 会员认证</a></li>
			</ul>
		</li>
		<!-- 只admin有 权限管理 -->
		    @if(Auth::user()['users_id']==1)
    		<li class="treeview" id="treeperm">
    			<a href="#">
    				<i class="fa fa-files-o"></i>
    				<span>权限管理</span>
    				<i class="fa fa-angle-left pull-right"></i>
    			</a>
    			<ul class="treeview-menu">
    				<li><a href="/permission"><i class="fa fa-circle-o"></i> 权限分配</a></li>
    				<li><a href="/permission/role"><i class="fa fa-circle-o"></i> 角色设置</a></li>
    				<li><a href="/permission/cp"><i class="fa fa-circle-o"></i> 权限添加</a></li>
    				<li><a href="/permission/cr"><i class="fa fa-circle-o"></i> 角色添加</a></li>
    				<li><a href="/search/page"><i class="fa fa-circle-o"></i> 商品搜索</a></li>
    			</ul>
    		</li>
    		<li class="treeview" id="treecoupon">
    			<a href="#">
    				<i class="fa fa-files-o"></i>
    				<span>券池管理</span>
    				<i class="fa fa-angle-left pull-right"></i>
    			</a>
    			<ul class="treeview-menu">
    				<li><a href="/coupon"><i class="fa fa-circle-o"></i>优惠券列表</a></li>
    				<li><a href="/coupon/create"><i class="fa fa-circle-o"></i>优惠券生成</a></li>
    			</ul>
    		</li>
			<li class="treeview" id="treepurse">
    			<a href="#">
    				<i class="fa fa-laptop"></i>
    				<span>钱袋管理</span>
    				<i class="fa fa-angle-left pull-right"></i>
    			</a>
    			<ul class="treeview-menu">
    				<li><a href="/purse"><i class="fa fa-circle-o"></i>用户提现</a></li>
    				<li><a href="/signin"><i class="fa fa-circle-o"></i>签到管理</a></li>
    				<li><a href="/beans"><i class="fa fa-circle-o"></i>虫豆充值</a></li>
    			</ul>
    		</li>
    		<li class="treeview" id="treefeedback">
			<a href="#">
				<i class="fa fa-edit"></i>
				<span>意见反馈</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">
				<li><a href="/feedback/show"><i class="fa fa-circle-o"></i>反馈查看</a></li>
			</ul>
		</li>
    	    @endif
		<li class="treeview" id="treeshop">
			<a href="#">
				<i class="fa fa-files-o"></i>
				<span>商铺管理</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">
				<li><a href="/shop"><i class="fa fa-circle-o"></i> 商铺列表</a></li>
				<li><a href="/logis"><i class="fa fa-circle-o"></i> 物流列表</a></li>
				<li><a href="/logis/create"><i class="fa fa-circle-o"></i> 添加物流</a></li>
			</ul>
		</li>
		<li class="treeview" id="treetag">
			<a href="javascript:">
				<i class="fa fa-th"></i>
				<span>标签管理</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">
				<li><a href="/tag"><i class="fa fa-circle-o"></i> 商机标签列表</a></li>
				<li><a href="/tag/create"><i class="fa fa-circle-o"></i> 添加商机标签</a></li>
				<li><a href="/catag"><i class="fa fa-circle-o"></i> 分类标签列表</a></li>
				<li><a href="/catag/create"><i class="fa fa-circle-o"></i> 添加分类标签</a></li>
			</ul>
		</li>
		<li class="treeview" id="treecate">
			<a href="#">
				<i class="fa fa-edit"></i> <span>品牌分类</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">
				<li><a href="/goodcate"><i class="fa fa-circle-o"></i>商品分类列表</a></li>
				<li><a href="/goodcate/create"><i class="fa fa-circle-o"></i>添加商品分类</a></li>
				<li><a href="/goodbrand"><i class="fa fa-circle-o"></i>商品品牌列表</a></li>
				<li><a href="/goodbrand/create"><i class="fa fa-circle-o"></i>添加商品品牌</a></li>
			</ul>
		</li>
		<li class="treeview" id="treeadvert">
			<a href="">
				<i class="fa fa-laptop"></i>
				<span>资讯管理</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">
				<!-- <li><a href="#"><i class="fa fa-circle-o"></i>商机广告</a></li>
				<li><a href="#"><i class="fa fa-circle-o"></i>商城广告</a></li> -->
				<li><a href="/advert/newsshow"><i class="fa fa-circle-o"></i>发布资讯</a></li>
				<li><a href="/advert/newsindex"><i class="fa fa-circle-o"></i>资讯查看</a></li>
				<li><a href="/propel"><i class="fa fa-circle-o"></i>信息推送</a></li>
			</ul>
		</li>
		@endif
		<li class="treeview" id="treegood">
			<a href="#">
				<i class="fa fa-pie-chart"></i>
				<span>商品管理</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">
				<li><a href="/commodity"><i class="fa fa-circle-o"></i> 商品列表</a></li>
				<li><a href="/commodity/create"><i class="fa fa-circle-o"></i> 添加商品</a></li>
				<li><a href="/good"><i class="fa fa-circle-o"></i> 货品列表</a></li>
				<li><a href="/good/create"><i class="fa fa-circle-o"></i> 添加货品</a></li>
			</ul>
		</li>
		<li class="treeview" id="treeorder">
			<a href="#">
				<i class="fa fa-laptop"></i>
				<span>订单管理</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">
				<li><a href="/order"><i class="fa fa-circle-o"></i>订单列表</a></li>
			</ul>
		</li>
		<li class="treeview" id="treerelease">
			<a href="#">
				<i class="fa fa-laptop"></i>
				<span>我的社区</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">
				@if($ur==3)
				<li><a href="/releases"><i class="fa fa-circle-o"></i>所有聊聊</a></li>
				@endif
				<li><a href="/release"><i class="fa fa-circle-o"></i>我的发布</a></li>
				<li><a href="/release/create"><i class="fa fa-circle-o"></i>添加发布</a></li>
			</ul>
		</li>
		<li class="treeview" id="treebusiness">
			<a href="#">
				<i class="fa fa-laptop"></i>
				<span>商机管理</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">
				@if($ur==3)
				<li><a href="/businesss"><i class="fa fa-circle-o"></i>所有商机</a></li>
				@endif
				<li><a href="/business"><i class="fa fa-circle-o"></i>我的商机</a></li>
				<li><a href="/business/create"><i class="fa fa-circle-o"></i>发布商机</a></li>
			</ul>
		</li>
		<li class="treeview" id="treelive">
			<a href="#">
				<i class="fa fa-laptop"></i>
				<span>直播管理</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">
				<li><a href="/live"><i class="fa fa-circle-o"></i>直播列表</a></li>
			</ul>
		</li>
	</ul>
</section>
