<section class="sidebar">
	<!-- sidebar menu: : style can be found in sidebar.less -->

	<ul class="sidebar-menu">
		@if(Auth::user()['user_rank']==3)
		<li class="treeview" id="treeuser">
			<a href="#">
				<i class="fa fa-user"></i> <span>用户管理</span> <i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">
				<li><a href="/users"><i class="fa fa-circle-o"></i> 用户浏览</a></li>
				<li><a href="/cert"><i class="fa fa-circle-o"></i> 用户认证</a></li>
			</ul>
		</li>
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
				<li><a href="/tag"><i class="fa fa-circle-o"></i> 标签列表</a></li>
				<li><a href="/tag/create"><i class="fa fa-circle-o"></i> 添加标签</a></li>
				<li><a href="/catag"><i class="fa fa-circle-o"></i> 分类标签列表</a></li>
				<li><a href="/catag/create"><i class="fa fa-circle-o"></i> 添加分类标签</a></li>
			</ul>
		</li>
		<li class="treeview" id="treecate">
			<a href="#">
				<i class="fa fa-edit"></i> <span>商品分类管理</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">
				<li><a href="/goodcate"><i class="fa fa-circle-o"></i>商品分类列表</a></li>
				<li><a href="/goodcate/create"><i class="fa fa-circle-o"></i>添加商品分类</a></li>
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

	</ul>
</section>
