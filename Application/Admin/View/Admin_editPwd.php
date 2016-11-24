<!DOCTYPE html>
<html lang="zh-CN" ng-app="xShowroom.admin.useredit">
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
						<li>修改密码</li>
					</ul>
					<hr>
				</div>

                
				<div class="row sortable ui-sortable">
					<div class="box col-xs-12">

						<div class="box-header" data-original-title="">
							<h2><i class="glyphicon glyphicon-edit"></i><span class="break"></span>修改密码</h2>
						</div>

						<div class="box-content">
							<div class="box-content">
							<form method="post" action="" class="form-horizontal" enctype="multipart/form-data">
								<div class="row form-item">
									<label class="col-lg-1 col-sm-2 text-right col-xs-12" for="old_pwd">原密码</label>
									<input type="password" name="old_pwd" id="old_pwd" class="col-lg-11 col-sm-10 col-xs-12" placeholder="原密码" value="" required>
								</div>
                                <div class="row form-item">
									<label class="col-lg-1 col-sm-2 text-right col-xs-12" for="new_pwd">新密码</label>
									<input type="password" name="new_pwd" id="new_pwd" class="col-lg-11 col-sm-10 col-xs-12" placeholder="新密码" value="" required>
								</div>
                                <div class="row form-item">
									<label class="col-lg-1 col-sm-2 text-right col-xs-12" for="new_pwd2">确认密码</label>
									<input type="password" name="new_pwd2" id="new_pwd2" class="col-lg-11 col-sm-10 col-xs-12" placeholder="确认密码" value="" required>
								</div>

								<div class="form-actions">
									<input type="submit" value="确认修改" class="btn btn-primary btn-large col-lg-3 col-lg-offset-1 col-sm-3 col-sm-offset-2 col-xs-12" id="mybutton">
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
	</div>
<include file="./Application/Admin/View/footer.php" />
<include file="./Application/Admin/View/jsinclude.php" />
</body>
</html>