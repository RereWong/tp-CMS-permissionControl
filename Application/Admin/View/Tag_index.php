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
							标签管理
						</li>
					</ul>
					<hr>
				</div>

				<!-- Sortable Table -->
				<div class="row sortable ui-sortable" id="media-list">
					<div class="box col-xs-12">

						<!-- Table Header -->
						<div class="box-header" data-original-title="">
							<h2><i class="glyphicon glyphicon-edit"></i><span class="break"></span>标签列表</h2>
						</div>

						<div class="box-content">
							<form method="get" action="__URL__/index" class="actionbox">
								<label class="col-md-1 hidden-sm hidden-xs text-right">ID</label>
								<input class="col-md-2 col-xs-12" id="searchId" name="s_id" type="text" placeholder="标签ID" value="{$search['id']}">
								<label class="col-md-1 hidden-sm hidden-xs text-right">名字</label>
								<input class="col-md-2 col-xs-12" id="searchName" name="s_name" type="text" placeholder="标签名字" value="{$search['name']}">
								<input type="submit" value="查询" class="btn btn-primary col-md-2 col-xs-12">
								<div class="clearfix"></div>
							</form>
							<table width="100%" border="0" cellspacing="0" class="table table-hover">
								<thead>
									<tr class="tableTitle">
										<th class="hidden-xs">ID</th>
										<th class="col-xs-6">名字</th>
										<th class="col-xs-3">使用次数</th>
									</tr>
								</thead>
								<tbody>
									<?php if($list != null) {
										foreach($list as $Rs) { ?>
									<tr id="vip-<?php echo $Rs['id']; ?>">
										<td class="hidden-xs vip-id">{$Rs['id']}</td>

										<td class="col-xs-6 text-ellipsis">
											<strong>{$Rs['name']}</strong>
										</td>

										<td class="col-xs-3">
											{$Rs['use_count']}
										</td>
										

										<!-- <td class="col-md-2">
											<div class="btn-group">
												<a class="btn btn-xs dropdown-toggle" data-toggle="dropdown" href="#">操作<span class="caret"></span>
												</a>
												<ul class="dropdown-menu pull-right">
													<li>
														<a href="__URL__/detail/id/{$Rs['id']}"><i class="glyphicon glyphicon-edit"></i>编辑该标签</a>
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
										</td> -->
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