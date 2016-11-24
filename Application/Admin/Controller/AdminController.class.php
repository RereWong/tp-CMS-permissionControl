<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Model;
use Exception;
header('Access-Control-Allow-Origin: *');
class AdminController extends PermissionController {
	public $admin_model;
	public $role_model;
	public function _initialize(){
		parent::_initialize();
		$this->admin_model = D('admin');
		$this->role_model = D('role');
	}

	public function loginoutAction(){
		unset($_SESSION['admin']);
		redirect(U('admin/login'));
	}

	//用户登录
	public function loginAction()
	{
		if(IS_POST){
			$input = I('post.input');
			$name = $input['name'];
			$pwd = $input['password'];
			if($name == '' || $pwd == ''){
				$this->error('请输入用户名和密码！');
			}
			$pwd = md5($pwd);
			$info = M('admin_user')->where("name='{$name}' and password='{$pwd}' and status=1")->find();
			
			if($info){
				$_SESSION['admin']['uid'] = $info['id'];
				$_SESSION['admin']['password'] = $info['password'];
				if($_POST['reurl'] == ''){
					$_POST['reurl'] = __MODULE__;
				}else{
					$_POST['reurl'] = urldecode($_POST['reurl']);
				}
				redirect($_POST['reurl']);
			}else{
				$this->error('用户名或密码错误！');
			}
		}
		$this->assign("title", "街力-登录管理中心");
		$this->display();
	}

	//管理员列表
	public function listAction()
	{
		$this->permission('管理员列表','管理员管理');

		$search['id'] = I('get.s_id');
		$search['name'] = I('get.s_name');

		$count = $this->admin_model->countBy($search);

       	$queryString = '';
        if ($_SERVER["QUERY_STRING"] != '') {
            $queryString = '?' . $_SERVER["QUERY_STRING"];
        }

        $listRows = I('get.num') ? I('get.num') : 10;//每页显示的信息条数
        $page = new \Think\Page( $count,$listRows);
        $cur_page = $page->getNowPage();
        $show = $page->show();

		$list = $this->admin_model->getList($search,$cur_page,$listRows);
		if ($list) {
			foreach ($list as $key => $value) {
				if ($value['role']!='') {
					$role = $this->role_model->get($value['role']);
					$list[$key]['role_name'] = $role['name'];
				}
			}
		}

		$this->assign('list',$list);
		$this->assign('search',$search);
		$this->assign('nowpage',$cur_page);
		$this->assign('title','管理员列表');
		$this->display();
	}

	public function detailAction()
	{
		$this->permission('管理员详情','管理员管理');
		$id = I('get.id');
		if ($id!='') {
			$info = $this->admin_model->get($id);
			if ($info['role']!='') {
				$info['permission_arr'] = explode(',', $info['permission']);
				$role = $this->role_model->get($info['role']);
				if ($role!='') {
					$info['role_name'] = $role['name'];
					$info['role_permission'] = $role['permission'];
				}
			}
			
			$this->assign('info',$info);
		}
		//角色列表
		
		$role_list = $this->role_model->getAll();
		$permission_list = $this->permission_model->getTree();

		$this->assign('title','编辑管理员');
		$this->assign('permission_list',$permission_list);
		$this->assign('role_list',$role_list);
		$this->display();
	}

