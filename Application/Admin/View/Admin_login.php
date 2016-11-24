<!DOCTYPE html>
<html lang="cn">
<head>
<include file="./Application/Admin/View/headinclude.php" />
<style type="text/css">
body {
	padding-top: 40px;
	padding-bottom: 40px;
	background-color: #eee;
}
.form-signin {
	max-width: 330px;
	padding: 15px;
	margin: 0 auto;
}
.form-signin .form-signin-heading, .form-signin .checkbox {
	margin-bottom: 10px;
}
.form-signin .checkbox {
	font-weight: normal;
}
.form-signin .form-control {
	position: relative;
	height: auto;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
	padding: 10px;
	font-size: 16px;
}
.form-signin .form-control:focus {
	z-index: 2;
}
.form-signin input[type="text"] {
	margin-bottom: -1px;
	border-bottom-right-radius: 0;
	border-bottom-left-radius: 0;
}
.form-signin input[type="password"] {
	margin-bottom: 10px;
	border-top-left-radius: 0;
	border-top-right-radius: 0;
}
</style>
</head>

<body>
<div class="container">
  <form method="post" action="" onSubmit="return isSubmit();" class="form-signin">
    <h2 class="form-signin-heading">登录管理中心</h2>
    <input type="text" class="form-control" id="name" name="input[name]" placeholder="管理名" required autofocus>
    <input type="password" class="form-control" id="password" name="input[password]" placeholder="密码" required>
    <button class="btn btn-lg btn-primary btn-block" type="submit">登录</button>
    <input type="hidden" name="reurl" id="reurl" value="{$_GET['reurl']}">
  </form>
</div>
<script type="text/javascript">
function isSubmit(){
	if($('#name').val()==''){
		alert('请输入管理名！');
		$('#name').focus();
		return false;
	}
	if($('#edit').val()==''){
		if($('#password').val()==''){
			alert('请输入管理密码！');
			$('#password').focus();
			return false;
		}
	}
	return true;
}
</script>
</body>
</html>