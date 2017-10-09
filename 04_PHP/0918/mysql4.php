<?php

	$cool = mysqli_connect('localhost','root','123456');
	mysqli_select_db($cool,'users');
	mysqli_set_charset($cool,'utf-8');
	mysqli_query($cool,"insert into users (name,pass,gender,hobby)values('小小','qwe','女','一壶酒')");
	echo "写入成功";