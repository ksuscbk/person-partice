<?php

	// 模拟数据库
	$users = array(
		"admin"=>123456,
		"jq"=>123456
	);
	// 获取前端提交的数据 
	$name = $_GET['name'];
	// 判断提交的用户名是否已存在
	if (array_key_exists($name,$users)) {
		echo "用户名已存在";
	} else {
		echo "用户名可用";
	}