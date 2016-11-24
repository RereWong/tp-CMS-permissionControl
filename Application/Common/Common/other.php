<?php
/**
 * 截取指定的字符长度并以省略号结尾
 * @param $str 字符串
 * @param $len 要截取的长度
 * @return string
 */
function ellipsis($str,$len){
	if(mb_strlen($str,'utf8')>$len){
		$str = left($str,$len).'...';
	}
	return $str;
}

//转意HTML代码
function shtmlspecialchars($string) {
	if(is_array($string)) {
	foreach($string as $key => $val) {
	$string[$key] = shtmlspecialchars($val);
	}
	} else {
	$string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4})|[a-zA-Z][a-z0-9]{2,5});)/', '&\\1',
	str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string));
	}
	return $string;
}
//清除HTML
function clearHTML($str){
	$return = strip_tags($str);
	$return = str_replace("　","",$return);
	$return = str_replace("&nbsp;","",$return);
	$return = str_replace(" ","",$return);
	$return = str_replace("　","",$return);
	return $return;
}
//过滤危险HTML代码
function uh($str){ 
	$farr = array(
	"/\s+/",//过滤多余的空白 
	"/<(\/?)(script|i?frame|style|html|body|title|link|meta|\?|\%)([^>]*?)>/isU",  //过滤 <script 等可能引入恶意内容或恶意改变显示布局的代码,如果不需要插入flash等,还可以加入<object的过滤 
	"/(<[^>]*)on[a-zA-Z]+\s*=([^>]*>)/isU",//过滤javascript的on事件  
	); 
	$tarr = array( 
	" ", 
	"&lt;\\1\\2\\3&gt;",//如果要直接清除不安全的标签，这里可以留空 
	"\\1\\2", 
	);
	$str = preg_replace($farr,$tarr,$str); 
	return $str; 
}

//截取字符串
function left($str,$len) { //解决中文被截成乱码的问题
	return mb_substr($str,0,$len,"utf-8");
}

//获取中文字符长度
function getlen($str)
{
    if($str==''){
        return 0;
    }
    if(function_exists('mb_strlen')){
        return mb_strlen($str,'utf-8');
    }else {
        preg_match_all("/./u", $str, $ar);
        return count($ar[0]);
    }
}

//创建文件夹
function create_folders($dir){
	return is_dir($dir) or (create_folders(dirname($dir)) and mkdir($dir, 0777));
}
//删除文件夹里的所有文件和文件夹本身
function deldir($dir) {
	$dh=opendir($dir);
	while($file=readdir($dh)) {
		if($file!="." && $file!="..") {
			$fullpath=$dir."/".$file;
			if(!is_dir($fullpath)) {
				unlink($fullpath);
			} else {
				deldir($fullpath);
			}
		}
	}

	closedir($dh);

	if(rmdir($dir)) {
		return true;
	} else {
		return false;
	}
}

//返回首页
function ReHome(){
	$HomeURL = "http://" . $_SERVER["SERVER_NAME"];
	if ($_SERVER["SERVER_PORT"] != "80") 
	{
	$HomeURL .= ":" . $_SERVER["SERVER_PORT"];
	}
	return $HomeURL;
}

//自动搜集内容中的图片
function auto_save_image($body,$folder){
	if($folder == '' || $body == ''){
		return $body;
	}
	set_time_limit(0);//取消程序执行超时时间
	$img_array = array();
    preg_match_all("/(src)=[\"|\'| ]{0,}(http:\/\/(.*)\.(gif|jpg|jpeg|bmp|png))[\"|\'| ]{0,}/isU", $body, $img_array);
    $img_array = array_unique($img_array[2]);
	if(count($img_array)>0){
		create_folders($folder);
		foreach($img_array as $key => $value){
			$value = trim($value);
			if(!strpos($value,$folder)){
				ob_start();
				readfile($value);
				$get_file = @ob_get_contents();
				$get_file_length = @ob_get_length();
				ob_end_clean();
				/*//解决防采集--------------------------------------------
				$refer = parse_url($value);
				$refer = $refer["host"];
				$option = array( 
				'http' => array( 
				'header' => "referer:$refer") 
				); 
				$context = stream_context_create($option); 
				$get_file = @file_get_contents($value, false, $context); 
				//----------------------------------------------------------*/
				$rndFileName = $folder . '/' . createRand() . strrchr($value,".");
				if($get_file && (float)$get_file_length > 3072){
					$fp = @fopen($rndFileName,"w");
					@fwrite($fp,$get_file);
					@fclose($fp);
					$body = preg_replace('|' . $value . '|', $rndFileName, $body);
				}
			}
		}
	}
	return $body;
}

