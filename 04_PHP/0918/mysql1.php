<?php

	// 获取数据库资源类型
	$abc = mysqli_connect('localhost','root','123456');
	// 选择数据库 
	mysqli_select_db($abc,'users');
	// 设置字符集
	mysqli_set_charset($abc,'utf-8');
	// 操作数据
	mysqli_query($abc,"insert into users(name,pass,gender,hobby)values('小天','321','男','大司马')");
	echo "写入成功";