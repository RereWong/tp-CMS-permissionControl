<?php
namespace Admin\Controller;
use Think\Controller;
class PermissionController extends Controller {
	protected $adminInfo = array();
	public $permission_model;
	public function _initialize(){
		$this->permission_model = D('permission');
		if (ACTION_NAME != 'login') {			
			$this->adminInfo = $this->_MUSTLOGIN();//必须登录
			$adminInfo = $this->adminInfo;
			unset($adminInfo['password']);
			$this->assign('adminInfo',$adminInfo);
		}
	}

	public function _MUSTLOGIN(){//必须登录
		if($_SESSION['admin']['uid'] && $_SESSION['admin']['password']){//强制登录
			$where = array();
			$where['id'] = $_SESSION['admin']['uid'];
			$where['password'] = $_SESSION['admin']['password'];
			$adminInfo = M('admin_user')->where($where)->find();
			if($adminInfo){
				return $adminInfo;
			}else{
				redirect(U('admin/login'));//.'?reurl='.urlencode(GetCurUrl()));
			}
		}else{
			redirect(U('admin/login'));//.'?reurl='.urlencode(GetCurUrl()));
		}
	}

	public function permission($title,$p_title='')
	{
		$p_tag = CONTROLLER_NAME;
		$tag = $p_tag.'-'.ACTION_NAME;

		$res = $this->checkPermission($tag,$title,$p_tag,$p_title);
		if (!$res) {
			$this->error('无操作权限');
		}
	}

	/**
	* 1.判断该tag权限是否存在，如不存在则新建
	* 2.判断用户是否拥有权限
	*/
	public function checkPermission($tag,$title,$p_tag='',$p_title='')
	{
		$permission = M('permission')->where("tag='{$tag}' and status=1")->find();
		if(!$permission){ //不存在此条权限，新建
			if ($p_tag!='') {	//父标签存在
				$p_permission = M('permission')->where("tag='{$p_tag}' and status=1")->find();
				if (!$p_permission) {
					$p_permission_id = $this->permission_model->create($p_tag,$p_title);
					$p_id = $p_permission_id;
				}else{
					$p_id = $p_permission['id'];
				}
			}
			$this->permission_model->create($tag,$title,$p_id);
		}
		//验证用户是否拥有该权限
		if ($this->adminInfo['super_admin']=='1') { //用户为超级管理员
			return ture;
		}
		$permission_id = $permission['id'];
		if (in_array($permission_id, $this->adminInfo['permission'])) { //用户个人权限中拥有该权限
			return ture;
		}else{
			if ($this->adminInfo['role']) {
				$role = M('admin_role')->where("id='{$this->adminInfo['role']}' and status=1")->find();
				if ($role) {
					if (in_array($permission_id, $rloe['permission'])) {
						return ture;
					}
				}
			}
			return false;
		}
	}

	//获取全部权限
	public function getPermissionAction()
	{
		$list = $this->permission_model->getTree();

		retFormat(1,'',$list);
	}
}