<?php

	$vn = mysqli_connect('localhost','root','123456');
	mysqli_select_db($vn,'users');
	mysqli_set_charset($vn,'utf-8');
	mysqli_query($vn,"insert into users (name,pass,gender,hobby)values('中天','123','男','爱上天')");
	echo "写入成功";