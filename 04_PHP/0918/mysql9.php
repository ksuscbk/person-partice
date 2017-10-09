<?php

	$ttt = mysqli_connect('localhost','root','123456');
	mysqli_select_db($ttt,'users');
	mysqli_set_charset($ttt,'utf-8');
	mysqli_query($ttt,"insert into users (name,pass,gender,hobby)values('焦','555','男','打游戏')");
	echo "写入成功";