<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Model;
class UserController extends PermissionController {
	public $user_model;
	public function _initialize(){
		parent::_initialize();
		$this->user_model = D('user');
	}

	public function indexAction()
	{
		$this->permission('用户列表','用户管理');

		$search['nickname'] = I('get.s_nickname');
		$search['phone'] = I('get.s_phone');
		$search['mail'] = I('get.s_mail');

		$count = $this->user_model->countBy($search);

		//分页
        $per_page = 10;
        $page = new \Think\Page($count,$per_page);
        $cur_page = $page->getNowPage();
        $show = $page->show();

        $list = $this->user_model->getListBy($search,$cur_page,$per_page);

        $this->assign('list', $list);
        $this->assign('search', $search);
        $this->assign('nowpage',$cur_page);
        $this->assign('title', '用户列表');
        $this->assign('page', $show);
        $this->display();
	}

	public function detailAction()
	{
		$this->permission('用户详情','用户管理');
		$id = I('get.id');
		if ($id) {
			$condition['id'] = $id;
			$info = $this->user_model->getBy($condition);
			unset($info['password']);
			$this->assign('info', $info);
		}
			
        $this->assign('title', '用户详情');
        $this->display();
	}

	//修改用户状态
	public function setStatusAction()
	{
		$this->permission('修改用户状态','用户管理');

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
		$res = $this->user_model->update($id,$data);

		redirect(U('Admin/User/index/p/'.$p));
	}

	//编辑用户信息
	public function updateAction()
	{
		$this->permission('编辑用户信息','用户管理');

		$id = I('post.id');
		$nickname = I('post.nickname');
		$phone = I('post.phone');
		$mail = I('post.mail');
		$brief = I('post.brief');
		$sex = I('post.sex');
		$birthday = I('post.birthday');
		//$head_img = I('post.head_img');

		$data = array(
			'nickname' => $nickname,
			'phone' => $phone,
			'mail' => $mail,
			'brief' => $brief,
			'sex' => $sex,
			'birthday' => $birthday,
		);
		if ($id=='') {
			$this->error('参数不完整');
		}else{
			$res = $this->user_model->update($id,$data);
			$this->success('修改用户信息成功');
		}

	}
}