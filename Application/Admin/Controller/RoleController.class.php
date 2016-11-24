<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Model;
class RoleController extends PermissionController {
	public $role_model;
	public function _initialize(){
		parent::_initialize();
		$this->role_model = D('role');
	}

	public function listAction()
	{
		$this->permission('角色列表','角色管理');

		$count = $this->role_model->countBy();

       	$queryString = '';
        if ($_SERVER["QUERY_STRING"] != '') {
            $queryString = '?' . $_SERVER["QUERY_STRING"];
        }

        $listRows = I('get.num') ? I('get.num') : 10;//每页显示的信息条数
        $page = new \Think\Page($count,$listRows);
        $cur_page = $page->getNowPage($url);
        $show = $page->show();

		$list = $this->role_model->getList($cur_page,$listRows);

		$this->assign('list',$list);
		$this->assign('nowpage',$cur_page);
		$this->assign('title', '角色列表');
        $this->assign('page', $show);
		$this->display();
	}

	public function detailAction()
	{
		$this->permission('角色详情','角色管理');
		$id = I('get.id');
		if ($id!='') {
			$info = $this->role_model->get($id);
			$info['permission_arr'] = explode(',', $info['permission']);
			$this->assign('info',$info);
		}

		$permission_list = $this->permission_model->getTree();

		$this->assign('permission_list',$permission_list);
		$this->assign('title', '角色详情');
		$this->display();
	}

	public function updateAction()
	{
		$this->permission('新建/修改角色','角色管理');

		$id = I('post.id');
		$name = I('post.name');
		$permission = I('post.permission');
		$permission = str_replace('，', ',', $permission);

		$role = array(
			'name' => $name,
			'permission' => $permission,
		);

		$condition['name'] = $name;
		$checkName = $this->role_model->getBy($condition);
		if ($checkName && $checkName['id']!=$id) {
			$this->error('该角色名已存在');
			exit();
		}

		if ($id=='') {
			$role['add_time'] = time();
			$res = $this->role_model->create($role);
			$this->success('新建成功',U('Role/detail/id/$res'));
		}else{
			$res = $this->role_model->update($id,$role);
			$this->success('修改成功');
		}

	}

	public function setStatusAction()
	{
		$this->permission('修改角色状态','角色管理');

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
		$res = $this->role_model->update($id,$data);

		redirect(U('Admin/Role/list/p/'.$p));
	}
}