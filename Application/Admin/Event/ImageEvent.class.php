<?php
namespace Admin\Event;
class ImageEvent {
    protected $Image;
    public $rootpath = './Public/upload/';
    public function __construct(){
        $this->Image = new \Think\Image();// 实例化图片类
    }
    public function thumbimg($wide,$high,$savepath,$image){//裁切并另存
        $savepath = $this->rootpath.$savepath;
        $this->Image->open('./Public/upload/temp/'.$image);
        // 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.jpg 
        
        create_folders($savepath);//创建文件夹
        $img=$this->Image->thumb($wide,$high,\Think\Image::IMAGE_THUMB_CENTER)->save($savepath.'thumb_'.$image);
        rename('./Public/upload/temp/'.$image,$savepath.$image);
    }
    public function thumbcover($wide,$high,$image){//原图裁切并保存
        $this->Image->open('./Public/upload/temp/'.$image);
        // 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.jpg
        @unlink('./Public/upload/temp/'.$image);
        $img=$this->Image->thumb($wide,$high,\Think\Image::IMAGE_THUMB_CENTER)->save('./Public/upload/temp/'.$image);
    }
    public function thumbmore($array,$savepath,$image){//裁切多张图片并另存
        $savepath = $this->rootpath.$savepath;
        //$array {"wide":100,"high":200,"byname":"small_"}
        $this->Image->open('./Public/upload/temp/'.$image);
        //$type = $this->Image->type();
       // $imagename=str_replace(".".$type,"",$image);
        create_folders($savepath);//创建文件夹
        if($array){
            foreach($array as $rs){
                $wide=$rs["wide"];
                $high=$rs["high"];
                $this->Image->thumb($wide,$high,\Think\Image::IMAGE_THUMB_CENTER)->save($savepath.$rs["byname"].$image);
            }
        }
        //$img=$this->Image->thumb($wide,$high,\Think\Image::IMAGE_THUMB_CENTER)->save($savepath.'thumb_'.$image);
        rename('./Public/upload/temp/'.$image,$savepath.$image);
    }
}