<?php

	$cool = mysqli_connect('127.0.0.1','root','123456');
	mysqli_select_db($cool,'users');
	mysqli_set_charset($cool,'utf-8');
	mysqli_query($cool,"INSERT INTO users(name,pass,gender,hobby)values('小花','456','女','嗡嗡嗡')");
	echo "写入成功";