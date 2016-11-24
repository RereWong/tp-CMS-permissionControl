
<div id="main-nav-drawer" class="nav-drawer-menu nav-drawer-menu-inverse nav-drawer-left">
	<ul class="nav nav-tabs nav-stacked main-menu">
		<li <?php if(CONTROLLER_NAME == 'Index'){ ?>class="active"<?php } ?>>
			<a href="<?php echo U("Index/index"); ?>">
				<i class="icon-home icon-white"></i>
				<span class="hidden-tablet"> 首页</span>
			</a>
		</li>

        <li <?php if((CONTROLLER_NAME == 'Admin' && ACTION_NAME!='self') || CONTROLLER_NAME == 'Role'){ ?>class="active"<?php } ?>>
			<a href="<?php echo U("Admin/list"); ?>">
				<i class="icon-home icon-white"></i>
				<span class="hidden-tablet"> 管理员管理</span>
			</a>
			<ul >
				<li>
					<a href="<?php echo U("Admin/list"); ?>" class="submenu">
						<i class="icon-tasks icon-white"></i>
						<span class="hidden-tablet"> 管理员列表</span>
					</a>
				</li>
				<li>
					<a href="<?php echo U("Role/list"); ?>" class="submenu">
						<i class="icon-list-alt icon-white"></i>
						<span class="hidden-tablet"> 角色列表</span>
					</a>
				</li>
			</ul>
		</li>

        <li <?php if(CONTROLLER_NAME == 'User'){ ?>class="active"<?php } ?>>
			<a href="<?php echo U("User/index"); ?>">
				<i class="icon-home icon-white"></i>
				<span class="hidden-tablet"> 用户管理</span>
			</a>
		</li>

		<li <?php if(CONTROLLER_NAME == 'News'){ ?>class="active"<?php } ?>>
			<a href="<?php echo U("News/index"); ?>">
				<i class="icon-list-alt icon-white"></i>
				<span class="hidden-tablet"> 内容管理</span>
			</a>
		</li>

		<li <?php if(CONTROLLER_NAME == 'Tag'){ ?>class="active"<?php } ?>>
			<a href="<?php echo U("Tag/index"); ?>">
				<i class="icon-list-alt icon-white"></i>
				<span class="hidden-tablet"> 标签管理</span>
			</a>
		</li>

		<li <?php if(CONTROLLER_NAME == 'Comment'){ ?>class="active"<?php } ?>>
			<a href="<?php echo U("Comment/index"); ?>">
				<i class="icon-home icon-white"></i>
				<span class="hidden-tablet"> 评论管理</span>
			</a>
		</li>

		<!-- <li <?php if(CONTROLLER_NAME == 'Tags'){ ?>class="active"<?php } ?>>
			<a href="javascript:void(0)">
				<i class="icon-list-alt icon-white"></i>
				<span class="hidden-tablet"> TAGS管理</span>
			</a>
			<ul <?php if(CONTROLLER_NAME == 'Tags'){ ?>style="display:block"<?php } ?>>
				<li>
					<a href="<?php echo U("Tags/manage",array('lang'=>'en')); ?>" class="submenu">
						<i class="icon-tasks icon-white"></i>
						<span class="hidden-tablet"> 英文TAGS管理</span>
					</a>
				</li>
				<li>
					<a href="<?php echo U("Tags/manage",array('lang'=>'zh')); ?>" class="submenu">
						<i class="icon-list-alt icon-white"></i>
						<span class="hidden-tablet"> 中文TAGS管理</span>
					</a>
				</li>
			</ul>
		</li> -->

	</ul>
</div>