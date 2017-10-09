<?php

	// 1、接收前端数据
	// print_r($_POST);

	// 2、连接数据库

	// a)
	$connect = mysqli_connect('localhost', 'root', '123456');

	// 3、操作数据库

	// b) 选择器
	mysqli_select_db($connect, 'web');

	// c) 设置编码
	mysqli_set_charset($connect, 'utf8');

	// c) 数据库插入内容

	// insert into users values('小明','123456','男','写代码','河北省')
	$query = "insert into users values('" . $_POST['name'] . "','" . $_POST['pass'] . "','" . $_POST['gender'] . "','" . implode('|', $_POST['hobby']) . "','" . $_POST['hometown'] . "')";

	mysqli_query($connect, $query);

	// 4、响应结果

	echo '注册成功!';