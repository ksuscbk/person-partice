<?php
	// php通过超全局变量来获取请求头信息
	// 
	
	print_r($_SERVER);

	if (strpos($agent, 'iPhone')) {
		header('Loaction:http://www.m.baidu.com');
	} else {
		header('Loaction:http://ww.baidu.com');
	}
// echo date('Y-m-d',strtotime('-1century'));

	