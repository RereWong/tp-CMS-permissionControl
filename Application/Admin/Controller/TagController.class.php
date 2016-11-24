<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Model;
class TagController extends PermissionController {
	public $tag_model;
	public function _initialize(){
		parent::_initialize();
		$this->tag_model = D('tag');
	}

	public function indexAction()
	{
		$this->permission('标签列表','标签管理');

		$search['id'] = I('get.s_id');
		$search['name'] = I('get.s_name');

		$count = $this->tag_model->countBy($search);

       	$queryString = '';
        if ($_SERVER["QUERY_STRING"] != '') {
            $queryString = '?' . $_SERVER["QUERY_STRING"];
        }

        $listRows = I('get.num') ? I('get.num') : 10;//每页显示的信息条数
        $page = new \Think\Page($count,$listRows);
        $cur_page = $page->getNowPage($url);
        $show = $page->show();

		$list = $this->tag_model->getList($search,$cur_page,$listRows);

		$this->assign('list',$list);
		$this->assign('search',$search);
		$this->assign('nowpage',$cur_page);
		$this->assign('title', '标签列表');
        $this->assign('page', $show);
		$this->display();
	}

}