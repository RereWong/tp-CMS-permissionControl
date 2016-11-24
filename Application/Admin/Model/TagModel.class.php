<?php
namespace Admin\Model;
use Think\Model;
class TagModel extends Model {
	protected $tableName = 'tag'; 

	public function dealCondition($condition=array())
	{
		foreach ($condition as $key => $value) {
			if ($value=='') {
				unset($condition[$key]);
			}
		}
		
		$condition['status'] = 1;

		return $condition;
	}

	public function countBy($condition=array())
	{
		$condition = $this->dealCondition($condition);

		$res = M('tag')->where($condition)->count();
        return $res;
	}

	public function getList($condition=array(),$cur_page,$listRows)
	{
		$condition = $this->dealCondition($condition);

		$limit_start = $listRows * ($cur_page - 1);
        $limit = $limit_start . ',' . $listRows;

        $list = M('tag')
        		->where($condition)
        		->field('id,name,use_count')
        		->order('use_count DESC')
        		->limit($limit)
        		->select();
        return $list;
	}

	public function getBy($condition)
	{
		$condition['status'] = 1;
		$info = M('tag')->where($condition)->find();
        return $info;
	}

	public function create($data)
	{
		$data['add_time'] = time();
		$data['status'] = 1;

		$res = M('tag')->data($data)->add();
        return $res;
	}

	public function update($id,$data)
	{
		$res = M('tag')->where("id='{$id}'")->data($data)->save();
        return $res;
	}

	//增加使用次数
	public function addUseCount($id)
	{
		$res = M('tag')->where("id='{$id}'")->setInc('use_count');
        return $res;
	}
}