	public function updateAction()
	{
		$this->permission('新建/修改管理员','管理员管理');

		$id = I('post.id');
		$name = I('post.name');
		$permission = I('post.permission');
		$permission = str_replace('，', ',', $permission);
		$super_admin = I('post.super_admin');
		$role = I('post.role');

		//上传头像图片并处理
		if($_FILES['img']){
			$img = A('Upload','Event')->uploadimg($_FILES['img']);
		}

		$data = array(
			'name' => $name,
			'permission' => $permission,
			'super_admin' => $super_admin,
			'role' => $role,
		);

		$condition['name'] = $name;
		$checkName = $this->admin_model->getBy($condition);
		if ($checkName && $checkName['id']!=$id) {
			$this->error('该账户名已存在');
			exit();
		}

		if ($id=='') {
			$data['add_time'] = time();
			$res = $this->admin_model->create($data);
			if ($res) {

				//转存头像图片
				if($_FILES['img'] && $img['state']==1){ 
					$savepath = 'adminhead/'.$res.'/';
					A('Image','Event')->thumbimg(100,100,$savepath,$img['data']['savename']);
				}

				$head_img = "thumb_".$img['data']['savename'];	
				$data2 = array('head_img'=>$head_img);

				$this->admin_model->update($res,$data2);
				$this->success('新建管理员成功',U('Admin/detail/id/'.$res));
			}else{
				$this->error('新建管理员失败');
			}

		}else{
			//转存头像图片
			if($_FILES['img'] && $img['state']==1){ 
				$savepath = 'adminhead/'.$id.'/';
				A('Image','Event')->thumbimg(100,100,$savepath,$img['data']['savename']);
				$head_img = "thumb_".$img['data']['savename'];	
				$data['head_img'] = $head_img;
			}
			$this->admin_model->update($id,$data);

			$this->success('修改管理员信息成功');
		}

	}

	//修改管理员状态
	public function setStatusAction()
	{
		$this->permission('修改管理员状态','管理员管理');

		$del = I('get.del');
		$renew = I('get.renew');
		$p = I('get.p');
		$p = ($p)? $p : 1;

		if ($del != '') {
			$id = $del;
			$status = -1;
		}elseif ($renew != '') {
			$id = $renew;
			$status = 1;
		}else{
			$this->error('参数不完整');
		}

		$data = array(
			'status' => $status,
		);
		$res = $this->admin_model->update($id,$data);

		redirect(U('Admin/Admin/list/p/'.$p));
	}

	//设置初始密码
	public function setDefaultPwdAction()
	{
		$this->permission('初始化密码','管理员管理');

		$id = I('get.id');
		$p = I('get.p');
		$p = ($p)? $p : 1;

		if ($id == '') {
			$this->error('参数不完整');
		}

		$data = array(
			'pwd' => md5('123456'),
		);
		$res = $this->admin_model->update($id,$data);

		$this->success("该管理员登录密码已被重置为默认密码！",U('Admin/Admin/list/p/'.$p));
	}

	//个人中心
	public function selfAction()
	{
		$id = $this->adminInfo['id'];

		//修改个人信息
		if ($_POST!=array()) {
			$name = I('post.name');
			$permission = I('post.permission');

			$condition['name'] = $name;
			$checkName = $this->admin_model->getBy($condition);
			if ($checkName && $checkName['id']!=$id) {
				$this->error('该账户名已存在');
				exit();
			}

			$data = array(
				'name' => $name,
				'permission' => $permission,
			);

			//上传头像图片并处理
			if($_FILES['img']){
				$img = A('Upload','Event')->uploadimg($_FILES['img']);
				if($img['state']==1){ 
					$savepath = 'adminhead/'.$id.'/';
					A('Image','Event')->thumbimg(100,100,$savepath,$img['data']['savename']);
					$head_img = "thumb_".$img['data']['savename'];	
					$data['head_img'] = $head_img;
				}
			}
			
			$res = $this->admin_model->update($id,$data);
			$this->success('修改信息成功',U('Admin/self'));
			exit();
		}

		//个人信息
		$info = $this->admin_model->get($id);
		unset($info['password']);

		if ($info['permission']!='') {
			$info['permission_list'] = $this->permission_model->getPermissionArrByIds($info['permission']);
		}

		$role = array();
		if ($info['role']!='') {
			$role_model = D('role');
			$role = $role_model->get($info['role']);
			if ($role['permission'] != '') {
				$role['permission_list'] = $this->permission_model->getPermissionArrByIds($role['permission']);
			}
		}


		$this->assign('info',$info);
		$this->assign('role',$role);
		$this->assign('role_list',$role_list);
		$this->display();
	}

