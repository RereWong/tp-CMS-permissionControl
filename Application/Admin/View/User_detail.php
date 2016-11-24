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
							<a href="<?php echo U("User/index"); ?>">用户管理</a>
						</li>
						<li>编辑用户信息</li>
					</ul>
					<hr>
					
				</div>
                <a href="__URL__/index" class="btn btn-primary"><i class="glyphicon glyphicon-arrow-left"></i> 返回列表</a>

				<div class="row sortable ui-sortable">
					<div class="box col-xs-12">

						<div class="box-content">
							<form method="post" action="__URL__/update" class="form-horizontal" enctype="multipart/form-data">
								<div class="row form-item">
									<label class="col-lg-1 col-sm-2 text-right col-xs-12" for="new_title">昵称</label>
									<div class="col-lg-11 col-sm-10 col-xs-12">
										<input type="text" name="nickname" id="new_title" class="col-lg-11 col-sm-10 col-xs-12" placeholder="标题" value="{$info['nickname']}" required>
									</div>
								</div>
								
                                <div class="row form-item">
                                	<div class="col-lg-1 col-sm-2 text-right col-xs-12"><label for="phone">手机</label></div>
									<div class="col-lg-11 col-sm-10 col-xs-12">
                                    <input class="col-lg-11 col-sm-10 col-xs-12" type="text" name="phone" id="phone" placeholder="手机" value="{$info['phone']}">
                                    </div>
								</div>

								<div class="row form-item">
                                	<div class="col-lg-1 col-sm-2 text-right col-xs-12"><label for="mail">邮箱</label></div>
									<div class="col-lg-11 col-sm-10 col-xs-12">
                                    <input class="col-lg-11 col-sm-10 col-xs-12" type="text" name="mail" id="mail" placeholder="邮箱" value="{$info['mail']}">
                                    </div>
								</div>

								<div class="row form-item">
									<label class="col-lg-1 col-sm-2 text-right col-xs-12">性别</label>
									<div class="col-lg-11 col-sm-10 col-xs-12">
                                    <select id="sex" name="sex" class="col-sm-2 col-xs-12">
                                    	<option value="0" <?php if(!$info['sex'] || $info['sex']==0) echo "selected";?>>未知</option>
                                        <option value="1" <?php if($info['sex']==1) echo "selected";?>>男</option>
										<option value="2" <?php if($info['sex']==2) echo "selected";?>>女</option>
                                    </select>
									</div>
								</div>

								<div class="row form-item">
                                	<div class="col-lg-1 col-sm-2 text-right col-xs-12"><label for="birthday">生日</label></div>
									<div class="col-lg-11 col-sm-10 col-xs-12">
                                    <input class="col-lg-11 col-sm-10 col-xs-12" type="text" name="birthday" id="birthday" placeholder="生日" value="{$info['birthday']}">
                                    </div>
								</div>

								<div class="row form-item">
                                	<div class="col-lg-1 col-sm-2 text-right col-xs-12"><label for="brief">简介</label></div>
									<div class="col-lg-11 col-sm-10 col-xs-12">
                                    <input class="col-lg-11 col-sm-10 col-xs-12" type="text" name="brief" id="brief" placeholder="简介" value="{$info['brief']}">
                                    </div>
								</div>

								<div class="form-actions">
									<input type="submit" value="完成提交" class="btn btn-primary btn-large col-lg-3 col-lg-offset-1 col-sm-3 col-sm-offset-2 col-xs-12" id="mybutton">
									<input type="hidden" name="id" id="id" value="{$info['id']}">
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