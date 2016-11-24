<?php
namespace Admin\Model;
use Think\Model;
class NewsModel extends Model {
	protected $tableName = 'news'; 

	public function dealCondition($condition=array())
	{
		foreach ($condition as $key => $value) {
			if ($value=='') {
				unset($condition[$key]);
			}
		}

		if ($condition['keyword']) {
			$condition['_string'] = "title LIKE '%{$condition['keyword']}%' OR content LIKE '%{$condition['keyword']}%'";
		}
		if ($condition['tag']) {
			$condition['tag'] = array('LIKE','%'.$condition['tag'].'%');
		}

		if ($condition == array()) {
			$condition = '1=1';
		}

		return $condition;
	}

	public function countBy($condition=array())
	{
		$condition = $this->dealCondition($condition);

		$res = M('news')->where($condition)->count();
        return $res;
	}

	public function getListBy($condition=array(),$p=1,$per_page=10)
	{
		$condition = $this->dealCondition($condition);
		$limit = ($p-1)*$per_page.','.$per_page;
		
		$list = M('news')
				->where($condition)
				->order('status DESC,add_time DESC')
				->limit($limit)
				->select();
        return $list;
	}

	public function getBy($condition)
	{
		$condition['status'] = 1;
		$info = M('news')->where($condition)->find();
        return $info;
	}

	public function create($data)
	{
		$data['add_time'] = time();
		$data['update_time'] = time();
		$data['status'] = 1;

		$res = M('news')->data($data)->add();
        return $res;
	}

	public function update($id,$data)
	{
		$data['update_time'] = time();

		$res = M('news')->where("id='{$id}'")->data($data)->save();
        return $res;
	}
}