h <?php
return array(
	//'配置项'=>'配置值'
	'SITEINFO_TITLE'        =>  "CMS",   //网站名称
	
	'URL_CASE_INSENSITIVE'  =>  true,             //使url不区分大小写
	'URL_MODEL'             =>  2,                //URL模式
	'ACTION_SUFFIX'         =>  'Action',         // 操作方法后缀
	'TMPL_FILE_DEPR'		=>	'_',
	
	'TMPL_TEMPLATE_SUFFIX'  =>  '.php',           //模版后缀
	//'DEFAULT_FILTER'        =>  'strip_tags,htmlspecialchars', //设置支持两种方式过滤
	'SHOW_PAGE_TRACE'       =>  false,             // 显示页面Trace信息	

	'SESSION_AUTO_START'	=> true,

	'TMPL_CACHE_ON' => false,//禁止模板编译缓存
	'HTML_CACHE_ON' => false,//禁止静态缓存 

	//数据库配置信息
	'DB_TYPE'   => 'mysql',                   // 数据库类型
	'DB_HOST'   => 'localhost',               // 服务器地址
	'DB_NAME'   => 'TEST',         // 数据库名
	'DB_USER'   => 'test',         // 用户名
	'DB_PWD'    => 'password',        // 密码
	'DB_PORT'   => 3306,                      // 端口
	'DB_PREFIX' => '',                   // 数据库表前缀 
	'DB_CHARSET'=> 'utf8',                    // 字符集
	'DB_DEBUG'  =>  TRUE,                     // 数据库调试模式 开启后可以记录SQL日志 3.2.3新增
);