	//修改密码
	public function editPwdAction()
	{
		$old_pwd = I('post.old_pwd');
		$new_pwd = I('post.new_pwd');
		$new_pwd2 = I('post.new_pwd2');

		if ($old_pwd!='' && $new_pwd!='') {
			if ($new_pwd != $new_pwd2) {
				$this->error('两次输入新密码不相同');
			}

			$id = $this->adminInfo['id'];
			$info = $this->admin_model->get($id);
	
			if (md5($old_pwd)!=$info['password']) {
				$this->error('原密码不正确');
			}

			$data['password'] = md5($new_pwd);
			$res = $this->admin_model->update($id,$data);

			$this->success('密码修改成功',U('Index/index'));

		}else{
			$this->display();
		}

	}




















	//上传图片通用接口
	public function uploadImageAction()
	{
		$json = array();
		$uid = I("post.uid");
		$key = I("post.key");
		$file = $_FILES['image'];

		if ($file=='' || $uid=='' || $key==''){
			$json['status'] = -1;//参数不完整
			echo json_encode($json);
			exit();
		}
		if(!$this->_GETMYACCOUNT($uid,$key)){
			$json['status'] = -2; //uid 或 key 不正确
			echo json_encode($json);
			exit();
		}

		$savepath = "./public/upload/temp/";
		del_temp($savepath);

		if($file['size']>10){
			$savename = md5(microtime());
			$image = $this->upload_image($file,$savepath,$savename);
			if ($image['isOk']=='1') {			
				$json['status'] = 1;
				$json['data']= $image['data']['file_name'];
				echo json_encode($json);
				exit;
			}else{
				$json['status'] = 0;//图片上传失败
				//$json['data'] = $image['data'];
				echo json_encode($json);
				exit;
			}
		}else{
			$json['status'] = -3;//图片太小
			echo json_encode($json);
			exit();
		}
	}

	//通用上传图片方法
	public function upload_image($file,$savepath,$savename)
	{
		$size = $file['size'];
		$imgsize = getimagesize($file['tmp_name']);
		$width = (int)$imgsize[0];
		$height = (int)$imgsize[1];
		
		create_folders($savepath);//创建文件夹
		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize = 3145728 ;// 设置附件上传大小
		$upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->rootPath = $savepath; // 设置附件上传根目录
		$upload->autoSub = false;
		$upload->saveName = $savename; // 设置保存文件名
		// 上传单个文件 
		$info = $upload->uploadOne($file);
		if(!$info) {// 上传错误提示错误信息
			return array('isOk'=>0,'data'=>$upload->getError());
		}else{// 上传成功 获取上传文件信息
			$image = new \Think\Image();
			$image->open($savepath.$info['savename']);
			//生成最大640*640的等比例缩略图
			$image->thumb(640, 640)->save($savepath.'thumb_'.$info['savename']);
			//生成160*160的1:1裁切图
			$image->thumb(160, 160,\Think\Image::IMAGE_THUMB_CENTER)->save($savepath.'crop_'.$info['savename']);
			
			unlink($savepath.$info['savename']);

			$data = array();
			$data['file_name'] = $info['savename'];
			$data['savepath'] = __APP__.$savepath;
			$data['ext'] = $info['ext'];
			$data['width'] = $width;
			$data['height'] = $height;
			$data['size'] = $info['size'];
			$data['type'] = $info['type'];
			$data['full_name'] = $savepath.'thumb_'.$info['savename'];

			return array('isOk'=>1,'data'=>$data);
		}
	}

	public function testAction()
	{
		$data = array(
			'id' => 'fuck you!'
		);
		$res = $this->admin_model->update(1,$data);
		var_dump($res);
		var_dump(M()->getLastSql());
	}
}