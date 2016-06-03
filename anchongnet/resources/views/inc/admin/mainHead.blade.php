<header class="main-header">
	<!-- Logo -->
	<a href="index2.blade.php" class="logo">
		<!-- mini logo for sidebar mini 50x50 pixels -->
		<span class="logo-mini"><b>安</b>虫</span>
		<!-- logo for regular state and mobile devices -->
		@if(Auth::user()['user_rank']==3)
		    <span class="logo-lg"><b>安虫</b>网</span>
		@else
			<span class="logo-lg"><b>安虫</b>商户</span>
		@endif
	</a>
	<!-- Header Navbar: style can be found in header.less -->
	<nav class="navbar navbar-static-top" role="navigation">
		<!-- Sidebar toggle button-->
		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
		</a>

		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<!-- User Account: style can be found in dropdown.less -->
				@include('inc.admin.usermain')
				<!-- Control Sidebar Toggle Button -->
			</ul>
		</div>
	</nav>
</header>
