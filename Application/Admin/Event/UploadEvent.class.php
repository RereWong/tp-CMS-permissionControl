<?php
namespace Admin\Event;
class UploadEvent{
    protected $Upload;
    public function __construct(){
        $this->Upload = new \Think\Upload();// 实例化上传类
    }
    public function uploadimg($file,$filename=""){
        $returnarr=array('state'=>'-1','msg'=>'','data'=>'');
        $this->Upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $this->Upload->rootPath  =      './Public/upload/'; // 设置附件上传根目录
        $this->Upload->savePath  =      'temp/'; // 设置附件上传目录
        $this->Upload->autoSub   = false;
        $this->Upload->maxSize = 3145728 ;// 设置附件上传大小
        if($filename!=""){
            $this->Upload->saveName = $filename;
        }else{
            $this->Upload->saveName = rand(1000,9999).time();
        }
        $info   =   $this->Upload->uploadOne($file);
        if(!$info) {// 上传错误提示错误信息
            $returnarr["msg"]=L("system_msg_imgupload_error");
            //$returnarr["msg"]=$this->Upload->getError();
            return $returnarr;
            //$this->error($this->Upload->getError());
        }else{// 上传成功 获取上传文件信息
            $returnarr["data"]=$info;
            $returnarr["state"]="1";
            return $returnarr;
            //return $info['savepath'].$info['savename'];
        }
    }
    public function uploadfile($file,$filename=""){
        $returnarr=array('state'=>'-1','msg'=>'','data'=>'');

        $this->Upload->exts      =     array('doc','docx','ppt','pptx','pdf','rar','zip','7z','tar');// 设置附件上传类型
        $this->Upload->rootPath  =      './Public/upload/'; // 设置附件上传根目录
        $this->Upload->savePath  =      'temp/'; // 设置附件上传目录
        $this->Upload->autoSub   = false;
        $this->Upload->maxSize=51200000 ;// 设置附件上传大小
        if($filename!=""){
            $this->Upload->saveName = $filename;
        }else{
            $this->Upload->saveName = rand(1000,9999).time();
        }
        //echo $filename."<br><br><br>";
        //echo rand(1000,9999).time();
        //exit();
        // 上传单个文件
        $info   =   $this->Upload->uploadOne($file);
        if(!$info) {// 上传错误提示错误信息
            //$returnarr["msg"]=L("system_msg_imgupload_error");
            $returnarr["msg"]=$this->Upload->getError();
            return $returnarr;
            //$this->error($this->Upload->getError());
        }else{// 上传成功 获取上传文件信息
            $returnarr["data"]=$info;
            $returnarr["state"]="1";
            return $returnarr;
            //return $info['savepath'].$info['savename'];
        }
    }
}