<?php

	$cool = mysqli_connect('127.0.0.1','root','123456');
	mysqli_select_db($cool,'users');
	mysqli_set_charset($cool,'utf-8');
	mysqli_query($cool,"insert into users (name,pass,gender,hobby)values('小子','987','女','青莲下')");
	echo "写入成功";