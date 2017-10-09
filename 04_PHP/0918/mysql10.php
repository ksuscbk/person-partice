<?php

	$qwer = mysqli_connect('localhost','root','123456');
	mysqli_select_db($qwer,'users');
	mysqli_set_charset($qwer,'utf-8');
	mysqli_query($qwer,"insert into users(name,pass,gender,hobby)values('鸣人','567','男','雏田')");
	echo "写入失败";