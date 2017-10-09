<?php
	// php通过超全局数组获取请求头
	$agent = $_SERVER['HTTP_USER_AGENT'];
	var_dump($agent);

	// if (strpos($agent, 'iPhone')) {
	// 	header('Location:http://www.baidu.com');
	// } else {
	// 	header('Location:http://www.jd.com');
	// }