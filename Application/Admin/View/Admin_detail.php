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
							<a href="<?php echo U("Admin/list",array('lang'=>$lang)); ?>">管理员管理</a>
						</li>
						<li>管理员详情</li>
					</ul>
					<hr>
				</div>
                <a href="__URL__/list" class="btn btn-primary"><i class="glyphicon glyphicon-arrow-left"></i> 返回列表</a>

				<div class="row sortable ui-sortable">
					<div class="box col-xs-12">

						<div class="box-content">
							<form method="post" action="__URL__/update" class="form-horizontal" enctype="multipart/form-data">
								<div class="row form-item">
									<label class="col-lg-1 col-sm-2 text-right col-xs-12" for="new_title">账户名</label>
									<div class="col-lg-11 col-sm-10 col-xs-12">
										<input type="text" name="name" id="new_title" class="col-lg-11 col-sm-10 col-xs-12" placeholder="账户名" value="{$info['name']}" required>
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
									<label class="col-lg-1 col-sm-2 text-right col-xs-12">超管</label>
									<div class="col-lg-11 col-sm-10 col-xs-12">
                                    <select id="super_admin" name="super_admin" class="col-sm-2 col-xs-12">
                                        <option value="1" <?php if($info['super_admin']==1) echo "selected";?>>是</option>
										<option value="0" <?php if($info['super_admin']!=1) echo "selected";?>>否</option>
                                    </select>
									</div>
								</div>

								<div class="row form-item">
                                	<div class="col-lg-1 col-sm-2 text-right col-xs-12"><label for="tags">角色</label></div>
									<div class="col-lg-11 col-sm-10 col-xs-12 ">
                                    <select id="role" name="role" class="col-sm-2 col-xs-12">
                                    	<?php if($role_list){
                                    		foreach($role_list as $row){ ?>
											<option value="<?php echo $row['id']?>" <?php if($info['role']==$row['id']) echo "selected";?>>{$row['name']}</option>
                                    	<?php } } ?>
                                    </select>
									</div>
								</div>

								<div class="row form-item">
                                	<div class="col-lg-1 col-sm-2 text-right col-xs-12"><label for="tags">私有权限</label></div>
                                   	<div style="display:inline-block;padding-left:3%;">
									<div>
									<div class="check-list">
									<?php if($permission_list) {
										foreach($permission_list as $row){ ?>
										<div class="check-total">
    	      								<label><input type="checkbox" name="permission-row" value="{$row['id']}" <?php if(in_array($row['id'],$info['permission_arr'])) echo "checked"; ?> />{$row['title']}</label>
	      								</div>
										<?php if($row['children']){ ?>
											<div class="check-item">
											<span>&nbsp;&nbsp;</span>					
											<?php foreach($row['children'] as $child){ ?>
												<label><input type="checkbox" name="permission-row" value="{$child['id']}" <?php if(in_array($child['id'],$info['permission_arr'])) echo "checked"; ?> />{$child['title']}</label>
											<?php } ?>
											</div>
									<?php  } } }?>
									</div>
                                    </div>
								</div>
								<div class="form-actions">
									<input type="submit" value="完成提交" class="btn btn-primary btn-large col-lg-3 col-lg-offset-1 col-sm-3 col-sm-offset-2 col-xs-12" id="mybutton">
									<input type="hidden" name="id" id="id" value="{$info['id']}">
									<input type="hidden" name="permission" id="permission" value="{$info['permission']}">
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

<script>
	$(document).on('change', '.check-total input', function () {
    $(this).parents('.check-total').next().find('input').prop('checked', $(this).prop('checked'))
      })
	$(document).on('change', '.check-item input', function () {	      
	  var checked = $(this).prop('checked')
	  var checkTotal = $(this).parents('.check-item').prev().find('input')
	    var allCheckbox = Array.prototype.slice.call($(this).parents('.check-item').find('input'));
	    var isAllNotCheck = allCheckbox.every(function (elem, index, arr) {
        	return $(elem).prop('checked')==false;
      	});
      	if (isAllNotCheck) {
      	  checkTotal.prop('checked', false)
      	}else {
	    	checkTotal.prop('checked', true)
	  	}
	})

	$(document).on('click', '#mybutton', function () {
		var ids = '';
		var temp=document.getElementsByName('permission-row');
    	    for(var i=0;i<temp.length;i++){
            	if(temp[i].checked==true){
            	console.log(ids);
            	ids += ',' + temp[i].value
            	console.log(ids);
        	}
        	var permissions = ids.substring(1)
        	document.getElementById("permission").value= permissions
   		}
	})
</script>
</body>
</html>