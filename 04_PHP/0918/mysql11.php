<?php

	// 建立和数据库连接  打开数据库
	$cool = mysqli_connect('localhost','root','123456');
	// 绑定数据所在的表
	mysqli_select_db($cool,'users');
	// 设定字符编码
	mysqli_set_charset($cool,'utf-8');
	// 操作数据库
	mysqli_query($cool,"insert into users(name,pass,gender,hobby)values('咖啡','234','女','喝奶茶')");
	echo "咖啡写入成功";