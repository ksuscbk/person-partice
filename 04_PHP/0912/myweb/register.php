<?php

	// 获取前端提交的数据  尝试创建一个txt文档存储用户信息
	// print_r($_POST);
	// $file = fopen('./user.txt', 'a');
	// array_push($_POST, ",\r\n");
	// $user = implode(' ', $_POST);
	// fwrite($file, $user);
	// echo '注册成功，3秒后跳转到登陆界面';
	// fclose($file);
	// header('Refresh:3;url=login.html');

	// $file = fopen('./user.txt', 'a');
	// array_push($file, ",\r\n");
	// $user = implode(" ", $_POST);
	// fwrite($file, $user);
	// fclose($file);
	// echo "注册成功，2秒后跳转到登陆界面";
	// header('Refresh:3;url=login.php');


	$file = fopen('./user.txt', 'a');
	array_push($file, ",\r\n");
	$users = implode(" ", $_POST);
	fwrite($file, $users);
	fclose($file);
	echo "注册成功，2秒后跳转到登陆界面";
	header('Refresh:2;url=login.html');