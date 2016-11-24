<?php
namespace Admin\Model;
use Think\Model;
class AdminModel extends Model {
	protected $tableName = 'admin_user'; 

	public function dealCondition($condition=array())
	{
		foreach ($condition as $key => $value) {
			if ($value=='') {
				unset($condition[$key]);
			}
		}
		
		if ($condition == array()) {
			$condition = '1=1';
		}

		return $condition;
	}

	public function countBy($condition=array())
	{
		$condition = $this->dealCondition($condition);

		$res = M('admin_user')->where($condition)->count();
        return $res;
	}

	public function getList($condition=array(),$cur_page,$listRows)
	{
		$condition = $this->dealCondition($condition);

		$limit_start = $listRows * ($cur_page - 1);
        $limit = $limit_start . ',' . $listRows;

        $list = M('admin_user')
        		->where($condition)
        		->field('id,name,super_admin,role,permission,FROM_UNIXTIME(add_time) as add_time,FROM_UNIXTIME(update_time) as update_time,status')
        		->order('status DESC,add_time DESC')
        		->limit($limit)
        		->select();
        return $list;
	}

	public function get($id)
	{
		$info = M('admin_user')->where("id='{$id}' and status=1")->find();
        return $info;
	}

	public function getBy($condition=array())
	{
		$condition['status'] = 1;
		$info = M('admin_user')->where($condition)->find();
        return $info;
	}

	public function create($data)
	{
		$data['add_time'] = time();
		$data['update_time'] = time();
		$data['op_id'] = $this->adminInfo['id'];
		$data['status'] = 1;

		$res = M('admin_user')->data($data)->add();
        return $res;
	}

	public function update($id,$data)
	{
		$data['update_time'] = time();
		$data['op_id'] = $this->adminInfo['id'];

		$res = M('admin_user')->where("id='{$id}'")->data($data)->save();
        return $res;
	}
}