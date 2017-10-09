<?php

	// 获取提交的数据
	$username = $_POST['username'];
	$pwd = $_POST['pass'];
	// 从用户表里查出用户
	$res = fopen('./user.txt', 'r');
	// 取出用户信息放在数组中
	$users = array();
	while ($txt = fgets($res)) {
		// var_dump(fgetc($res));
		array_push($users, $txt);
		var_dump(fgets($res));
	}
	fclose($res);

	// 把每一个用户名和密码存成一个新数组
	// print_r($users);
	$userarr = array();
		// var_dump($users);
	foreach ($users as $key => $value) {
		$use = explode(' ', $value);
		array_pop($use);
		$userarr[$use[0]] = $use[1];
	}
	// print_r($userarr);
	// 判断登录是否成功
	if (array_key_exists($username, $userarr)) {
		if ($pwd == $use[1]) {
			echo "登陆成功";
		} else {
			echo "用户名或密码不正确";
		}
	} else {
		echo "没有此用户";
	}