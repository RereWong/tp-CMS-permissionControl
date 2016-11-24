<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Model;
use Exception;
//header('Access-Control-Allow-Origin: *');
class NewsController extends PermissionController {
	public $news_model;
	public function _initialize(){
		parent::_initialize();
		$this->news_model = D('news');
	}

	//获取内容列表
	public function indexAction()
	{
		$this->permission('内容列表','内容管理');

		$search['id'] = I('get.s_id');
		$search['keyword'] = I('get.s_keyword');
		$search['tag'] = I('get.s_tag');

		$count = $this->news_model->countBy($search);

		//分页
        $per_page = 10;
        $page = new \Think\Page($count,$per_page);
        $cur_page = $page->getNowPage($url);
        $show = $page->show();

        $list = $this->news_model->getListBy($search,$cur_page,$per_page);
        foreach ($list as $key => $value) {
        	$value['add_time'] = date('Y-m-d H:i:s',$value['add_time']);
        	if ($value['author']) {
        		$admin_model = D('admin');
        		$author = $admin_model->get($value['author']);
        		if ($author) {
        			$value['author_name'] = $author['name'];
        		}
        	}
        	$list[$key] = $value;
        }

        $this->assign('list', $list);
        $this->assign('search', $search);
        $this->assign('nowpage',$cur_page);
        $this->assign('title', '内容列表');
        $this->assign('page', $show);
        $this->display();
	}

	public function detailAction()
	{
		$this->permission('内容详情','内容管理');
		$id = I('get.id');

		if ($id) {
			$condition['id'] = $id;
			$info = $this->news_model->getBy($condition);
			$this->assign('title', '编辑内容');
		}else{
			$this->assign('title', '新建内容');
		}
		
		$this->assign('info', $info);
        $this->display();
	}

	//编辑内容
	public function updateAction()
	{
		$this->permission('新建/编辑内容','内容管理');

		$class = I('post.class');
		$type = I('post.type');
		$title = I('post.title');
		$tag = I('post.tag');
		$content = I('post.content');
		$video_url = I('post.video_url');

		$id = I('post.id');
		$tag = str_replace('，', ',', $tag);

		$data = array(
			'class' => $class,
			'type' => $type,
			'title' => $title,
			'tag' => $tag,
			'content' => $content,
		);
		if ($type=="2") {
			$data['subject_url'] = $video_url;
		}else{
			//上传头像图片并处理
			if($_FILES['img']){
				$img = A('Upload','Event')->uploadimg($_FILES['img']);
			}
		}

		if ($id) {
			$condition['id'] = $id;
			$old_info = $this->news_model->getBy($condition);
			
			$content = auto_save_image($content,'public/upload/news/'.$id);
			$content = str_replace('src="public/upload/','src="'.__PUBLIC__.'/upload/',$content);

			$data['content'] = $content;

			//转存头像图片
			if($_FILES['img'] && $img['state']==1){ 
				$savepath = 'news/'.$id.'/';
				A('Image','Event')->thumbimg(450,365,$savepath,$img['data']['savename']);
				$img_url = "thumb_".$img['data']['savename'];	
				$data['subject_url'] = $img_url;
			}
			$res = $this->news_model->update($id,$data);
			if ($res) {
				if ($tag) {
					$tag_arr = explode(',', $tag);
					$old_arr = explode(',', $old_info['tag']);
					foreach ($tag_arr as $key => $value) {
						if (!in_array($value, $old_arr)) {
							$this->dealTag($value);
						}
					}
				}
				$this->success('修改成功',U('Admin/News/detail/id/'.$id));
				exit();
			}
		}else{
			$data['author'] = $this->adminInfo['id'];
			$res = $this->news_model->create($data);

			if($_FILES['img'] && $img['state']==1){ 
				$savepath = 'news/'.$res.'/';
				A('Image','Event')->thumbimg(450,365,$savepath,$img['data']['savename']);
				$img_url = "thumb_".$img['data']['savename'];	
				$data2['subject_url'] = $img_url;
			}

			$content = auto_save_image($content,'public/upload/news/'.$id);
			$content = str_replace('src="public/upload/','src="'.__PUBLIC__.'/upload/',$content);
			$data2 = array('content'=>$content);
			$this->news_model->update($res,$data2);

			//创建tag，或者增加使用次数
			if ($res) {
				if ($tag) {
					$tag_arr = explode(',', $tag);
					foreach ($tag_arr as $key => $value) {
						if ($value) {
							$this->dealTag($value);
						}
					}
				}
				$this->success('新建成功',U('Admin/News/detail/id/'.$res));
				exit();
			}
		}

		$this->error('操作失败');
	}

	public function dealTag($name)
	{
		$tag_model = D('tag');
		$condition['name'] = $name;
		$tag = $tag_model->getBy($condition);
		if ($tag) {	
			//tag存在，增加次数
			$update_tag = $tag_model->addUseCount($tag['id']);
		}else{
			//tag不存在，新建
			$data = array(
				'name' => $value,
				'use_count' => 1,
			);
			$new_tag = $tag_model->create($data);
		}
	}

	//修改内容状态
	public function setStatusAction()
	{
		$this->permission('修改内容状态','内容管理');

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
		$res = $this->news_model->update($id,$data);

		redirect(U('Admin/News/index/p/'.$p));
	}
}