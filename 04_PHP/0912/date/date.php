<?php

	// PHP 中使用 time 可以获取服务的时间
	// echo time();

	// echo '<br>';

	// echo microtime();
	
	// PHP 中 通过 date 可以将时间戳格式化
	
	// echo date('Y/m/d H:i:s', time());

	// PHP 可以将某些特殊的字符串转成时间戳
	echo date('Y-m-d', strtotime('-1year'));
?>