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
							内容管理
						</li>
					</ul>
					<hr>
				</div>
				
				<a href="<?php echo U('News/detail'); ?>" class="btn btn-primary">添加内容</a>
				<!-- Sortable Table -->
				<div class="row sortable ui-sortable" id="media-list">
					<div class="box col-xs-12">

						<!-- Table Header -->
						<div class="box-header" data-original-title="">
							<h2><i class="glyphicon glyphicon-edit"></i><span class="break"></span>内容列表</h2>
						</div>

						<div class="box-content">
							<form method="get" action="__URL__/index" class="actionbox">
								<label class="col-md-1 hidden-sm hidden-xs text-right">ID</label>
								<input class="col-md-2 col-xs-12" id="searchId" name="s_id" type="text" placeholder="内容ID" value="{$search['id']}">
								<label class="col-md-1 hidden-sm hidden-xs text-right">关键字</label>
								<input class="col-md-2 col-xs-12" id="searchName" name="s_keyword" type="text" placeholder="标题、正文" value="{$search['keyword']}">
								<label class="col-md-1 hidden-sm hidden-xs text-right">标签</label>
								<input class="col-md-2 col-xs-12" id="searchName" name="s_tag" type="text" placeholder="tag" value="{$search['tag']}">
								<input type="submit" value="查询" class="btn btn-primary col-md-2 col-xs-12">
								<div class="clearfix">
							</form> 
							<table width="100%" border="0" cellspacing="0" class="table table-hover">
								<thead>
									<tr class="tableTitle">
										<th class="col-md-1 hidden-sm hidden-xs">ID</th>
										<th class="col-xs-6">标题</th>
										<th class="col-md-1 col-xs-3">类型</th>
										<th class="col-md-3 hidden-sm hidden-xs">作者</th>
										<th class="col-xs-4">标签</th>
										<th class="col-md-3 hidden-sm hidden-xs">添加时间</th>
										<th class="col-md-1 col-xs-3">状态</th>
										<th class="col-md-2">操作</th>
									</tr>
								</thead>
								<tbody>
									<?php if($list != null) {
										foreach($list as $Rs) { ?>
									<tr id="vip-<?php echo $Rs['id']; ?>">
										<td class="col-md-1 hidden-sm hidden-xs vip-id">{$Rs['id']}</td>

										<td class="col-xs-6 text-ellipsis">
											<strong>{$Rs['title']}</strong>
										</td>

										<td class="col-sm-1 col-xs-3">
											<?php if($Rs['type']==1){
												echo "图文";
											}else{
												echo "视频";
											}?>
										</td>
										
										<td class="col-md-3 hidden-sm hidden-xs">{$Rs['author_name']}
										</td>

										<!-- Email -->
										<td class="col-xs-4">
											<strong>{$Rs['tag']}</strong>
										</td>

										<td class="col-md-3 hidden-sm hidden-xs">{$Rs['add_time']}
										</td>

										<td class="col-sm-1 col-xs-3">
											<?php if($Rs['status']=='1'){?>
											<span class="label label-success">正常</span>
											<?php }else{?>
											<span class="label label-important">禁用</span>
											<?php }?> 
										</td>


										<td class="col-md-2">
											<div class="btn-group">
												<a class="btn btn-xs dropdown-toggle" data-toggle="dropdown" href="#">操作<span class="caret"></span>
												</a>
												<ul class="dropdown-menu pull-right">
													<li>
														<a href="__URL__/detail/id/{$Rs['id']}"><i class="glyphicon glyphicon-edit"></i>编辑该内容</a>
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