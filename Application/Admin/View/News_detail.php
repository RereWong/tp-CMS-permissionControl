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
							<a href="<?php echo U("News/manage",array('lang'=>$lang)); ?>">内容管理</a>
						</li>
						<li>编辑内容</li>
					</ul>
					<hr>
					
				</div>
                <a href="__URL__/index" class="btn btn-primary"><i class="glyphicon glyphicon-arrow-left"></i> 返回列表</a>

				<div class="row sortable ui-sortable">
					<div class="box col-xs-12">

						<div class="box-content">
							<form method="post" action="__URL__/update" class="form-horizontal" enctype="multipart/form-data">
								<div class="row form-item">
									<label class="col-lg-1 col-sm-2 text-right col-xs-12" for="new_title">标题</label>
									<div class="col-lg-11 col-sm-10 col-xs-12">
										<input type="text" name="title" id="new_title" class="col-lg-11 col-sm-10 col-xs-12" placeholder="标题" value="{$info['title']}" required>
									</div>
								</div>
								
								<div class="row form-item">
									<label class="col-lg-1 col-sm-2 text-right col-xs-12">类型</label>
									<div class="col-lg-11 col-sm-10 col-xs-12">
                                    <select id="type" name="type" class="col-sm-2 col-xs-12 select-type">
                                        <option value="1" id='select-img'>图文</option>
										<option value="2" id='select-video' <?php if($info['type']==2) echo 'selected'; ?>>视频</option>
                                    </select>
									</div>
								</div>

								
								<div class="row form-item" id='obj-img'>
                                	<div class="col-lg-1 col-sm-2 text-right col-xs-12"><label for="img">封面图</label></div>
                                    <div class="col-lg-11 col-sm-10 col-xs-12">
                                    	<p>
                                    	  <?php if($info['subject_url']!=""){ ?>
                                    	  <img src="__PUBLIC__/upload/news/{$info['id']}/{$info['subject_url']}" width="300">
                                    	  <?php } ?>
                                   	  </p>
                                    	<p>
                                    	  <input type="file" name="img" id="img">
                                  	  </p>
                                    	<p class="help-block col-lg-11 col-sm-10 col-xs-12">建议图片大小不小于450*365像素。</p>
                                    </div>
								</div>

								<div class="row form-item" id='obj-video'>
                                	<div class="col-lg-1 col-sm-2 text-right col-xs-12"><label for="url">视频地址</label></div>
									<div class="col-lg-11 col-sm-10 col-xs-12">
                                    <input class="col-xs-12" type="text" name="video_url" id="url" placeholder="视频地址" value="{$info['subject_url']}">
                                    </div>
								</div>

                                <div class="row form-item">
                                	<div class="col-lg-1 col-sm-2 text-right col-xs-12"><label for="tags">标签</label></div>
									<div class="col-lg-11 col-sm-10 col-xs-12">
                                    <input class="col-xs-12" type="text" name="tag" id="tag" placeholder="标签" value="{$info['tag']}">
                                    <div>以,隔开</div>
                                    </div>
								</div>

								<!-- <div class="row form-item">
									<label class="col-lg-1 col-sm-2 text-right col-xs-12" for="introduction">简介</label>
									<div class="col-lg-11 col-sm-10 col-xs-12">
										<textarea name="introduction" id="introduction" class="col-xs-12">{$info['introduction']}</textarea>
									</div>
								</div> -->

								<div class="row form-item">
                                	<div class="col-lg-1 col-sm-2 text-right col-xs-12"><label for="mcontent">正文</label></div>
									<div class="col-lg-11 col-sm-10 col-xs-12"><textarea name="content" id="mcontent">{$info['content']}</textarea></div>
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

	var selected = document.getElementById('select-img').selected
	if (selected) {
		document.getElementById("obj-video").style.display="none";
	}else{
		document.getElementById("obj-img").style.display="none";
	}
});

$(document).on('change','.select-type', function(){
	var selected = document.getElementById('select-img').selected
	if (selected) {
		document.getElementById("obj-video").style.display="none";
		document.getElementById("obj-img").style.display="";
	}else{
		document.getElementById("obj-img").style.display="none";
		document.getElementById("obj-video").style.display="";
	}
});

</script>
</body>
</html>