<?php

	echo '正在学习使用php操作mysql';
	// 访问数据库
	// 默认不支持访问mysql  需要打开扩展文件
	// 1登录数据库  服务器地址  用户名  密码
	$content = mysqli_connect('localhost','root','123456');
	// var_dump($content);

	// 选择数据库
	mysqli_select_db($content,'student');
	// 设置编码集
	mysqli_set_charset($content,'utf-8');
	// 操作数据
	mysqli_query($content,"insert into student(name,gender,age) values('焦强','男','22')");