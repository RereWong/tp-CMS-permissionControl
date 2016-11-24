<?php
//检查图片，指定宽高大小和图片最大
function checkPicture($file,$r_width,$r_height){
	$returnarr=array('state'=>'-1','msg'=>'','date'=>'');
	$image = new \Think\Image();
	$image->open($file["tmp_name"]);
	$width = $image->width(); // 返回图片的宽度
	$height = $image->height(); // 返回图片的高度
	if($width < $r_width || $height < $r_height){
		$returnarr['state']='-1';
		$returnarr['msg']='图片大小不小于'.$r_width.'*'.$r_height.'像素';
		return $returnarr;
	}
	$returnarr['state']='1';
	return $returnarr;
}

function rule($array=array())
{
	//可以采用数组传参，也可以采用无限个参数方式传参
	if(!isset($array[0][0]))
		$array=func_get_args();
		
	if(is_array($array))
	{
		foreach($array as $vo)
		{
			if(is_array($vo)&&isset($vo[0])&&isset($vo[1]))
			{
				if(!$vo[0])
					return $vo[1];
			}
		}
	}
	return true;
}

//检查字符串长度
function len($str,$min=0,$max=255)
{
	$str=trim($str);
	if($str=='')
		return false;
	$len=getlen($str);
	if(($len>=$min)&&($len<=$max))
		return true;		
	else
		return false;	  
}
//检查字符串是否为空
function must($str)
{
	$str=trim($str);
	return $str==''?false:true;
}  

//检查两次输入的值是否相同
function same($str1,$str2)
{
	return $str1==$str2;
}
//检查用户名
function userName($str,$len_min=0,$len_max=255,$type='ALL')
 {
		if($str=='')
			return false;
		if(len($str,$len_min,$len_max)==false)
		{
				return false;
		}

		switch($type)
		{				//纯英文
						case "EN":$pattern="/^[a-zA-Z]+$/";break;							
							//英文数字                           
						case "ENNUM":$pattern="/^[a-zA-Z0-9]+$/"; break;
						  //允许的符号(|-_字母数字)   
						case "ALL":$pattern="/^[\-\_a-zA-Z0-9]+$/"; break; 
						//用户自定义正则
						default:$pattern=$type;break; 
		 }
		 
		if(preg_match($pattern,$str))
			 return true;
		else
			 return false;
 }

//验证邮箱
function email($str)
{
	if($str=='')
		return true;		
	$chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,6}\$/i";
	if (strpos($str, '@') !== false && strpos($str, '.') !== false){
		if (preg_match($chars, $str)){
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}
}
 //验证手机号码
 function mobile($str)
 {
	if ($str=='') {
		return true;
	}
	
	return preg_match('#^13[\d]{9}$|14^[0-9]\d{8}|^15[0-9]\d{8}$|^18[0-9]\d{8}$|^17[0-9]\d{8}$#', $str);
}
 //验证固定电话
 function tel($str)
 {
	if ($str=='') {
		return true;
	}
	return preg_match('/^((\(\d{2,3}\))|(\d{3}\-))?(\(0\d{2,3}\)|0\d{2,3}-)?[1-9]\d{6,7}(\-\d{1,4})?$/', trim($str));
	
}
 //验证qq号码
 function qq($str)
 {
	if ($str=='') {
		return true;
	}
	
	return preg_match('/^[1-9]\d{4,12}$/', trim($str));
}
 //验证邮政编码
 function zipCode($str)
 {
	if ($str=='') {
		return true;
	}
	
	return preg_match('/^[1-9]\d{5}$/', trim($str));
}
//验证ip
function ip($str)
{
	if($str=='')
		return true;	
	
	if (!preg_match('#^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$#', $str)) {
		return false;			
	}
	
	$ip_array = explode('.', $str);
	
	//真实的ip地址每个数字不能大于255（0-255）		
	return ($ip_array[0]<=255 && $ip_array[1]<=255 && $ip_array[2]<=255 && $ip_array[3]<=255) ? true : false;
}	
//验证身份证(中国)
function idCard($str)
{
	$str=trim($str);
	if($str=='')
		return true;	
		
	if(preg_match("/^([0-9]{15}|[0-9]{17}[0-9a-z])$/i",$str))
		 return true;
	else
		 return false;
 }

//验证网址
function url($str) 
{
	if($str=='')
		return true;	
	
	return preg_match("/^(http|https|ftp|ftps):\/\/[AZaz09]+\.[AZaz09]+[\/=\?%\&_~`@[\]\':+!]*([^<>\"\"])*$/", $str) ? true : false;

}