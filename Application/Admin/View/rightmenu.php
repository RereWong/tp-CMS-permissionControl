<div id="user-nav-drawer" class="nav-drawer-menu nav-drawer-menu-inverse nav-drawer-right">
	<div class="nav-drawer-menu-content"></div>
	<ul>
		<li>
			<a class="btn" href="javascript:void(0);"><i class="glyphicon glyphicon-user"></i>Hi, {$adminInfo['name']}</a>
		</li>
		<li>
			<a class="btn" href="<?php echo U("Admin/editPwd"); ?>"><i class="glyphicon glyphicon-edit"></i>修改密码</a>
		</li>
		<li>
			<a class="btn" href="<?php echo U("Admin/self"); ?>"><i class="glyphicon glyphicon-edit"></i>个人信息</a>
		</li>
		<li>
			<a class="btn" href="<?php echo U("Index/index"); ?>"><i class="glyphicon glyphicon-home"></i>首页</a>
		</li>
		<li>
			<a class="btn" href="<?php echo U("Admin/loginout"); ?>"><i class="glyphicon glyphicon-log-out"></i>注销</a>
		</li>
	</ul>
</div>