<?php
namespace Admin\Model;
use Think\Model;
class RoleModel extends Model {
	protected $tableName = 'admin_role'; 

	public function countBy($condition=array())
	{
		$res = M('admin_role')->where($condition)->count();
        return $res;
	}

	public function getAll()
	{
		$list = M('admin_role')
        		->field('id,name')
        		->where('status=1')
        		->select();
        return $list;
	}

	public function getList($cur_page,$listRows)
	{
		$limit_start = $listRows * ($cur_page - 1);
        $limit = $limit_start . ',' . $listRows;

        $list = M('admin_role')
        		->field('id,name,permission,FROM_UNIXTIME(add_time) as add_time,FROM_UNIXTIME(update_time) as update_time,status')
        		->order('status DESC,add_time DESC')
        		->limit($limit)->select();
        return $list;
	}

	public function get($id)
	{
		$info = M('admin_role')->where("id='{$id}' and status=1")->find();
        return $info;
	}

	public function getBy($condition=array())
	{
		$condition['status'] = 1;
		$info = M('admin_role')->where($condition)->find();
        return $info;
	}

	public function create($role)
	{
		$role['add_time'] = time();
		$role['update_time'] = time();
		$role['op_id'] = $this->adminInfo['id'];
		$role['status'] = 1;

		$res = M('admin_role')->data($role)->add();
        return $res;
	}

	public function update($id,$role)
	{
		$role['update_time'] = time();
		$role['op_id'] = $this->adminInfo['id'];

		$res = M('admin_role')->where("id='{$id}'")->data($role)->save();
        return $res;
	}

}

 