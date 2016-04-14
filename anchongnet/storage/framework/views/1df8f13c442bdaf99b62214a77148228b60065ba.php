<section class="sidebar">
	<!-- Sidebar user panel -->
	<div class="user-panel">
		<div class="pull-left image">
			<img src="/admin/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
		</div>
		<div class="pull-left info">
			<p>安虫管理员</p>
			<a href="#"><i class="fa fa-circle text-success"></i> admin</a>
		</div>
	</div>
	<!-- search form -->
	<form action="#" method="get" class="sidebar-form">
		<div class="input-group">
			<input type="text" name="q" class="form-control" placeholder="搜索">
					<span class="input-group-btn">
						<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
						</button>
					</span>
		</div>
	</form>
	<!-- /.search form -->
	<!-- sidebar menu: : style can be found in sidebar.less -->
	<ul class="sidebar-menu">
			<li class="active treeview">
			<a href="#">
				<i class="fa fa-user"></i> <span>用户管理</span> <i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">
				<li><a href="/users"><i class="fa fa-circle-o"></i> 用户浏览</a></li>
				<li><a href="/cert"><i class="fa fa-circle-o"></i> 用户认证</a></li>
			</ul>
		</li>
		<li class="treeview">
			<a href="#">
				<i class="fa fa-files-o"></i>
				<span>布局选项</span>
				<span class="label label-primary pull-right">4</span>
			</a>
			<ul class="treeview-menu">
				<li><a href="/pages/layout/top-nav.blade.php"><i class="fa fa-circle-o"></i> 顶部导航</a></li>
				<li><a href="/pages/layout/boxed.blade.php"><i class="fa fa-circle-o"></i> Boxed</a></li>
				<li><a href="/pages/layout/fixed.blade.php"><i class="fa fa-circle-o"></i> Fixed</a></li>
				<li><a href="/pages/layout/collapsed-sidebar.blade.php"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
			</ul>
		</li>
		<li>
			<a href="/pages/widgets.blade.php">
				<i class="fa fa-th"></i> <span>小部件</span>
				<small class="label pull-right bg-green">new</small>
			</a>
		</li>
		<li class="treeview">
			<a href="#">
				<i class="fa fa-pie-chart"></i>
				<span>图表</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">
				<li><a href="/pages/charts/chartjs.blade.php"><i class="fa fa-circle-o"></i> ChartJS</a></li>
				<li><a href="/pages/charts/morris.blade.php"><i class="fa fa-circle-o"></i> Morris</a></li>
				<li><a href="/pages/charts/flot.blade.php"><i class="fa fa-circle-o"></i> Flot</a></li>
				<li><a href="/pages/charts/inline.blade.php"><i class="fa fa-circle-o"></i> Inline charts</a></li>
			</ul>
		</li>
		<li class="treeview">
			<a href="#">
				<i class="fa fa-laptop"></i>
				<span>订单管理</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">

				<li><a href="/order"><i class="fa fa-circle-o"></i>订单列表</a></li>

			</ul>
		</li>
		<li class="treeview">
			<a href="#">
				<i class="fa fa-edit"></i> <span>表单</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">
				<li><a href="/pages/forms/general.blade.php"><i class="fa fa-circle-o"></i> General Elements</a></li>
				<li><a href="/pages/forms/advanced.blade.php"><i class="fa fa-circle-o"></i> Advanced Elements</a></li>
				<li><a href="/pages/forms/editors.blade.php"><i class="fa fa-circle-o"></i> Editors</a></li>
			</ul>
		</li>
		<li class="treeview">
			<a href="#">
				<i class="fa fa-table"></i> <span>表格</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">
				<li><a href="/pages/tables/simple.blade.php"><i class="fa fa-circle-o"></i> Simple tables</a></li>
				<li><a href="/pages/tables/data.blade.php"><i class="fa fa-circle-o"></i> Data tables</a></li>
			</ul>
		</li>
		<li>
			<a href="/pages/calendar.blade.php">
				<i class="fa fa-calendar"></i> <span>日历</span>
				<small class="label pull-right bg-red">3</small>
			</a>
		</li>
		<li>
			<a href="/pages/mailbox/mailbox.blade.php">
				<i class="fa fa-envelope"></i> <span>邮箱</span>
				<small class="label pull-right bg-yellow">12</small>
			</a>
		</li>
		<li class="treeview">
			<a href="#">
				<i class="fa fa-folder"></i> <span>小示例</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">
				<li><a href="/pages/examples/invoice.blade.php"><i class="fa fa-circle-o"></i> Invoice</a></li>
				<li><a href="/pages/examples/profile.blade.php"><i class="fa fa-circle-o"></i> Profile</a></li>
				<li><a href="/pages/examples/login.blade.php"><i class="fa fa-circle-o"></i> Login</a></li>
				<li><a href="/pages/examples/register.blade.php"><i class="fa fa-circle-o"></i> Register</a></li>
				<li><a href="/pages/examples/lockscreen.blade.php"><i class="fa fa-circle-o"></i> Lockscreen</a></li>
				<li><a href="/pages/examples/404.blade.php"><i class="fa fa-circle-o"></i> 404 Error</a></li>
				<li><a href="/pages/examples/500.blade.php"><i class="fa fa-circle-o"></i> 500 Error</a></li>
				<li><a href="/pages/examples/blank.blade.php"><i class="fa fa-circle-o"></i> Blank Page</a></li>
				<li><a href="/pages/examples/pace.blade.php"><i class="fa fa-circle-o"></i> Pace Page</a></li>
			</ul>
		</li>
		<li class="treeview">
			<a href="#">
				<i class="fa fa-share"></i> <span>多级</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">
				<li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
				<li>
					<a href="#"><i class="fa fa-circle-o"></i> Level One <i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
						<li>
							<a href="#"><i class="fa fa-circle-o"></i> Level Two <i class="fa fa-angle-left pull-right"></i></a>
							<ul class="treeview-menu">
								<li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
								<li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
							</ul>
						</li>
					</ul>
				</li>
				<li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
			</ul>
		</li>
		<li><a href="/documentation/index.blade.php"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
		<li class="header">LABELS</li>
		<li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
		<li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
		<li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
	</ul>
</section>
