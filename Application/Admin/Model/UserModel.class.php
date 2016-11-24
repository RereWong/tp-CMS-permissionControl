<?php
namespace Admin\Model;
use Think\Model;
class UserModel extends Model {
	protected $tableName = 'user'; 

	public function dealCondition($condition=array())
	{
		foreach ($condition as $key => $value) {
			if ($value=='') {
				unset($condition[$key]);
			}
		}
		if ($condition['mail']!='') {
			$condition['mail'] = array('LIKE','%'.$condition['mail'].'%');
		}
		if ($condition['phone']!='') {
			$condition['phone'] = array('LIKE','%'.$condition['phone'].'%');
		}
		if ($condition == array()) {
			$condition = '1=1';
		}
		return $condition;
	}

	public function countBy($condition=array())
	{
		$condition = $this->dealCondition($condition);

		$res = M('user')->where($condition)->count();
        return $res;
	}

	public function getListBy($condition=array(),$p=1,$per_page=10)
	{
		$condition = $this->dealCondition($condition);	
		$limit = (($p-1)*$per_page).','.$per_page;
		
		$list = M('user')
				->where($condition)
				->order('status DESC,add_time DESC')
				->field('id,nickname,head_img,phone,mail,brief,channel,FROM_UNIXTIME(add_time) as add_time,status')
				->limit($limit)
				->select();
        return $list;
	}

	public function getBy($condition)
	{
		$condition['status'] = 1;
		$info = M('user')->where($condition)->find();
        return $info;
	}

	//添加用户
	public function addUser($user)
	{
		$user['add_time'] = time();
		$user['status'] = 1;	
		$userId = M('user')->data($user)->add();
		return $userId;
	}

	//通过手机号获取用户
	public function getUserByPhone($phone)
	{
		$info = M('user')->where("phone='{$phone}' and status=1")->find();
		return $info;
	}

	//通过邮箱获取用户
	public function getUserByMail($mail)
	{
		$info = M('user')->where("mail='{$mail}' and status=1")->find();
		return $info;
	}

	//通过手机号或邮箱获取用户
	public function getUserByAccount($account)
	{
		$info = M('user')->where("(phone='{$account}' or mail='{$account}') and status=1")->find();
		return $info;
	}

	public function update($id,$data)
	{
		$data['update_time'] = time();
		$data['op_id'] = $this->adminInfo['id'];

		$res = M('user')->where("id='{$id}'")->data($data)->save();
        return $res;
	}
}