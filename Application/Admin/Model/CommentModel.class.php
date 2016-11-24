<?php
namespace Admin\Model;
use Think\Model;
class CommentModel extends Model {
	protected $tableName = 'news_comment'; 

	public function dealCondition($condition=array())
	{
		foreach ($condition as $key => $value) {
			if ($value=='') {
				unset($condition[$key]);
			}
		}
		if ($search['content']) {
			$search['content'] = array('LIKE','%'.$search['content'].'%');
		}
		if ($condition == array()) {
			$condition = '1=1';
		}

		return $condition;
	}

	public function countBy($condition=array())
	{
		$condition = $this->dealCondition($condition);
		
		$res = M('news_comment')->where($condition)->count();
        return $res;
	}

	public function getList($condition=array(),$cur_page,$listRows)
	{
		$condition = $this->dealCondition($condition);

		$limit_start = $listRows * ($cur_page - 1);
        $limit = $limit_start . ',' . $listRows;

        $list = M('news_comment')
        		->field('*,FROM_UNIXTIME(add_time) as add_time,FROM_UNIXTIME(update_time) as update_time')
        		->where($condition)
        		->order('status DESC,add_time DESC')
        		->limit($limit)
        		->select();
        return $list;
	}

	public function get($id)
	{
		$info = M('news_comment')->where("id='{$id}' and status=1")->find();
        return $info;
	}

	/*public function create($role)
	{
		$role['add_time'] = time();
		$role['update_time'] = time();
		$role['op_id'] = $this->adminInfo['id'];
		$role['status'] = 1;

		$res = M('news_comment')->data($role)->add();
        return $res;
	}*/

	public function update($id,$data)
	{
		$data['update_time'] = time();
		$data['op_id'] = $this->adminInfo['id'];

		$res = M('news_comment')->where("id='{$id}'")->data($data)->save();
        return $res;
	}

}

 