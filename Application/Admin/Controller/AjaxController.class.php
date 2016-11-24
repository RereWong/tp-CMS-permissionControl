<?php
namespace Admin\Controller;
use Think\Controller;
class AjaxController extends Controller {
	
	public function upload_imgAction()
	{
		$img = A('Upload','Event')->uploadimg($_FILES['upload']);

		if(!$img){
			echo '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction(1, "", "'.$img["msg"].'");</script>';
		}else{
			header('Content-Type: text/html');
			echo '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction(1, "'.ReHome().'/public/upload/temp/'.$img['data']['savename'].'", "");</script>';
		}
	}
}