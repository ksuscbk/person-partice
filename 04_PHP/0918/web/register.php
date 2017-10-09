<?php

	// 接受前端数据
	print_r($_POST);

	// 连接数据库

	$connect = mysqli_connect('localhost', 'root', '123456');

		// 选择
	mysqli_select_db($connect,'users');
		//设置编码
	mysqli_set_charset($connect, 'utf8');
		// 添加数据
	mysqli_query($connect,"insert into users values('" . $_POST['name'] . "','" . $_POST['pass'] . "','" . $_POST['gender'] . "','" . implode('|', $_POST['hobby']) . "')");
	// 操作数据库


	// 响应结果