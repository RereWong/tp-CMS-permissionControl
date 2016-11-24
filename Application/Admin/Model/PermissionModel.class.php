<?php
namespace Admin\Model;
use Think\Model;
class PermissionModel extends Model {
	protected $tableName = 'permission'; 

	//新建权限
	public function create($tag,$title,$p_id=0)
	{
		$data = array(
				'tag' => $tag,
				'title' => $title,
				'p_id' => $p_id,
				'add_time' => time(),
				'status' => 1,
			);
		$res = M('permission')->data($data)->add();
		return $res;
	}

	public function getTree($id=0)
	{
		$trunk = $this->getPermissionByPid($id);
		$list = array(); 
		if ($trunk) {
			foreach ($trunk as $key => $value) {
				$branch = $this->getTree($value['id']);
				if ($branch) {
					$value['children'] = $branch;
				}
				$list[] = $value;
			}
		}
		return $list;
	}

	public function getPermissionByPid($pid=0)
	{
		$list = M('permission')->where("p_id='{$pid}' and status=1")->field('id,title')->select();
		return $list;
	}

	public function getPermissionArrByIds($ids)
	{
		$list = $this->getTree();
		$id_arr = explode(',', $ids);

		$list = $this->checkTree($list,$id_arr);
		return $list;
	}

	public function checkTree($arr,$id_arr)
	{
		foreach ($arr as $key => $value) {
			if (!in_array($value['id'],$id_arr)) {
				unset($arr[$key]);
			}elseif ($arr['children']) {
				$children = $this->checkTree($arr,$id_arr);
				$arr[$key]['children'] = $children;
			}
		}
		return $arr;
	}
}