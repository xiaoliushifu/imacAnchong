<li class="dropdown user user-menu">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<img src="{{Auth::user()['headpic']}}" class="user-image" alt="User Image">
		<span class="hidden-xs">{{Auth::user()['username']}}</span>
	</a>
	<ul class="dropdown-menu">
		<!-- User image -->
		<li class="user-header">
			<img src="{{Auth::user()['headpic']}}" class="img-circle" alt="User Image">
			<p>{{Auth::user()['username']}}</p>
		</li>
		<!-- Menu Footer-->
		<li class="user-footer">
			<div class="pull-left">
				<a href="#" class="btn btn-default btn-flat">修改信息</a>
			</div>
			<div class="pull-right">
				<a href="/logout" class="btn btn-default btn-flat">退出</a>
			</div>
		</li>
	</ul>
</li>
