<header class="main-header">
	<!-- Logo -->
	<a href="index2.blade.php" class="logo">
		<!-- mini logo for sidebar mini 50x50 pixels -->
		<span class="logo-mini"><b>安</b>虫</span>
		<!-- logo for regular state and mobile devices -->
		<span class="logo-lg"><b>安虫</b>网</span>
	</a>
	<!-- Header Navbar: style can be found in header.less -->
	<nav class="navbar navbar-static-top" role="navigation">
		<!-- Sidebar toggle button-->
		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
		</a>

		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<!-- Notifications: style can be found in dropdown.less -->
				<li class="dropdown notifications-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-bell-o"></i>
						<span class="label label-warning">30</span>
					</a>
					<ul class="dropdown-menu">
						<li class="header">您有十个通知</li>
						<li>
							<!-- inner menu: contains the actual data -->
							<ul class="menu">
								<li>
									<a href="#">
										<i class="fa fa-users text-aqua"></i> 5条站内信
									</a>
								</li>
							</ul>
						</li>
						<li class="footer"><a href="#">查看所有</a></li>
					</ul>
				</li>
				<!-- User Account: style can be found in dropdown.less -->
				@include('inc.admin.usermain')
				<!-- Control Sidebar Toggle Button -->
			</ul>
		</div>
	</nav>
</header>
