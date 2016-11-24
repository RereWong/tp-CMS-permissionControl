<!DOCTYPE html>
<html lang="zh-CN" ng-app="jetli.admin.useredit">
<head>
	<meta charset="utf-8">
    <include file="./Application/Admin/View/headinclude.php" />
    <link rel="stylesheet" href="__PUBLIC__/admin/css/ckeditor_customize.css">

</head>
<body>
<include file="./Application/Admin/View/header.php" />
<include file="./Application/Admin/View/leftmenu.php" />
<include file="./Application/Admin/View/rightmenu.php" />

	<!-- <div id="waiting">正在为您搜集内容中的远程图片，请稍候...</div> -->
	
	<div class="container main-frame">
		<div class="row"> 
			<div id="content" class="col-xs-12"> 

				<!-- Bread Crumb -->
				<div>
					<hr>
					<ul class="breadcrumb">
						<li>
							<a href="<?php echo U("Index/index"); ?>">首页</a>
						</li>
						<li>
							<a href="<?php echo U("Admin/self"); ?>">修改个人信息</a>
						</li>
					</ul>
					<hr>
				</div>

				<div class="row sortable ui-sortable">
					<div class="box col-xs-12">

						<div class="box-content">
							<form method="post" action="" class="form-horizontal" enctype="multipart/form-data">
								<div class="row form-item">
									<label class="col-lg-1 col-sm-2 text-right col-xs-12" for="new_title">名字</label>
									<div class="col-lg-11 col-sm-10 col-xs-12">
										<input type="text" name="name" id="new_title" class="col-lg-11 col-sm-10 col-xs-12" placeholder="名字" value="{$info['name']}" required>
									</div>
								</div>

								
								<div class="row form-item">
                                	<div class="col-lg-1 col-sm-2 text-right col-xs-12"><label for="img">头像</label></div>
                                    <div class="col-lg-11 col-sm-10 col-xs-12">
                                    	<p>
                                    	  <?php if($info['head_img']!=""){ ?>
                                    	  <img src="__PUBLIC__/upload/adminhead/{$info['id']}/{$info['head_img']}" width="100">
                                    	  <?php } ?>
                                   	  </p>
                                    	<p>
                                    	  <input type="file" name="img" id="img">
                                  	  </p>
                                    	<!-- <p class="help-block col-lg-11 col-sm-10 col-xs-12">建议图片大小不小于450*365像素。</p> -->
                                    </div>
								</div>

								<div class="row form-item">
                                	<div class="col-lg-1 col-sm-2 text-right col-xs-12"><label for="tags">超管</label></div>
									<div class="col-lg-11 col-sm-10 col-xs-12 ">
                                    <input class="col-lg-11 col-sm-10 col-xs-12 hide-border" type="text" name="super_admin" id="super_admin" placeholder="超管" value="<?php if($info['super_admin']==1) {echo '是';}else{echo '否';}?>" readonly>
                                    </div>
								</div>

								<div class="row form-item">
                                	<div class="col-lg-1 col-sm-2 text-right col-xs-12"><label for="tags">角色</label></div>
									<div class="col-lg-11 col-sm-10 col-xs-12 ">
                                    <input class="col-lg-11 col-sm-10 col-xs-12 hide-border" type="text" name="role" id="role" placeholder="角色" value="{$role['name']}" readonly>
                                    </div>
								</div>

								<div class="row form-item">
                                	<div class="col-lg-1 col-sm-2 text-right col-xs-12"><label for="tags">角色权限</label></div>
									<div class="col-lg-11 col-sm-10 col-xs-12 ">
                                   		<?php if($role['permission_list']){ 
											foreach($role['permission_list'] as $row){ ?>
												<div class="permission-module">
    	      										<label>{$row['title']}:</label>
    	      									</div>
												<?php if($row['children']){ ?>
													<div class="permission-module">
													<span>&nbsp;&nbsp;</span>
													<?php foreach($row['children'] as $child){ ?>
    	      												<label>{$child['title']}</label>
    	      												<span>&nbsp;</span>
													<?php } ?>
													</div>
												<?php } 
											}
                                   		} ?>
                                    </div>
								</div>

								<div class="row form-item">
                                	<div class="col-lg-1 col-sm-2 text-right col-xs-12"><label for="tags">个人权限</label></div>
									<div class="col-lg-11 col-sm-10 col-xs-12 ">
                                   		<?php if($info['permission_list']){ 
											foreach($info['permission_list'] as $row){ ?>
												<div class="permission-module">
    	      										<label>{$row['title']}:</label>
    	      									</div>
												<?php if($row['children']){ ?>
													<div class="permission-module">
													<span>&nbsp;&nbsp;</span>
													<?php foreach($row['children'] as $child){ ?>
    	      												<label>{$child['title']}</label>
    	      												<span>&nbsp;</span>
													<?php } ?>
													</div>
												<?php } 
											}
                                   		} ?>
                                    </div>
								</div>

								<div class="form-actions">
									<input type="submit" value="完成提交" class="btn btn-primary btn-large col-lg-3 col-lg-offset-1 col-sm-3 col-sm-offset-2 col-xs-12" id="mybutton">
									<div class="clearfix"></div>
								</div>
							</form>
                            </div>
						</div>
					</div> 
				</div>
			</div>
		</div>
	</div>
<include file="./Application/Admin/View/footer.php" />
<include file="./Application/Admin/View/jsinclude.php" />
<script src="__PUBLIC__/admin/ckeditor/ckeditor.js"></script>
<script type="text/javascript">

function onFocus() {
	//alert('获得了焦点');
}
function onBlur() {
	var editor = CKEDITOR.instances.noteContent;
	//alert('失去了焦点');
}

$(document).ready(function(e) {
	CKEDITOR.replace( 'mcontent' , {
		on:{
			focus:onFocus,
			blur:onBlur
		},
		//uiColor:'#F9F9F9',
		filebrowserImageUploadUrl  : '<?php echo U("Ajax/upload_img"); ?>'
		//filebrowserImageUploadUrl  : '__URL__/upload_img'
	});
});
</script>
</body>
</html>