//获取内容中符合条件的一张图片
function get_default_img($nr,$width=130,$height=85){
	if($nr == ''){
		return '';
	}
	$img_array = array();
    preg_match_all("/(src)=[\"|\'| ]{1,}((.*)\.(gif|jpg|jpeg|bmp|png))[\"|\'| ]{0,}/isU", $nr, $img_array);
    $img_array = array_unique($img_array[2]);
	if(count($img_array)>0){
		foreach($img_array as $key => $value){
			$value = trim($value);
			if(file_exists($value)){
				$imgsize = @getimagesize($value);
				$imgwidth = (int)$imgsize[0];
				$imgheight = (int)$imgsize[1];
				if($imgwidth >= $width && $imgheight >= $height){
					return $value;
				}
			}
		}
	}
	return '';
}
//整数判断
function IsNum($str){
	if(!is_numeric($str) || strpos($str,".") != false){
	return false;
	}else{
	return true;
	}
}
//人性化时间显示
function FeedTime($time){
	$feedTime = time() - $time;
	if($feedTime<30){
	return "刚刚";
	}
	if($feedTime < 60){
		return $feedTime . "秒前";
	}else{
		if($feedTime / 60 < 60){
			return  intval($feedTime/60) . "分钟前";
		}else{
			if($feedTime / 3600 < 24){
				return  intval($feedTime/3600) . "小时前";
			}else{
				if($feedTime / 86400 < 30){
					return  intval($feedTime/86400) . "天前";
				}else{
					return date('Y-m-d G:i:s',$time);
				}
			}
		}
	}
}
//删除public/upload/temp目录下超过1天的临时文件
function del_temp($dir){
	if (!is_dir($dir)){
		return false;
	}
	$handle = opendir($dir);
	while (($file = readdir($handle)) !== false){
		if ($file != "." && $file != ".."){
			$filemtime = filemtime("$dir/$file");
			if($filemtime && time()-(int)$filemtime > 86400){
				@unlink("$dir/$file");
			}
		}
	}
	if (readdir($handle) == false){
		closedir($handle);
	}
}

//格式化文本段落
function FormatText($Str){
	$str = trim($Str);                                   // 取得字串同时去掉头尾空格和空回车
	$str = str_replace("　","",$str);
	$str = str_replace("\r\n","<br />",$str);         // 用br标签取代换行符
	$str = str_replace("\n","<br />",$str);         // 用br标签取代换行符
	$str = autolink($str);
	return $str;
}
//获取当前页详细地址
function GetCurUrl()
{
	$pageURL = "http";
	if ($_SERVER["HTTPS"] == "on"){
		$pageURL .= "s";
	}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80"){
		$pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
	}else{
		$pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}

//根据时间戳返回星期几
function weekday($time){
	$weekday=array('星期日','星期一','星期二','星期三','星期四','星期五','星期六');
	return $weekday[date('w',$time)];
}
//发送404状态
function set404(){
	header("HTTP/1.1 404 Not Found");  
	header("Status: 404 Not Found");
	include("404.html");
	exit;  
}
//阿里大鱼短信接口
function alidayu($phone,$param,$signName='大鱼测试',$TemplateCode='SMS_6840021'){
	include "sdk/alidayu/TopSdk.php";
	$c = new TopClient;
	$c->appkey = '23334823';
	$c->secretKey = '7c4d8bbcd5649b573647cc9fec092d54';
	$req = new AlibabaAliqinFcSmsNumSendRequest;
	//$req->setExtend("123456");
	$req->setSmsType("normal");
	$req->setSmsFreeSignName($signName);
	$req->setSmsParam($param);
	$req->setRecNum($phone);
	$req->setSmsTemplateCode($TemplateCode);
	$resp = $c->execute($req);
	return $resp;
}

//json格式化返回
function retFormat($status=1,$msg='',$data=array())
{
	$json = json_encode(array(
			'status' => $status,
			'msg' => $msg,
			'data' => $data,
		));
	echo $json;
	exit();
}

//array格式化返回
function retArray($status=1,$msg='',$data=array())
{
	$array = array(
			'status' => $status,
			'msg' => $msg,
			'data' => $data,
		);
	return $array;
}
