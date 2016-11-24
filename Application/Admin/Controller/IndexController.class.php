<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function indexAction(){
    	/*for ($i=0; $i < 1000000; $i++) { 
    		echo "你很美\r\n";
    	}*/
       $this->display();
    }
}