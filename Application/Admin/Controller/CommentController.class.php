<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Model;
class CommentController extends PermissionController {
	public $comment_model;
	public function _initialize(){
		parent::_initialize();
		$this->comment_model = D('comment');
	}

	public function indexAction()
	{
		$this->permission('评论列表','评论管理');

		$search['news_id'] = I('get.s_news_id');
		$search['content'] = I('get.s_content');

		$count = $this->comment_model->countBy($search);

       	$queryString = '';
        if ($_SERVER["QUERY_STRING"] != '') {
            $queryString = '?' . $_SERVER["QUERY_STRING"];
        }

        $listRows = I('get.num') ? I('get.num') : 10;//每页显示的信息条数
        $page = new \Think\Page($count,$listRows);
        $cur_page = $page->getNowPage($url);
        $show = $page->show();

		$list = $this->comment_model->getList($search,$cur_page,$listRows);

		$this->assign('list',$list);
		$this->assign('nowpage',$cur_page);
		$this->assign('search', $search);
		$this->assign('title', '评论列表');
        $this->assign('page', $show);
		$this->display();
	}

	/*public function detailAction()
	{
		$this->permission('评论详情','评论管理');
		$id = I('get.id');
		if ($id!='') {
			$info = $this->comment_model->get($id);
			
			$this->assign('info',$info);
		}
		$this->assign('title', '评论详情');
		$this->display();
	}*/

	public function setStatusAction()
	{
		$this->permission('修改评论状态','评论管理');

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

		$comment = array(
			'status' => $status,
		);
		$res = $this->comment_model->update($id,$comment);

		redirect(U('Admin/Comment/index/p/'.$p));
	}
}