<?php
	
	// 打开文件 获取文件ID  没有当前文件时尝试创建
	$res = fopen('./user.txt', 'a');
	// 提交的数据后面加上逗号和换行
	array_push($_POST, ",\r\n");
	// 拼接成字符串时用空格隔开
	$user1 =  implode(' ', $_POST);
	// 写入
	if(fwrite($res, $user1)){
		echo "注册成功";
	}
	// 关闭
	fclose($res);


	// 存储用户名
	$use = fopen('username.txt', 'a');
	array_push($_POST, ",\r\n");
	$username = $_POST['username'];
	fwrite($use, $username);
	fclose($use);

	// 存储密码
	$psw = fopen('password.txt','a');
	array_push($_POST,",\r\n");
	fwrite($psw, $_POST['pass']);
	fclose($psw);
	echo "3秒后跳转到登录界面";
	header('Refresh:3;url=./login.html');