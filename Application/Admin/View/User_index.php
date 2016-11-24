<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<include file="./Application/Admin/View/headinclude.php" />

</head>
<body>
<include file="./Application/Admin/View/header.php" />
<include file="./Application/Admin/View/leftmenu.php" />
<include file="./Application/Admin/View/rightmenu.php" />

	<div class="container main-frame">
		<div class="row">  
			<div id="content" class="col-xs-12"> 

				<!-- bread Crumb -->
				<div>
					<hr>
					<ul class="breadcrumb">
						<li>
							<a href="<?php echo U("Index/index"); ?>">首页</a>
						</li>
						<li class="active">
							用户列表
						</li>
					</ul>
					<hr>
				</div>
				
				<!-- Sortable Table -->
				<div class="row sortable ui-sortable" id="media-list">
					<div class="box col-xs-12">

						<!-- Table Header -->
						<div class="box-header" data-original-title="">
							<h2><i class="glyphicon glyphicon-edit"></i><span class="break"></span>用户列表</h2>
						</div>

						<div class="box-content">
							<form method="get" action="__URL__/index" class="actionbox">
								<label class="col-md-1 hidden-sm hidden-xs text-right">昵称</label>
								<input class="col-md-2 col-xs-12" id="searchId" name="s_nickname" type="text" placeholder="用户昵称" value="{$search['nickname']}">
								<label class="col-md-1 hidden-sm hidden-xs text-right">手机号</label>
								<input class="col-md-2 col-xs-12" id="searchName" name="s_phone" type="text" placeholder="手机号" value="{$search['phone']}">
								<label class="col-md-1 hidden-sm hidden-xs text-right">邮箱</label>
								<input class="col-md-2 col-xs-12" id="searchMail" name="s_mail" type="text" placeholder="邮箱" value="{$search['mail']}">
								<input type="submit" value="查询" class="btn btn-primary col-md-2 col-xs-12">
								<div class="clearfix"></div>
							</form>
							<table width="100%" border="0" cellspacing="0" class="table table-hover">
								<thead>
									<tr class="tableTitle">
										<th class="col-md-1 hidden-sm hidden-xs">ID</th>
										<th class="col-md-3 hidden-sm hidden-xs">昵称</th>
										<th class="col-xs-4">手机号</th>
										<th class="col-xs-4">邮箱</th>
										<th class="col-md-1 col-xs-3">状态</th>
										<th class="col-md-3 hidden-sm hidden-xs">注册时间</th>
										<th class="col-md-1 col-xs-2">操作</th>
									</tr>
								</thead>
								<tbody>
									<?php if($list != null) {
										foreach($list as $Rs) { ?>
									<tr id="vip-<?php echo $Rs['id']; ?>">
										<td class="col-md-1 hidden-sm hidden-xs vip-id">{$Rs['id']}</td>

										<!-- nickname -->
										<td class="col-xs-6 text-ellipsis">
											<strong>{$Rs['nickname']}</strong>
										</td>

										<!-- phone -->
										<td class="col-xs-6 text-ellipsis">
											<strong>{$Rs['phone']}</strong>
										</td>

										<!-- Email -->
										<td class="col-xs-6 text-ellipsis">
											<strong>{$Rs['mail']}</strong>
										</td>

										<td class="col-sm-1 col-xs-3">
											<?php if($Rs['status']=='1'){?>
											<span class="label label-success">正常</span>
											<?php }else{?>
											<span class="label label-important">禁用</span>
											<?php }?> 
										</td>

										<td class="col-md-3 hidden-sm hidden-xs">{$Rs['add_time']}
										</td>

										<td class="col-sm-1 col-xs-2">
											<div class="btn-group">
												<a class="btn btn-xs dropdown-toggle" data-toggle="dropdown" href="#">操作<span class="caret"></span>
												</a>
												<ul class="dropdown-menu pull-right">
													<li>
														<a href="__URL__/detail/id/{$Rs['id']}"><i class="glyphicon glyphicon-edit"></i>用户信息</a>
													</li>
													<?php if($Rs['status']==1){ ?>
													<li>
														<a href="__URL__/setStatus/del/{$Rs['id']}/p/{$nowpage}"><i class="glyphicon glyphicon-remove"></i>禁用</a>
													</li>
													<?php }else{ ?>
													<li>
														<a href="__URL__/setStatus/renew/{$Rs['id']}/p/{$nowpage}"><i class="glyphicon glyphicon-ok"></i>恢复</a>
													</li>
													<?php }?>
												</ul>
											</div>
										</td>
									</tr>
									<?php } } else{ ?>
									<tr>
										<td colspan="6">还没有任何记录！</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
							<div class="pageBox">{$page}</div>
						</div>
					</div>
				</div> <!-- sortable table -->
                
                
			</div> <!-- #content --> 
		</div> <!-- .row --> 
	</div> <!-- .main-frame -->

	<include file="./Application/Admin/View/footer.php" />
	<include file="./Application/Admin/View/jsinclude.php" />

</body>
</html>