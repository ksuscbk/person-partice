<?php

	$l = mysqli_connect('localhost','root','123456');
	mysqli_select_db($l,'users');
	mysqli_set_charset($l,'utf-8');
	mysqli_query($l,"insert into users(name,pass,gender,hobby)values('小兵','hjk','女','俯卧撑')");
	echo "写入成功";